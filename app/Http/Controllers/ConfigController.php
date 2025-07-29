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
        $countConfig = DB::table('config_delivery')
            ->where('customer_id',$idCus)
            ->count();
        $selectSchedule = DB::table('config_delivery')
            ->where('customer_id',$idCus)
            ->first();
        $customerCode = $customer->customer_code;
        $trackingSales = DB::table('tracking_sales as a')
            ->select('a.customer_code','b.product_code','b.product_name','b.idm_data_product')
            ->leftJoin('m_product as b','a.product_id','=','b.idm_data_product')
            ->where('a.customer_code',$customerCode)
            ->first();

        return view("Z_Additional_Admin/AdminConfig/ConfigCustomerDelivery", compact('customer','trackingSales','idCus','countConfig','selectSchedule'));
    }

    public function postConfigSchedule (Request $reqPostSchedule){
        $getDay = $reqPostSchedule->getDay;
        $getFreq = $reqPostSchedule->getFreq;
        $getIdCus = $reqPostSchedule->getIdCus;
        $createdBy = Auth::user()->name;

        if ($getDay == '0' && $getFreq == "") {
            $msg = array('warning' => 'Anda Harus Memilih Salah Satu Metode Jadwal Pengiriman !');
        }
        else {
            $countConfig = DB::table('config_delivery')
                ->where('customer_id',$getIdCus)
                ->count();

            if ($countConfig == '1') {
                DB::table('config_delivery')
                    ->where('customer_id',$getIdCus)
                    ->update([
                        'frequency'=>$getFreq,
                        'day_freq'=>$getDay,
                        'created_by'=>$createdBy,
                        'status'=>'1'
                    ]);
            }
            else {
                DB::table('config_delivery')
                    ->insert([
                        'customer_id'=>$getIdCus,
                        'frequency'=>$getFreq,
                        'day_freq'=>$getDay,
                        'created_by'=>$createdBy
                    ]);
            }
            $msg = array('success' => 'Data Berhasil Tersimpan !');
        }
        return response()->json($msg);
    }

    public function aturPembayaran ($idCus){
        $selectCustomer = DB::table('m_customers')
            ->where('idm_customer',$idCus)
            ->first();
        return view("Z_Additional_Admin/AdminConfig/ConfigCustomerPayment", compact('idCus','selectCustomer'));
    }

    public function postConfigPembayaran (Request $reqUpdatePayment){
        $idCus = $reqUpdatePayment->idCus;
        $pembayaran = $reqUpdatePayment->pembayaran;
        $tempo = $reqUpdatePayment->tempo;

        DB::table('m_customers')
            ->where('idm_customer',$idCus)
            ->update([
                'payment_type'=>$pembayaran,
                'payment_tempo'=>$tempo
            ]);
    }

    public function aturPenjualan ($cusCode){
        $mCustomer = DB::table('m_customers')
            ->where('customer_code',$cusCode)
            ->first();

        $customerOrder = DB::table('config_customer_order as a')
            ->select('a.*','b.product_name','b.product_code')
            ->leftJoin('m_product as b','b.idm_data_product','=','a.product_id')
            ->where('customer_code',$cusCode)
            ->get();

        return view("Z_Additional_Admin/AdminConfig/ConfigCustomerPenjualan", compact('mCustomer','customerOrder','cusCode'));

    }

    public function updateQty (Request $reqUpdateOrder){
        $tablename = $reqUpdateOrder->tablename;
        $column = $reqUpdateOrder->column;
        $editval = $reqUpdateOrder->editval;
        $id = $reqUpdateOrder->id;
        $idChange = $reqUpdateOrder->idChange;

        DB::table($tablename)
            ->where($idChange, $id)
            ->update([
                $column => $editval
            ]);
    }

    public function addOrder ($cusCode){
        $companyID = Auth::user()->company;
        $product = DB::table('m_product')
            ->where('comp_id',$companyID)
            ->get();
        return view("Z_Additional_Admin/AdminConfig/ConfigCustomerPenjualanAddOrder", compact('product','cusCode'));
    }

    public function postOrder (Request $reqpostOrder){
        $productID = $reqpostOrder->productID;
        $qtyOrder = $reqpostOrder->qtyOrder;
        $cusCode = $reqpostOrder->cusCode;
        $created = Auth::user()->name;

        DB::table('config_customer_order')
            ->insert([
                'product_id'=>$productID,
                'qty_order'=>$qtyOrder,
                'status'=>"1",
                'created_by'=>$created,
                'customer_code'=>$cusCode
            ]);

        return back();
    }

    public function configUser (){
        return view("Z_Additional_Admin/AdminConfig/ConfigUser");
    }

    public function tableAkunToko (){
        $compID = Auth::user()->company;
        $dbUsers = DB::table('users as a')
            ->where('a.company', $compID)
            ->get();
        return view("Z_Additional_Admin/AdminConfig/ConfigUserTableList", compact('dbUsers'));
    }
}
