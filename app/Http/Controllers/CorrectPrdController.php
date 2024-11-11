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
       return view('StockCorrection/listDataKoreksi');
   }   

   public function filterByDate($fromDate, $endDate)
   {
        $listOnProces = DB::table('inv_correction')
            ->whereBetween("status", ['1', '2'])
            ->get();

        $lisDatKoreksi = DB::table('inv_correction')
        ->where('status','>=','2')
        ->whereBetween("dateInput", [$fromDate, $endDate])
        ->limit(100)
        ->get();

        $approval = $this->userApproval();
        
        return view('StockCorrection/tableDokKereksi', compact('lisDatKoreksi','approval','listOnProces'));
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
                // ['dateInput',$dateInput]
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
        
        //cek ketersediaan item pada list item koreksi. 
        $countItem = DB::table('inv_list_correction')
        ->where([
                ['number_correction',$numberKoreksi],
                ['inv_id',$invID],
                ['status','1'],
                ['created_by',$createdBy]
            ])
        ->count();

        // Jalankan update apabila tidak ada jumlah data produk yang sama.
        if($countItem == '0'){   
            $selectItem = DB::table('view_product_stock')
                ->where([
                    ['idm_data_product',$product],
                    ['location_id',$location],
                    ['product_size',$satuan]
                ])
                ->first();
                
            $invID = $selectItem->idinv_stock;

            DB::table('inv_list_correction')
                ->insert([
                    'number_correction'=>$numberKoreksi, 
                    'inv_id'=>$invID,
                    'product_correcId'=>$product,
                    'location'=>$location,
                    'd_k'=>$t_type,
                    'input_qty'=>$qty,
                    'qty'=>$a,
                    'stock'=>$lastStokPerUnit,
                    'created_by'=>$createdBy,
                    'saldo'=>$a,
                    'display'=>$display,
                    'size_code'=>$sizeCode
                ]);    

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
                    'stock'=>$i->qty,
                    'saldo'=>$i->qty
                ]);
                
            DB::table('inv_list_correction')
                ->where('number_correction',$number)
                ->update([
                    'status'=>'3'    
                ]);
        }  

        //Select display on 
        $displayCorrection = DB::table('inv_list_correction')
            ->where([
                ['display','1'],
                ['number_correction',$number]
                ])
            ->orderBy('size_code','desc')
            ->first();

        $prodId = $displayCorrection->product_correcId;
        $loc = $displayCorrection->location;
        $sizeCode = $displayCorrection->size_code;
        

        if ($displayCorrection->d_k == "D") {
            $inInv = $displayCorrection->qty - $displayCorrection->stock;
            $outInv = '0';
        }
        else {
            $inInv = '0';
            $outInv = $displayCorrection->stock - $displayCorrection->qty;
        }

        //search inv_stock berdasarkan produk dan lokasi
        $infoStock = DB::table('view_product_stock')
            ->select('stock','saldo','site_name','product_name','product_volume')
            ->where([
                ['idm_data_product',$prodId],
                ['location_id',$loc]
            ])
            ->orderBy('size_code','desc')
            ->first();

        $qtyInv = $infoStock->stock;
        //Insert into report_inv
        $description = "Koreksi Barang Oleh ".$userName; 
        $loc = $infoStock->site_name;
        $prodName = $infoStock->product_name;
        $createdBy = Auth::user()->name;
        if ($sizeCode == '1') {
            $satuan = 'BESAR';
        }
        elseif ($sizeCode == '2') {
            $satuan = "KECIL";
        }
        else {
            $satuan = "KONV";
        }
        //Update into laporan inventory
        DB::table('report_inv')
            ->insert([
                'date_input'=>now(),
                'number_code'=>$number,
                'product_id'=>$prodId,
                'product_name'=>$prodName,
                'satuan'=>$satuan,
                'satuan_code'=>$sizeCode,
                'description'=>$description,
                'inv_in'=>$inInv,
                'inv_out'=>$outInv,
                'saldo'=>$displayCorrection->saldo,
                'created_by'=>$displayCorrection->created_by,
                'location'=>$displayCorrection->location,
                'last_saldo'=>$displayCorrection->stock,
                'vol_prd'=>$infoStock->product_volume,
                'actual_input'=>$displayCorrection->input_qty,
                'status_trx'=>'4'
            ]);
       
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

   public function saveToDatabase(Request $autoSaveTable)
   {
        $table = $autoSaveTable->tableName;
        $colom = $autoSaveTable->column;
        $editVal = $autoSaveTable->editVal;
        $id = $autoSaveTable->id;
        $colId = $autoSaveTable->tableId;

        // select list koreksi by id 
        $selectOne = DB::table('inv_list_correction')
            ->where('idinv_list',$id)
            ->first();

        $dk = $selectOne->d_k;
        $stock = $selectOne->stock;        

        if ($dk == "D") {
            $updateQty = $stock + $editVal;
        }
        elseif ($dk == "K") {
            $updateQty = $stock - $editVal;
        }

        DB::table('inv_list_correction')
            ->where($colId,$id)
            ->update([
                'input_qty'=>$editVal,
                'qty'=>$updateQty,
                'stock'=>$stock,
                'saldo'=>$updateQty
            ]);
   }
}
