<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;


class StoreController extends Controller
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

    // CEK JUMLAH TRANSAKSI DENGAN STATUS AKTIF DENGAN KODE 1
    public function checkProdActive (){
        $areaID = $this->checkuserInfo();
        $createdName = Auth::user()->name;
        $countActiveDisplay = DB::table('tr_store')
            ->where([
                ['status',1],
                ['store_id',$areaID],
                ['created_by',$createdName]
                ])
            ->count();
        return $countActiveDisplay;
    }

    // BUAT NOMOR TRANSAKSI
    public function checkBillNumber (){
        $areaID = $this->checkuserInfo();
        $trxActived = $this->checkProdActive();
        $thisDate = date("dmy");
        $dateDB = date("Y-m-d");
        
        // cek jumlah data delete transaksi
        $countDel = DB::table("tr_store")
            ->where([
                ['store_id', $areaID],
                ['tr_date',$dateDB],
                ['is_delete','1']
                ])
            ->count();
        // Jika tidak ada no struk yang di delete maka akan melakukan generate nomor baru
            if($countDel == '0'){
                $countTrx = DB::table("tr_store")
                    ->where([
                        ['store_id', $areaID],
                        ['tr_date',$dateDB]
                        ])
                    ->count();
                    
                if($countTrx == '0'){
                    $no = "1";
                    $pCode = "P".$thisDate."-".sprintf("%07d",$no);
                }
                else{
                    $no = $countTrx + 1;
                    $pCode = "P".$thisDate."-".sprintf("%07d",$no);
                }
            }
        // Jika lebih dari atau sama dengan 1 maka akan mengambil nomor struk yang lama. 
            elseif($countDel >= '1'){
                $countDel = DB::table("tr_store")
                    ->where([
                        ['store_id', $areaID],
                        ['tr_date',$dateDB],
                        ['is_delete','1']
                        ])
                    ->orderBy('billing_number','asc')
                    ->first();
                    
                $pCode = $countDel->billing_number;
            }
        return $pCode;
    }
    
    public function getInfoNumber (){
        $username = Auth::user()->name;
        $area = $this->checkuserInfo();
        $dateNow = date("Y-m-d");
        
        $billNumbering = DB::table("tr_store")
            ->where([
                ['store_id',$area],
                ['status','1'],
                ['created_by',$username]
                ])
            ->first();
            
        if(!empty($billNumbering)){
            $nomorstruk = $billNumbering->billing_number;
        }
        else{
            $nomorstruk = "0";
        }
        
        return $nomorstruk;
    }

    public function mainStore (){
        $checkArea = $this->checkuserInfo();
        $namaToko = DB::table('m_company')
            ->first();
            
        if (Auth::check()) {        
            return view ('Store/homePage', compact('checkArea','namaToko'));
        } else {
            return view ('login');
        }        
    }
    
    public function cariProduk ($keyword){
        $productList = DB::table('view_product_stock');
            if ($keyword <> 0) {
                $productList = $productList->where('product_name','LIKE','%'.$keyword.'%');
            }
            $productList = $productList->where('location_id','3');
            $productList = $productList->paginate(10);
            
        return view ('Store/homeProductList', compact('productList'));
    }
    
}
