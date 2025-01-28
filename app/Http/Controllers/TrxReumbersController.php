<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $dateNow = date('Y-m-d');
        $thisNumber = $this->reumbersNumber();

        $mStaff = DB::table('m_sales')
            ->where('sales_status','1')
            ->get();
        
        $mAdmin = DB::table('users')
            ->get();
        //Tampilkan tanggal minggu kemarin.
        $today = strtotime('today');

        // Menghitung timestamp awal minggu sebelumnya (Senin)
        $lastMonday = strtotime('last monday', $today);

        // Menghitung timestamp akhir minggu sebelumnya (Minggu)
        $lastSunday = strtotime('last sunday', $today);

        // Memformat tanggal menjadi string dengan format yang diinginkan
        $startDate = date('Y-m-d', $lastMonday);
        $endDate = date('Y-m-d', $lastSunday);

        $akunTrs = DB::table('lap_kas_besar')
            ->select(DB::raw('SUM(debit) AS debit'), 'description', 'create_by')
            ->where('trx_code','1')
            ->whereBetween('trx_date',[$startDate, $endDate])
            ->groupBy('description','create_by')
            ->get();

        return view('TrxReumbers/addReumbers', compact('mStaff','mAdmin','akunTrs','thisNumber','startDate','endDate'));
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
}
