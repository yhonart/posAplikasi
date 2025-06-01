<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SalesController extends Controller
{
    public function main(){

    }

    public function daftarKunjungan (){

    }

    public function formKunjungan (){
        return view('Sales/formKunjungan');
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

        $createBy = Auth::user()->name;
        $companyID = Auth::user()->company;

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

        DB::table('tracking_sales')
            ->where([
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
                'company_id'=>$companyID
            ]);
        
    }

    public function salesDasboard (){
        
    }
}
