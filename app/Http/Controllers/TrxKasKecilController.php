<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrxKasKecilController extends Controller
{
    public function getMonday (){
        $timezone = 'Asia/Jakarta';
        Carbon::setLocale('id'); 

        // Tentukan tanggal hari ini
        $today = Carbon::now($timezone);

        // Tentukan hari pertama minggu ini (Senin)
        $firstDayOfThisWeek = $today->startOfWeek(Carbon::MONDAY);

        return $firstDayOfThisWeek;
    }

    public function kasKecil (){
        return view('TrxKasKecil/main');
    }

    public function laporanKasKecil(){
        $company = Auth::user()->company;
        $userKasir = DB::table('users')
            ->where('company',$company)
            ->get();

        return view('TrxKasKecil/laporanKasKecil', compact('userKasir'));
    }

    public function tableLaporan($kasir, $fromDate, $endDate){
        // echo $fromDate."/".$endDate;
        $firstDayThisWeek = $this->getMonday();
        // Tentukan hari pertama dari minggu
        $firstDayOfLastWeek = $firstDayThisWeek->copy()->subWeek();

        // Tentukan hari terakhir minggu (Minggu)
        $lastDayOfLastWeek = $firstDayOfLastWeek->copy()->endOfWeek(Carbon::SUNDAY);

        $lastWeekStartDate = date("Y-m-d", strtotime($firstDayOfLastWeek));
        $lastWeekEndDate = date("Y-m-d", strtotime($lastDayOfLastWeek));
        
        $company = Auth::user()->company;
        //sum transaksi minggu lalu :
        $trxKasKecil = DB::table('tr_kas')
            ->select(DB::raw('SUM(nominal) as nominal'))
            ->where([
                ['trx_code','2'],
                ['comp_id',$company]
                ])
            ->whereBetween('kas_date',[$lastWeekStartDate, $lastWeekEndDate])
            ->first(); 

        $mDanaTrx = DB::table('tr_kas')
            ->where([
                ['trx_code','1'],
                ['comp_id',$company]
                ])
            ->whereBetween('kas_date',[$lastWeekStartDate, $lastWeekEndDate])
            ->orderBy('idtr_kas','desc')
            ->first();
        
        if (!empty($mDanaTrx)) {
            $dateDana = $mDanaTrx->kas_date;
        }
        else {
            $dateDana = 0;
        }
        
        $beforeFromDate = date("Y-m-d", strtotime("-1 day", strtotime($fromDate)));
        

        $getAllTransaksi = DB::table('tr_kas')
            ->select(DB::raw("SUM('nominal') as nominal"))
            ->where([
                ['trx_code','2'],
                ['comp_id',$company]
            ])
            ->whereBetween('kas_date',[$dateDana,$beforeFromDate])
            ->first();
        
        $tablePengeluaran = DB::table('view_trx_kas');
        if ($kasir <> '0') {
            $tablePengeluaran = $tablePengeluaran->where([
                ['kas_persCode',$kasir]
            ]);
        }
        $tablePengeluaran = $tablePengeluaran->where('comp_id',$company);
        $tablePengeluaran = $tablePengeluaran->whereBetween('kas_date', [$fromDate, $endDate]);
        $tablePengeluaran = $tablePengeluaran->get();

        $mTrxKas = DB::table('m_trx_kas_kasir')
            ->where('comp_id',$company)
            ->first();

        return view('TrxKasKecil/laporanKasKecilTable', compact('tablePengeluaran','mDanaTrx','fromDate','endDate','trxKasKecil','mTrxKas','company'));
    }
    public function cetakKasKecil($kasir, $fromDate, $endDate){
        // echo $kasir;
        $company = Auth::user()->company;
        $tablePengeluaran = DB::table('view_trx_kas');
        if ($kasir <> '0') {
            $tablePengeluaran = $tablePengeluaran->where('kas_persCode',$kasir);
        }
        $tablePengeluaran = $tablePengeluaran->where('comp_id',$company);
        $tablePengeluaran = $tablePengeluaran->whereBetween('kas_date', [$fromDate, $endDate]);
        $tablePengeluaran = $tablePengeluaran->get();

        $mDanaTrx = DB::table('m_trx_kas_kasir')
            ->where('comp_id',$company)
            ->orderBy('m_id_dana','desc')
            ->first();

        return view('TrxKasKecil/laporanKasKecilCetak', compact('tablePengeluaran','mDanaTrx','fromDate','endDate'));
    }
    public function addModalKas()
    {
        $noww = date("Y-m-d");
        $company = Auth::user()->company;

        $sumberDana = DB::table('tr_payment_record as a')
            ->select(DB::raw('SUM(a.total_payment) as totKasir'), 'b.created_by')
            ->leftJoin('tr_store as b','a.trx_code','=','b.billing_number')
            ->where([
                ['a.total_payment','!=','8'],
                ['a.date_trx',$noww],
                ['a.comp_id',$company]
                ])
            ->groupBy('b.created_by')
            ->get();
        return view('TrxKasKecil/modalLaporanKasKecilCetak', compact('sumberDana'));   
    }

    public function postingTambahSaldo(Request $reqPostAddModal)
    {
        $createdBy = Auth::user()->name;
        $sumberDana = $reqPostAddModal->sumberDana;
        $nominal = str_replace(".","",$reqPostAddModal->nominal);
        $selisih = str_replace(".","",$reqPostAddModal->selisih);
        $keterangan = $reqPostAddModal->keterangan;
        $namaBank = $reqPostAddModal->namaBank;
        $namaAkun = $reqPostAddModal->namaAkun;
        $nomorAkun = $reqPostAddModal->nomorAkun;
        $company = Auth::user()->company;

        DB::table('tr_kas')
            ->insert([
                'description'=>$keterangan,
                'kas_date'=>now(),
                'created_date'=>now(),
                'status'=>'1',
                'created_by'=>$createdBy,
                'nominal'=>'0',
                'nominal_modal'=>$nominal,
                'sumber_dana'=>$sumberDana, 
                'bank_code'=>$namaBank,               
                'no_akun'=>$nomorAkun,               
                'sumber_lain'=>$namaAkun,
                'trx_code'=>'2',
                'comp_id'=>$company
            ]);
        return back();
    }

    public function boxContentDana(){
        $company = Auth::user()->company;
        $dateNow = Carbon::now();
        $dayNow = date('l', strtotime($dateNow));
        
        $modalFixed = DB::table('m_trx_kas_kasir')
            ->where('comp_id',$company)
            ->first();
            
        if ($dayNow == "Monday") {
            $compFixedDana = $modalFixed->nominal_dana;
        }
        else {
            $compFixedDana = 0;
        }

        return view('TrxKasKecil/mainBoxContentDana', compact('compFixedDana'));
    }
}
