<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    public function mainConfigCustomer (){
        $compID = Auth::user()->company;
        $dbCustomer = DB::table('m_customers')
            ->where('comp_id',$compID)
            ->get();

        return view("Z_Additional_Admin/AdminConfig/ConfigCustomer", compact('dbCustomer'));
    }

    public function aturPengiriman ($idCus){
        $customer = DB::table('m_customers')
            ->where('idm_customer',$idCus)
            ->first();

        $customerCode = $customer->customer_code;
        $trackingSales = DB::table('tracking_sales as a')
            ->select('a.customer_code','b.product_code','b.product_name','b.idm_data_product')
            ->leftJoin('m_product as b','a.product_id','=','b.idm_data_product')
            ->where('a.customer_code',$customerCode)
            ->first();

        return view("Z_Additional_Admin/AdminConfig/ConfigCustomerDelivery", compact('customer','trackingSales','idCus'));
    }

    public function postConfigSchedule (Request $reqPostSchedule){
        $getDay = $reqPostSchedule->getDay;
        $getFreq = $reqPostSchedule->getFreq;
        $getIdCus = $reqPostSchedule->getIdCus;
        $createdBy = Auth::user()->name;

        DB::table('config_delivery')
            ->insert([
                'customer_id'=>$getIdCus,
                'frequuency'=>$getFreq,
                'day_freq'=>$getDay,
                'created_by'=>$createdBy
            ]);
    }
}
