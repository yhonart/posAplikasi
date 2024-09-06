<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;


class AccountingController extends Controller
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
    
    public function getMenu () {
        $mastermenu = DB::table('m_submenu')
            ->where([
                'status'=>'1',
                'group_menu'=>'3',
                ])
            ->orderBy('ordering','asc')
            ->get();  
            
        $apmenu = DB::table('m_submenu')
            ->where([
                'status'=>'1',
                'group_menu'=>'4',
                ])
            ->orderBy('ordering','asc')
            ->get();  
            
        return view ('Accounting/main', compact('mastermenu','apmenu'));
    }
    
    public function stockList (){
        return view ('Stock/MasterData/stockIndex');
    }
    
    
    public function accounting (){
        $checkArea = $this->checkuserInfo();
        if (Auth::check()) {        
            return view ('Cashier/maintenancePage', compact('checkArea'));
        } else {
            return view ('login');
        }        
    }
    
    public function piutangPelanggan(){
        $checkArea = $this->checkuserInfo();
        $dbMCustomer = DB::table('m_customers')
            ->get();
        return view ('Accounting/piutangPelanggan', compact('checkArea','dbMCustomer'));
    }
}
