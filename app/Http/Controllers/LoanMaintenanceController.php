<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;


class LoanMaintenanceController extends Controller
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
    
    public function mainAdmin () {
        $dbMCustomer = DB::table('m_customers')
            ->get();

        return view('HutangCustomers/mainEditLoanCustomer', compact('dbMCustomer'));
    }

    public function modalEditLimit ($id){
        $selectCustomer = DB::table('m_customers')
            ->where('idm_customer',$id)
            ->first();

        return view('hutangCustomers/LimitEditCustomer', compact('selectCustomer'));
    }
}
