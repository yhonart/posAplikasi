<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrxKasKecilController extends Controller
{
    public function kasKecil (){
        return view('TrxKasKecil/main');
    }

    public function laporanKasKecil(){
        $userKasir = DB::table('users')
            ->get();

        return view('TrxKasKecil/laporanKasKecil', compact('userKasir'));
    }

    public function tableLaporan($kasir, $fromDate, $endDate){
        // echo $kasir;
        $tablePengeluaran = DB::table('view_trx_kas');
        if ($kasir <> '0') {
            $tablePengeluaran = $tablePengeluaran->where('kas_persCode',$kasir);
        }
        $tablePengeluaran = $tablePengeluaran->whereBetween('kas_date',[$fromDate,$endDate]);
        $tablePengeluaran = $tablePengeluaran->get();

        $mDanaTrx = DB::table('m_trx_kas_kasir')
            ->orderBy('m_id_dana','desc')
            ->first();

        return view('TrxKasKecil/laporanKasKecilTable', compact('tablePengeluaran','mDanaTrx','fromDate','endDate'));
    }
    public function cetakKasKecil($kasir, $fromDate, $endDate){
        // echo $kasir;
        $tablePengeluaran = DB::table('view_trx_kas');
        if ($kasir <> '0') {
            $tablePengeluaran = $tablePengeluaran->where('kas_persCode',$kasir);
        }
        $tablePengeluaran = $tablePengeluaran->whereBetween('kas_date',[$fromDate,$endDate]);
        $tablePengeluaran = $tablePengeluaran->get();

        $mDanaTrx = DB::table('m_trx_kas_kasir')
            ->orderBy('m_id_dana','desc')
            ->first();

        return view('TrxKasKecil/laporanKasKecilCetak', compact('tablePengeluaran','mDanaTrx','fromDate','endDate'));
    }
    public function addModalKas()
    {
        $noww = date("Y-m-d");

        $sumberDana = DB::table('tr_payment_record as a')
            ->select(DB::raw('SUM(a.total_payment) as totKasir'), 'b.created_by')
            ->leftJoin('tr_store as b','a.trx_code','=','b.billing_number')
            ->where([
                ['a.total_payment','!=','8'],
                ['a.date_trx',$noww]
                ])
            ->groupBy('b.created_by')
            ->get();
        return view('TrxKasKecil/modalLaporanKasKecilCetak', compact('sumberDana'));   
    }

    public function postingTambahSaldo(Request $reqPostAddModal)
    {
        $createdBy = Auth::user()->name;
        $nominal = $reqPostAddModal->nominal;
        $sumberDana = str_replace(".","",$reqPostAddModal->sumberDana);
        $selisih = str_replace(".","",$reqPostAddModal->selisih);
        $keterangan = $reqPostAddModal->keterangan;
        $namaBank = $reqPostAddModal->namaBank;
        $namaAkun = $reqPostAddModal->namaAkun;
        $nomorAkun = $reqPostAddModal->nomorAkun;

        DB::table('tr_kas')
            ->insert([
                'description'=>$keterangan,
                'kas_date'=>now(),
                'created_date'=>now(),
                'status'=>'1',
                'created_by'=>$createdBy,
                'nominal'=>$nominal,
                'sumber_dana'=>$sumberDana, 
                'bank_code'=>$namaBank,               
                'no_akun'=>$nomorAkun,               
                'sumber_lain'=>$namaAkun,
            ]);
        return back();
    }
}
