<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class TempInventoryController extends Controller
{
    public function userRole (){
        if (Auth::check()) { 
            $userID = Auth::user()->id;
            $tbUserRole = DB::table('users_role')
                ->where([
                    ['user_id',$userID]
                    ])
                ->first();
            if(!empty($tbUserRole)){
                $userR = $tbUserRole->role_code;
            }
            else{
                $userR='0';
            }
        }
        else{
            return view ('auth/login');
        }
        return $userR;
    }
    
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
    
    public function index($code)
    {
        $data = DB::table('purchase_list_order')
            ->insert([
                'qty'=>$code
                ]);
        
        return $data;
    }
    
    public function tambahStock($productID, $qty, $satuan, $location){
        $a = '0';
        //Cari data stock berdasarkan produk id dan lokasi
        $dataStock = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productID],
                ['location_id',$location]
            ])
            ->get();
        
        // Cari data stock dan volume barang besar berdasarkan produk id, lokasi, & kode size 1
        $codeSatu = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productID],
                ['location_id',$location],
                ['size_code','1'],
            ])
            ->first();
        $volSatu = $codeSatu->product_volume;
        $stokSatu = $codeSatu->stock;
            
        // Cari data stock dan volume barang kecil berdasarkan produk id, lokasi, & kode size 2
        $codeDua = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productID],
                ['location_id',$location],
                ['size_code','2'],
            ])
            ->first();
         
        // Cari data stock dan volume barang konversi berdasarkan produk id, lokasi, & kode size 3 
        $codeTiga = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productID],
                ['location_id',$location],
                ['size_code','3'],
            ])
            ->first();
        
        // variable data kode 3
        if(!empty($codeTiga)){
            $volTiga = $codeTiga->product_volume;
            $stokTiga = $codeTiga->stock;
        }
        else{
            $volTiga = $volSatu;
            $stokTiga = $stokSatu;
        }
        
        // Jika data kode kedua tidak ada maka ambil data konversi satuan kode 3
        if(!empty($codeDua)){
            $volDua = $codeDua->product_volume;
            $stokDua = $codeDua->stock;
        }
        else{
            $volDua = $volTiga;
            $stokDua = $stokTiga;
        }
        
        // LOOP perhitungan stock
        foreach($dataStock as $ds){
            //Jika data yang dimasukkan satuannya BESAR
            if($satuan == "BESAR"){
                // Jika data yang di loop adalah 1
                if($ds->size_code == '1'){
                    $a = $ds->stock + $qty;
                }
                elseif($ds->size_code == '2'){
                    $a1 = (int)$volSatu * $qty; // qty yang dimasukkan dikalikan terlebih dahulu dengan volume 1
                    $a = $ds->stock + $a1;
                }
                elseif($ds->size_code == '3'){
                    $a1 = $ds->product_volume * $qty; // qty yang dimasukkan dikalikan terlebih dahulu dengan volume 3
                    $a = $ds->stock + $a1;
                }
            }
            elseif($satuan == "KECIL"){
                if($ds->size_code == '1'){
                    $a1 = $stokDua + $qty;
                    $a2 = $a1/(int)$volSatu;
                    $a = (int)$a2;
                }
                elseif($ds->size_code == '2'){
                    $a1 = $ds->stock + $qty;
                    $a = (int)$a1;
                }
                elseif($ds->size_code == '3'){
                    $a1 = $volDua * $qty;
                    $a2 = $ds->stock + $a1;
                    $a = (int)$a2;
                }
            }
            elseif($satuan == "KONV"){
                $ab = $stokTiga + $qty;
                if($ds->size_code == '1'){
                    $a1 = $ab / $volTiga;
                    $a = (int)$a1;
                }
                elseif($ds->size_code == '2'){
                    $a1 = $ab / $volDua;
                    $a = (int)$a1;
                }
                elseif($ds->size_code == '3'){
                    $a = $ab;
                }
            }
            // echo $ds->idinv_stock."-".$ds->size_code."=".$a."<br>";
            $updateInv = DB::table('inv_stock')
                        ->where([
                            ['idinv_stock',$ds->idinv_stock],
                            ['location_id',$location]
                            ])
                        ->update([
                            'stock'=>$a,
                            'saldo'=>$a
                        ]);
        }
        return $updateInv;
    }
    
    public function insertLapInv ($numberCode, $description, $inInv, $outInv, $createdBy, $prodId, $prodName, $satuan, $loc){
        
        $findSatuan = DB::table('m_product_unit')
            ->select('product_satuan', 'idm_product_satuan','product_volume','size_code')
            ->where([
                ['core_id_product',$prodId],
                ['product_size',$satuan]
                ])
            ->first();
            
        $findDescSatuan = DB::table('m_product_unit')
                ->select('product_satuan', 'idm_product_satuan','product_volume','size_code')
                ->where('core_id_product',$prodId)
                ->orderBy('size_code','desc')
                ->first();

        $findStock = DB::table('inv_stock')
            ->select('stock')
            ->where([
                ['product_id',$findDescSatuan->idm_product_satuan],
                ['location_id',$loc]
                ])
            ->first();

        $findReportInv = DB::table('report_inv')
                ->where('product_id',$prodId)
                ->orderBy('idr_inv','desc')
                ->first();
        
        $mVolPrd = DB::table('m_product')
                ->select('large_unit_val','medium_unit_val','small_unit_val')
                ->where('idm_data_product',$prodId)
                ->first();
        
        if ($findDescSatuan->size_code == '1') {
            $inputValIn = $inInv;
            $inputValOut = $outInv;
            $inputValVol = $mVolPrd->large_unit_val;
        }
        else {
            // Jika yang di input dengan satuan code :
            if ($findSatuan->size_code == '1') {
                if ($mVolPrd->small_unit_val == '0') {
                    $inputValIn = $inInv * $mVolPrd->large_unit_val;
                    $inputValOut = $outInv * $mVolPrd->large_unit_val;
                    $inputValVol = $mVolPrd->large_unit_val;
                }
                else {
                    $inputValIn = $inInv * $mVolPrd->small_unit_val;
                    $inputValOut = $outInv * $mVolPrd->small_unit_val;
                    $inputValVol = $mVolPrd->small_unit_val;                    
                }
            }
            elseif ($findSatuan->size_code == '2') {
                if ($mVolPrd->medium_unit_val == '0') {
                    $inputValIn = $inInv * $mVolPrd->large_unit_val;
                    $inputValOut = $outInv * $mVolPrd->large_unit_val;
                    $inputValVol = $mVolPrd->large_unit_val;
                }
                else {
                    $inputValIn = $inInv * $mVolPrd->medium_unit_val;
                    $inputValOut = $outInv * $mVolPrd->medium_unit_val;
                    $inputValVol = $mVolPrd->medium_unit_val;
                }
            }
            elseif ($findSatuan->size_code == '3') {
                $inputValIn = $inInv;
                $inputValOut = $outInv;
                $inputValVol = $mVolPrd->small_unit_val;
            }
        }
        
        if ($outInv == '0') {
            $lastSaldo = $findStock->stock - $inputValIn;
            $actualInput = $inInv;
            $statusTrx = '4';
        } 
        elseif ($inInv == '0') {
            $lastSaldo = $findStock->stock + $inputValOut;
            $actualInput = $outInv;
            $statusTrx = '1';
        }
        else {
            $lastSaldo = '0';
            $actualInput = '0';
            $statusTrx = '0';
        }

        

        $inserReport = DB::table('report_inv')
            ->insert([
                'date_input'=>now(),
                'number_code'=>$numberCode,
                'product_id'=>$prodId,
                'product_name'=>$prodName,
                'satuan'=>$findSatuan->product_satuan,
                'satuan_code'=>$findDescSatuan->size_code,
                'description'=>$description,
                'inv_in'=>$inputValIn,
                'inv_out'=>$inputValOut,
                'saldo'=>$findStock->stock,
                'created_by'=>$createdBy,
                'location'=>$loc,
                'last_saldo'=>$lastSaldo,
                'vol_prd'=>$inputValVol,
                'actual_input'=>$actualInput,
                'status_trx'=>$statusTrx
                ]);
        return $inserReport;
    }
    
    public function penambahanItem ($productID, $qty, $size, $loc){
        // variable nol
        $sizeK = '0';
        $invK = '0';
        $sizeKonv = '0';
        $volKonv = '0';
        
        // Cari data inventory
        $inventory = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productID],
                ['location_id',$loc]
                ])
            ->get();
            
        $invBesar = DB::table('m_product_unit')
            ->where([
                ['core_id_product',$productID],
                ['size_code','1']
                ])
            ->first();
        $sizeB = $invBesar->size_code;
        $invB = (int)$invBesar->product_volume;
        
        $invKecil = DB::table('m_product_unit')
            ->where([
                ['core_id_product',$productID],
                ['size_code','2']
                ])
            ->first();
        if(!empty($invKecil)) {
            $sizeK = $invKecil->size_code;
            $invK = (int)$invKecil->product_volume;
        }  
        
        $invKonv = DB::table('m_product_unit')
            ->where([
                ['core_id_product',$productID],
                ['size_code','3']
                ])
            ->first();
            
        if(!empty($invKonv)) {
            $sizeKonv = $invKonv->size_code;
            $volKonv = (int)$invKonv->product_volume;
        } 
        
        foreach($inventory as $i){
            
            if($size == "BESAR"){
                if($i->size_code == '1'){
                    $a = $i->stock + $qty;
                }
                elseif($i->size_code == '2'){
                    $a1 = $qty * $invB;
                    $a = $i->stock + $a1;
                }
                elseif($i->size_code == '3'){
                    $a1 = $qty * $volKonv;
                    $a = $i->stock + $a1;
                }
            }
            elseif($size == "KECIL"){
                if($i->size_code == '1'){
                    $a1 = $qty / $invB;
                    $a = $i->stock + (int)$a1;
                }
                elseif($i->size_code == '2'){
                    $a = $i->stock + $qty;
                }
                elseif($i->size_code == '3'){
                    $a1 = $qty * $invK;
                    $a = $i->stock + $a1;
                }
            }
            elseif($size == "KONV"){
                if($i->size_code == '1'){
                    $a1 = $qty / $volKonv;
                    $a = $i->stock + (int)$a1;
                }
                elseif($i->size_code == '2'){
                    $a1 = $qty / $invK;
                    $a = $i->stock + (int)$a1;
                }
                elseif($i->size_code == '3'){
                    $a = $i->stock + $qty;
                }
            }
            // echo $i->idinv_stock."=".$a."<br>";
            DB::table('inv_stock')
                ->where([
                    ['idinv_stock',$i->idinv_stock]
                    ])
                ->update([
                    'stock' => $a,
                    'saldo' => $a
                    ]);
        } 
        
    }
    public function penguranganItem ($productID, $qty, $size, $loc){
        // Qty yang dimasukkan adalah quantity yang sudah dikurangi, sehingga tidak ada proses pengurangan lagi
        
        // variable nol
        $sizeK = '0';
        $valK = '0';
        $sizeKonv = '0';
        $valKonv = '0';
        
        // Cari data inventory
        $inventory = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productID],
                ['location_id',$loc]
                ])
            ->get();
            
        $invBesar = DB::table('m_product_unit')
            ->where([
                ['core_id_product',$productID],
                ['size_code','1']
                ])
            ->first();
        $sizeB = $invBesar->size_code;
        $invB = $invBesar->product_volume;
        
        $invKecil = DB::table('m_product_unit')
            ->where([
                ['core_id_product',$productID],
                ['size_code','2']
                ])
            ->first();
        if(!empty($invKecil)) {
            $sizeK = $invKecil->size_code;
            $valK = $invKecil->product_volume;
        }  
        
        $invKonv = DB::table('m_product_unit')
            ->where([
                ['core_id_product',$productID],
                ['size_code','3']
                ])
            ->first();
            
        if(!empty($invKonv)) {
            $sizeKonv = $invKonv->size_code;
            $valKonv = $invKonv->product_volume;
        } 
        
        foreach($inventory as $i){
            if($size == "BESAR"){
                if($i->size_code == '1'){
                    $a = $qty;
                }
                elseif($i->size_code == '2'){
                    $a = $qty * $invB;
                }
                elseif($i->size_code == '3'){
                    $a = $qty * $valKonv;
                }
            }
            elseif($size == "KECIL"){
                if($i->size_code == '1'){
                    $a1 = $qty / $invB;
                    $a = (int)$a1;
                }
                elseif($i->size_code == '2'){
                    $a = $qty;
                }
                elseif($i->size_code == '3'){
                    $a = $qty * $valK;
                }
            }
            elseif($size == "KONV"){
                if($i->size_code == '1'){
                    $a1 = $qty / $valKonv;
                    $a = (int)$a1;
                }
                elseif($i->size_code == '2'){
                    $a1 = $qty / $valK;
                    $a = (int)$a1;
                }
                elseif($i->size_code == '3'){
                    $a = $qty;
                }
            }
            // echo $i->idinv_stock."=".$a."<br>";
            DB::table('inv_stock')
                ->where([
                    ['idinv_stock',$i->idinv_stock]
                    ])
                ->update([
                    'stock' => $a,
                    'saldo' => $a
                    ]);
        } 
        
    }
    
    public function stockControl($productID, $location, $qty, $satuan){
        $a = '0';
        $dataStock = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productID],
                ['location_id',$location]
            ])
            ->get();
        
        // Cari data stock dan volume barang besar berdasarkan produk id, lokasi, & kode size 1
        $codeSatu = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productID],
                ['location_id',$location],
                ['size_code','1'],
            ])
            ->first();
        $volSatu = $codeSatu->product_volume;
        $stokSatu = $codeSatu->stock;
            
        // Cari data stock dan volume barang kecil berdasarkan produk id, lokasi, & kode size 2
        $codeDua = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productID],
                ['location_id',$location],
                ['size_code','2'],
            ])
            ->first();
         
        // Cari data stock dan volume barang konversi berdasarkan produk id, lokasi, & kode size 3 
        $codeTiga = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productID],
                ['location_id',$location],
                ['size_code','3'],
            ])
            ->first();
        
        // variable data kode 3
        if(!empty($codeTiga)){
            $volTiga = $codeTiga->product_volume;
            $stokTiga = $codeTiga->stock;
        }
        else{
            $volTiga = $volSatu;
            $stokTiga = $stokSatu;
        }
        
        // Jika data kode kedua tidak ada maka ambil data konversi satuan kode 3
        if(!empty($codeDua)){
            $volDua = $codeDua->product_volume;
            $stokDua = $codeDua->stock;
        }
        else{
            $volDua = $volTiga;
            $stokDua = $stokTiga;
        }
        // LOOP perhitungan stock
        foreach($dataStock as $ds){
            //Jika data yang dimasukkan satuannya BESAR
            if($satuan == "BESAR"){
                // Jika data yang di loop adalah 1
                if($ds->size_code == '1'){
                    $a = $qty;
                }
                elseif($ds->size_code == '2'){
                    $a1 = (int)$volSatu * $qty; // qty yang dimasukkan dikalikan terlebih dahulu dengan volume 1
                    $a = $a1;
                }
                elseif($ds->size_code == '3'){
                    $a1 = $ds->product_volume * $qty; // qty yang dimasukkan dikalikan terlebih dahulu dengan volume 3
                    $a = $a1;
                }
            }
            elseif($satuan == "KECIL"){
                if($ds->size_code == '1'){
                    $a2 = $qty/(int)$volSatu;
                    $a = (int)$a2;
                }
                elseif($ds->size_code == '2'){
                    $a = (int)$qty;
                }
                elseif($ds->size_code == '3'){
                    $a1 = $volDua * $qty;
                    $a = (int)$a1;
                }
            }
            elseif($satuan == "KONV"){
                if($ds->size_code == '1'){
                    $a1 = $qty / $volTiga;
                    $a = (int)$a1;
                }
                elseif($ds->size_code == '2'){
                    $a1 = $qty / $volDua;
                    $a = (int)$a1;
                }
                elseif($ds->size_code == '3'){
                    $a = $qty;
                }
            }
            // echo $ds->idinv_stock."-".$ds->size_code."=".$a."<br>";
            $updateInv = DB::table('inv_stock')
                        ->where([
                            ['idinv_stock',$ds->idinv_stock],
                            ['location_id',$location]
                            ])
                        ->update([
                            'stock'=>$a,
                            'saldo'=>$a
                        ]);
        }
        return $updateInv;
    }
}
