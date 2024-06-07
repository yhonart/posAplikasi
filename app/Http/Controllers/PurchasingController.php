<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchasingController extends Controller
{
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

    public function mainPurch(){
        $checkArea = $this->checkuserInfo();
        return view ('Purchasing/Main/indexPR', compact('checkArea'));
    }

    //Purchase Request
    public function mainPurchaseReq (){
        $checkArea = $this->checkuserInfo();
    }
    
    //Purchase Order
    public function mainPurchaseOrder (){
        $checkArea = $this->checkuserInfo();
        return view ('Purchasing/PurchaseOrder/main', compact('checkArea'));
    }

    //Purchase Dashboard
    public function mainDashboard (){
        $checkArea = $this->checkuserInfo();
    }
}
