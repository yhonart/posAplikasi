<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SalesController extends Controller
{
    public function codeCompany (){
        $companyID = Auth::user()->company;

        $selectCodeComp = DB::table('m_company')
            ->select('company_code')
            ->where('idm_company',$companyID)
            ->first();
        $compCode = $selectCodeComp->company_code;

        return $compCode;
    }

    public function numberCodeCustomer (){
        $companyCode = $this->codeCompany();
        $compID = Auth::user()->company;
        $countCusComp = DB::table('m_customers')
            ->where('comp_id',$compID)
            ->count();
        $numCus = "";
        if ($countCusComp == '0') {
            $number = '1';
            $numCus = "CUS" . $companyCode . "-" .sprintf("%03d",$number);
        }
        else {
            $number = $countCusComp + 1;
            $numCus = "CUS" . $companyCode . "-" .sprintf("%03d",$number);
        }

        return $numCus;
    }

    public function main(){

    }

    public function daftarKunjungan (){
        $myAccount = Auth::user()->name;
        $daftarKunjungan = DB::table('tracking_sales')
            ->where('create_by',$myAccount)
            ->orderBy('tracking_id','desc')
            ->get();

        return view('Sales/tableKunjungan', compact('daftarKunjungan'));
    }

    public function formKunjungan (){
        $companyID = Auth::user()->company;
        $product = DB::table('m_product')
            ->where('comp_id',$companyID)
            ->get();

        return view('Sales/formKunjungan', compact('product'));
    }

    public function postAddProduct (Request $reqPostProduk){
        $produkID = $reqPostProduk->productID;
        $qtyOrder = $reqPostProduk->qtyOrder;
        $created = Auth::user()->name;

        DB::table('config_customer_order')
            ->insert([
                'product_id'=>$produkID,
                'qty_order'=>$qtyOrder,
                'status'=>"1",
                'created_by'=>$created
            ]);

        return back();
    }

    public function tableProdukDeal (){
        $created = Auth::user()->name;
        $status = "1";
        
        $produkOrder = DB::table('config_customer_order as a')
            ->select('a.*','b.product_name')
            ->leftJoin('m_product as b','b.idm_data_product','=','a.product_id')
            ->where('a.created_by',$created)
            ->get();

        return view('Sales/tableProdukOrder', compact('produkOrder'));
    }

    public function postNewTransaksi (Request $dataKunjungan){
        $store = strtoupper($dataKunjungan->store);
        $storeOwner = strtoupper($dataKunjungan->storeOwner);
        $phone = $dataKunjungan->phone;
        $progress = $dataKunjungan->progress;
        $dateFU = $dataKunjungan->dateFU;
        $Latitude = $dataKunjungan->Latitude;
        $Longitude = $dataKunjungan->Longitude;
        $fotoToko = $dataKunjungan->fotoToko;
        $product = $dataKunjungan->produk;
        $address = $dataKunjungan->address;

        $createBy = Auth::user()->name;
        $companyID = Auth::user()->company;
        $numCodeCus = $this->numberCodeCustomer();

        if ($fotoToko <> "") {
            $getFotoToko = $fotoToko->getClientOriginalName();
            $dirPublic = public_path() . "/images/Upload/";
            $dirImage = $dirPublic . $store . "/";
            if (!file_exists($dirImage)) {
                mkdir($dirImage, 0777);
                $fotoToko->move($dirImage, $getFotoToko);
            }
            else{
                $fotoToko->move($dirImage, $getFotoToko);
            }
        }       

        if ($progress == '3') {
            DB::table('m_customers')
                ->insert([
                    'customer_code'=>$numCodeCus,
                    'customer_store'=>$store,
                    'address'=>$address,
                    'pic'=>$storeOwner,
                    'sales'=>$createBy,
                    'registered_date'=>now(),
                    'comp_id'=>$companyID
                ]);

            DB::table('tracking_sales')
                ->insert([
                    'store_name'=>$store,
                    'store_owner'=>$storeOwner,
                    'phone'=>$phone,
                    'progress'=>$progress,
                    'date_fu'=>$dateFU,
                    'latitude'=>$Latitude,
                    'longtitude'=>$Longitude,
                    'picture_store'=>$getFotoToko,
                    'create_by'=>$createBy,
                    'created_date'=>now(),
                    'company_id'=>$companyID,
                    'product_id'=>$product,
                    'customer_code'=>$numCodeCus
                ]);
        }
        else {
            DB::table('tracking_sales')
                ->insert([
                    'store_name'=>$store,
                    'store_owner'=>$storeOwner,
                    'phone'=>$phone,
                    'progress'=>$progress,
                    'date_fu'=>$dateFU,
                    'latitude'=>$Latitude,
                    'longtitude'=>$Longitude,
                    'picture_store'=>$getFotoToko,
                    'create_by'=>$createBy,
                    'created_date'=>now(),
                    'company_id'=>$companyID,
                    'product_id'=>$product
                ]);
        }
        
    }

    public function salesDasboard (){
        
    }

    public function detailCustomer ($id){

        $detailCus = DB::table('tracking_sales')
            ->where('tracking_id',$id)
            ->first();

        return view('Sales/detailCustomer', compact('detailCus'));
    }
    
}
