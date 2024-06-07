<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{    
    // CEK INFORMASI USER TERKAIT AREA KERJA YANG TERDAFTAR PADA SISTEM
    public function checkuserInfo (){
        $userID = Auth::user()->id;
        $cekUserArea = DB::table('users_area AS a')
            ->select('a.area_id','b.site_code','b.site_name')
            ->leftJoin('m_site AS b','a.area_id','=','b.idm_site')
            ->where('a.user_id',$userID)
            ->first();
        if (!empty($cekUserArea)) {
            # code...
            $userAreaID = $cekUserArea->area_id;            
        }
        else {
            $userAreaID = 0;
        }
        return $userAreaID;
    }
    
    public function mainDashboard (){
        $datenow = date("Y-m-d");
        
        $countPenjualan = DB::table('tr_store')
            ->where([
                ['tr_date',$datenow]
                ])
            ->count();
            
        $countProcess = DB::table('tr_store')
            ->where([
                ['tr_date',$datenow],
                ['status','2']
                ])
            ->count();
            
        $countKredit = DB::table('tr_store')
            ->where([
                ['tr_date',$datenow],
                ['status','3']
                ])
            ->count();
            
        $countcompleted = DB::table('tr_store')
            ->where([
                ['tr_date',$datenow],
                ['status','4']
                ])
            ->count();
            
        return view ('Dashboard/DashboardTransaksi', compact('countPenjualan','countProcess','countKredit','countcompleted'));
    }

    
}
