<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Carbon;
use Carbon\Carbon;
class TrxReumbersController extends Controller
{
    public function reumbersNumber ()
    {
        $thisPeriode = date("mY");

        $countPeriode = DB::table('tr_reumbersment')
            ->where('periode',$thisPeriode)
            ->count();

        if ($countPeriode == 0) {
            $no = 1;
            $numberR = "RMB" . $thisPeriode . "-". sprintf("%04d",$no);
        }
        else {
            $no = $countPeriode + 1;
            $numberR = "RMB" . $thisPeriode . "-". sprintf("%04d",$no);
        }

        return $numberR;
    }   
    public function trxReumbers ()
    {
        return view('TrxReumbers/main');
    }

    public function addReumbers ()
    {
        $timezone = 'Asia/Jakarta';
        Carbon::setLocale('id'); 

        // Tentukan tanggal hari ini
        $today = Carbon::now($timezone);
        $hariIni = Carbon::now();

        // Tentukan hari pertama minggu ini (Senin)
        $firstDayOfThisWeek = $today->startOfWeek(Carbon::MONDAY);

        // Tentukan hari pertama dari minggu sebelumnya
        $firstDayOfLastWeek = $firstDayOfThisWeek->copy()->subWeek();

        // Tentukan hari terakhir minggu sebelumnya (Minggu)
        $lastDayOfLastWeek = $firstDayOfLastWeek->copy()->endOfWeek(Carbon::SUNDAY);

        $dateNow = date('Y-m-d');
        $thisNumber = $this->reumbersNumber();

        $mStaff = DB::table('m_sales')
            ->where('sales_status','1')
            ->get();
        
        $mAdmin = DB::table('users')
            ->get();

        $startDate = date("Y-m-d", strtotime($firstDayOfLastWeek));
        $endDate = date("Y-m-d", strtotime($lastDayOfLastWeek));

        $akunTrs = DB::table('lap_kas_besar')
            ->select(DB::raw('SUM(debit) AS debit'), 'description', 'create_by')
            ->where('trx_code','1')
            ->whereBetween('trx_date',[$startDate, $endDate])
            ->groupBy('description','create_by')
            ->get();

        $modalMingguLalu = DB::table('tr_kas')
            ->select(DB::raw('SUM(nominal_modal) as nominal_modal'))
            ->where('trx_code','1')
            ->whereBetween('kas_date',[$startDate, $endDate])
            ->first();

        $modalTerpakai = DB::table('tr_kas')
            ->select(DB::raw('SUM(nominal) as nominal'))
            ->where('trx_code','2')
            ->whereBetween('kas_date',[$startDate, $endDate])
            ->first();   
        
        if (!empty($modalMingguLalu) OR !empty($modalTerpakai)) {
            $penguranganKas = $modalMingguLalu->nominal_modal - $modalTerpakai->nominal;
        }
        else {
            $penguranganKas = 0;
        }

        return view('TrxReumbers/addReumbers', compact('mStaff','mAdmin','akunTrs','thisNumber','startDate','endDate','firstDayOfLastWeek','lastDayOfLastWeek','penguranganKas','hariIni'));
    }

    public function postTransaksiReumbers(Request $reqPosting)
    {
        $nomor = $reqPosting->nomor;
        $keterangan = $reqPosting->keterangan;
        $fromAkunDana = explode("|",$reqPosting->fromAkunDana);
        $nominal = str_replace(".","",$reqPosting->nominal);
        $thisPeriode = date("mY");

        $fromDana = $fromAkunDana[0];
        $nominalDana = $fromAkunDana[1];

        $creator = Auth::user()->name;

        DB::table('tr_reumbersment')
            ->insert([
                'reumbers_no'=>$nomor,
                'description'=>$keterangan,
                'from_akun'=>$fromDana,
                'nominal_dana'=>$nominalDana,
                'create_date'=>now(),
                'create_by'=>$creator,
                'status'=>'1',
                'reumbers_date'=>now(),
                'nominal'=>$nominal,
                'periode'=>$thisPeriode,
            ]);
    }
    
    public function tableReumbers ()
    {
        $tbReumbers = DB::table('tr_reumbersment')
            ->orderBy('reumbers_id','desc')
            ->get();

        return view('TrxReumbers/tableReumbers',compact('tbReumbers'));
    }

    public function AppoveReumbers($idReumbers)
    {
        $saldo = 0;
        $creator = Auth::user()->name;
        DB::table('tr_reumbersment')
            ->where('reumbers_id',$idReumbers)
            ->update([
                'status'=>'1'
            ]);

        // Get Modal Terakhir 
        $lastModal = DB::table('tr_kas')
            ->where('nominal_modal','!=','')
            ->orderBy('idtr_kas','desc')
            ->first();

        $nomReumbeurs = DB::table('tr_reumbersment')
            ->where('reumbers_id',$idReumbers)
            ->first();
        $reumbers = $nomReumbeurs->nominal;
        $sumber_dana = $nomReumbeurs->from_akun;
        $lastID = $lastModal->idtr_kas;
        $nominal = $lastModal->nominal_modal;

        $getOtherTrx = DB::table('tr_kas')
            ->where('idtr_kas','>',$lastID)
            ->get();

        foreach ($getOtherTrx as $keyVal) {
            $saldo += $nominal - $keyVal->nominal;
        }

        $modal = $saldo + $reumbers;
        
        $description = "Modal Awal ". $modal;
        DB::table('tr_kas')
            ->insert([
                'description'=>$description,
                'kas_date'=>now(),
                'status'=>'1',
                'created_by'=>$creator,
                'nominal'=>'0',
                'sumber_dana'=>$sumber_dana,
                'nominal_modal'=>$modal
            ]);
    }
}
