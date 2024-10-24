<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;


class CorrectPrdController extends Controller
{    
    protected $tempInv;   
    public function __construct(TempInventoryController $tempInv)
    {
        $this->TempInventoryController = $tempInv;
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
    
    public function numberSO(){
        $thisPeriode = date('mY');
        
        $countPeriode = DB::table('inv_correction')
            ->where('periode',$thisPeriode)
            ->count();
            
        if($countPeriode=='0'){
            $stp = '1';
            $nostp = "KRS-".$thisPeriode."-".sprintf("%07d",$stp);
        }
        else{
            $deletedNumber = DB::table('inv_correction')
                ->where([
                    ['status','0'],
                    ['periode',$thisPeriode]
                    ])
                ->first();
            
            if(empty($deletedNumber)){
                $stp = $countPeriode+1;
                $nostp = "KRS-".$thisPeriode."-".sprintf("%07d",$stp);
            }
            else{
                $nostp = $deletedNumber->number;
            }
        }
        return $nostp;
    }
    
    public function activeNumber(){
        $userName = Auth::user()->name;
        
        $countopname = DB::table('inv_correction')
            ->where([
                ['created_by',$userName],
                ['status','1']
            ])
            ->count();
            
        if($countopname >= '1'){
            $noKrs = DB::table('inv_correction')
                ->where([
                    ['created_by',$userName],
                    ['status','1']
                ])
                ->first();
            $numberKrs = $noKrs->number;
        }
        else{
            $numberKrs = '0';
        }
        
        return $numberKrs;
        
    }
    
    public function userApproval (){
        $userID = Auth::user()->id;
        $cekUserGroup = DB::table('users_group')
            ->where([
                ['user_id',$userID],
                ['group_code','1']
            ])
            ->count();
            
        return $cekUserGroup;
    }

   public function koreksiBarang(){
       $nKrs = $this->numberSO();
       $listofSite = DB::table('m_site')
            ->get();
            
        $countKrs = DB::table('inv_correction')
            ->where([
                'status'=>'1'    
            ])
            ->count();
            
        $summaryKrs = DB::table('inv_correction')
            ->orderBy('idinv_correction','desc')
            ->get();
            
       return view('StockCorrection/main', compact('listofSite','nKrs','countKrs','summaryKrs'));
   }
   
   public function listDataKoreksi(){
       $lisDatKoreksi = DB::table('inv_correction')
        ->where('status','>=','2')
        ->paginate(10);
        $approval = $this->userApproval();
       return view('StockCorrection/listDataKoreksi', compact('lisDatKoreksi','approval'));
   }
   
   public function listInputBarang(){
        $numberKrs = $this->activeNumber();
        $nKrs = $this->numberSO();
        $createdBy = Auth::user()->name;
        $dateInput = date("Y-m-d");
        
        $mProduct = DB::table('m_product')
            ->orderBy('product_name','ASC')
            ->get();
            
        $mSite = DB::table('m_site')
                ->get();
            
        $countKoreksi = DB::table('inv_correction')
            ->where([
                ['status','1'],
                ['created_by',$createdBy],
                ['dateInput',$dateInput]
            ])
            ->count();
            
        if($countKoreksi == '0'){
            return view('StockCorrection/newCorrection', compact('mSite','countKoreksi','nKrs'));
        }
        else{
            $sumKoreksi = DB::table('inv_list_correction')
                ->select(DB::raw('SUM(qty) as qty'), DB::raw('SUM(stock) as stock'), DB::raw('COUNT(idinv_list) as countKrs'))
                ->where([
                    ['number_correction',$numberKrs]
                ])
                ->first();
                
            $koreksi = DB::table('inv_correction')
                ->where('number',$numberKrs)
                ->first();
            
            return view('StockCorrection/newCorrectionProduct', compact('mProduct','numberKrs','sumKoreksi','countKoreksi','koreksi','mSite'));
        }
   }
   
   public function submitFormKoreksi(Request $reqForm){
       
       $nomorKoreksi = $reqForm->nomorKoreksi;
       $filterTanggal = $reqForm->filterTanggal;
       $description = $reqForm->description;
       $thisPeriode = date('mY');
       $createdBy = Auth::user()->name;
       
       //cek ketersediaan data
       $countNumber = DB::table('inv_correction')
        ->where('number',$nomorKoreksi)
        ->count();
        
        if($countNumber == '0'){
            DB::table('inv_correction')
                ->insert([
                    'number'=>$nomorKoreksi,
                    'periode'=>$thisPeriode,
                    'dateInput'=>$filterTanggal,
                    'notes'=>$description,
                    'created_by'=>$createdBy,
                ]);
        }
        else{
            DB::table('inv_correction')
                ->where('number',$nomorKoreksi)
                ->update([
                    'periode'=>$thisPeriode,
                    'dateInput'=>$filterTanggal,
                    'notes'=>$description,
                    'created_by'=>$createdBy,
                    'status'=>'1'
                ]);
        }
            
        return back();
   }
   
//   public function submitUpdateStockOpname(Request $reqUpdateForm){
//       $noStockOpname = $reqUpdateForm->noStockOpname;
//       $filterTanggal = $reqUpdateForm->filterTanggal;
//       $pilihLokasi = $reqUpdateForm->pilihLokasi;
//       $description = $reqUpdateForm->description;
//       $thisPeriode = date('mY');
//       $createdBy = Auth::user()->name;
       
//         DB::table('inv_stock_opname')
//             ->where('number_so',$noStockOpname)
//             ->update([
//                 'date_so'=>$filterTanggal,
//                 'loc_so'=>$pilihLokasi,
//                 'description'=>$description,
//                 'updated_by'=>$createdBy,
//             ]);
            
//         return back();
//   }
   
   
   
   public function satuan($productId){
        $productSatuan = DB::table('view_product_stock')
            ->where('idm_data_product',$productId)
            ->get();
        
        return view('StockOpname/listSatuan', compact('productSatuan'));
   }
   public function lastQty($satuan, $productId, $locationId){
       $userArea = $this->checkuserInfo();
       
       $lastStock = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productId],
                ['product_size',$satuan],
                ['location_id',$locationId],
                ])
            ->first();
            
        if(empty($lastStock)){
            $productData = DB::table('m_product_unit')
                ->where([
                    ['core_id_product',$productId],
                    ['product_size',$satuan]
                ])
                ->first();
            $unitId = $productData->idm_product_satuan;
            
            $insertIntoInv = DB::table('inv_stock')
                ->insert([
                    'product_id'=>$unitId,
                    'location_id'=>$locationId,
                    'stock'=>'0',
                    'stock_status'=>'1'
                ]);
            $Lastid = DB::getPdo()->lastInsertId($insertIntoInv);
            
            return response()->json([
                'lastQty' => '0',
                'invID' => $Lastid
            ]);
        }
        else{
            return response()->json([
                'lastQty' => $lastStock->stock,
                'invID' => $lastStock->idinv_stock
            ]);
        }
        return response()->json(['error' => 'Product not found'], 404);
   }
   
   public function submitKoreksi (Request $reqSubmit){
        $numberKoreksi = $reqSubmit->numberKoreksi;
        $invID = $reqSubmit->invID;
        $product = $reqSubmit->product;
        $location = $reqSubmit->location;
        $satuan = $reqSubmit->satuan;
        $t_type = $reqSubmit->t_type;
        $qty = $reqSubmit->qty;
        $lastStock = $reqSubmit->lastStock;
        $tPerbaikan = $reqSubmit->tPerbaikan;
        $createdBy = Auth::user()->name;
        
        $cekProduct = DB::table('inv_list_correction')
        ->where([
                ['number_correction',$numberKoreksi],
                ['inv_id',$invID],
                ['status','1'],
                ['created_by',$createdBy]
            ])
        ->count();

        $productUnit = DB::table('product_list_view as a')
                ->select('a.*','b.location_id','b.stock','b.idinv_stock')
                ->leftJoin('inv_stock as b','a.idm_product_satuan','b.product_id')
                ->where([
                    ['a.core_id_product',$product],
                    ['a.product_volume','!=','0'],
                    ['a.product_satuan','!=',''],
                    ['b.location_id',$location]
                    ])
                ->get();
                
        $volKonversi = DB::table('product_list_view') //mengambil data konversi
                ->where('core_id_product',$product)
                ->orderBy('size_code','desc')
                ->first();
                
        $valKecil = DB::table('m_product_unit')
                ->select('product_volume')
                ->where([
                    ['core_id_product',$product],
                    ['size_code','2']
                    ])
                ->first();

        $vol = $volKonversi->product_volume;
        if(!empty($valKecil)){
            $volkodedua = $valKecil->product_volume;
        }
        else{
            $volkodedua = $vol;
        }

        $mProduk = DB::table('m_product')
            ->where('idm_data_product',$product)
            ->first();

        $volBesar = $mProduk->large_unit_val;    
        $volKecil = $mProduk->medium_unit_val;    
        $volKonv = $mProduk->small_unit_val;
        $prodName = $mProduk->product_name;

        // Jalankan update apabila tidak ada jumlah data produk yang sama.
        if($cekProduct == '0'){            
            foreach($productUnit as $inputUnit){
                $sizeCode = $inputUnit->size_code;
                $prodZise = $inputUnit->product_size;   
                
                if ($satuan == "BESAR") {
                    if ($sizeCode == '1') {
                        $a = $tPerbaikan;
                        $display = '1';
                    }
                    elseif ($sizeCode == '2') {
                        $a = $tPerbaikan * $volBesar;
                        $display = '0';
                    }
                    elseif ($sizeCode == '3') {
                        $a = $tPerbaikan * $volKonv;
                        $display = '0';
                    }
                }
                elseif ($satuan == "KECIL") {
                    if ($sizeCode == '1') {
                        $a1 = $tPerbaikan / $volBesar;
                        $a = (int)$a1;
                        $display = '0';
                    }
                    elseif ($sizeCode == '2') {
                        $a = $tPerbaikan;
                        $display = '1';
                    }
                    elseif ($sizeCode == '3') {
                        $a = $tPerbaikan * $volKecil;
                        $display = '0';
                    }
                }
                elseif ($satuan == "KONV") {
                    if ($sizeCode == '1') {
                        $a1 = $tPerbaikan / $volKonv;
                        $a = (int)$a1;
                        $display = '0';
                    }
                    elseif ($sizeCode == '2') {
                        $a1 = $tPerbaikan / $volKecil;
                        $a = (int)$a1;
                        $display = '0';
                    }
                    elseif ($sizeCode == '3') {
                        $a = $tPerbaikan;
                        $display = '1';
                    }
                }

                DB::table('inv_list_correction')
                    ->insert([
                        'number_correction'=>$numberKoreksi, 
                        'inv_id'=>$inputUnit->idinv_stock,
                        'product_correcId'=>$product,
                        'location'=>$location,
                        'd_k'=>$t_type,
                        'input_qty'=>$qty,
                        'qty'=>$a,
                        'stock'=>$lastStock,
                        'created_by'=>$createdBy,
                        'saldo'=>$a,
                        'display'=>$display,
                    ]);
                
            }
            $description = "Koreksi Barang Oleh : ".Auth::user()->name;
            if ($t_type == 'D') {
                $inInv = $qty;
                $outInv = '0';
            }
            elseif ($t_type == "K") {
                $inInv = '0';
                $outInv = $qty;
            }
                        
            $this->TempInventoryController->insertLapInv ($numberKoreksi, $description, $inInv, $outInv, $createdBy, $product, $prodName, $satuan, $location);
            $msg = array('success'=>'<h4>SUCCESS</h4> Koreksi Barang berhasil dimasukkan');
        }
        else{
            $msg = array('warning'=>'<h4>ERROR</h4> Data yang dimasukkan sudah ada'); 
        }
        return response()->json($msg);
   }
   
   public function listBarang ($number){
       $createdBy = Auth::user()->name;
    //   echo $number;
       $listBarang = DB::table('inv_list_correction as a')
        ->leftJoin('view_product_stock as b','a.inv_id','b.idinv_stock')
        ->where([
            ['number_correction',$number],    
            ['created_by',$createdBy],
            ['display','1']
        ])
        ->get();
      
        return view('StockCorrection/listTableInputBarang', compact('listBarang'));
   }
   
   public function submitLapKoreksi (Request $reportOpname){
       $sumQty = $reportOpname->sumQty;
       $sumStok = $reportOpname->sumStok;
       $number = $reportOpname->number;
       $t_item = $reportOpname->t_item;
       
       DB::table('inv_correction')
        ->where('number',$number)
        ->update([
            't_item'=>$t_item,
            't_prd_correction'=>$sumQty,
            'status'=>'2',
        ]);
        
       DB::table('inv_list_correction')
        ->where('number_correction',$number)
        ->update([
            'status'=>'2',
        ]);
       
   }
   
   public function approvalKoreksi($number){
       $userName = Auth::user()->name;
       
       $inv = DB::table('inv_list_correction')
        ->where('number_correction',$number)
        ->get();
        
        foreach($inv as $i){
            $invId = $i->inv_id;
            $saldo = $i->saldo;
            DB::table('inv_stock')
                ->where('idinv_stock',$invId)
                ->update([
                    'stock'=>$i->qty
                ]);
                
            DB::table('inv_list_correction')
                ->where('number_correction',$number)
                ->update([
                    'status'=>'3'    
                ]);
        }
        
        DB::table('inv_correction')
            ->where('number',$number)
            ->update([
                'status'=>'3'    
            ]);
   }
   
   public function deleteKoreksi($number){
       DB::table('inv_correction')
        ->where('number',$number)
        ->update([
            'status'=>'0'    
        ]);
        
        DB::table('inv_list_correction')
        ->where('number_correction',$number)
        ->delete();
   }
   
   public function detailKoreksi($number){
       $dokumenKoreksi = DB::table('inv_correction')
        ->where('number',$number)
        ->first();
        
       $detailKoreksi = DB::table('inv_list_correction as a')
        ->select('a.*','b.product_name','b.site_name','b.product_satuan')
        ->leftJoin('view_product_stock as b', 'a.inv_id','=','b.idinv_stock')
        ->where([
            ['a.number_correction',$number],
            ['a.display','1']
            ])
        ->get();
        
        return view('StockCorrection/detailKoreksi', compact('dokumenKoreksi','detailKoreksi'));
   }
   
   public function deleteItem($number){
    //   echo $number;
      DB::table('inv_list_correction')
        ->where('product_correcId',$number)
        ->delete();
   }
}
