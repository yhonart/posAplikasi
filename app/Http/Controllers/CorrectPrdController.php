<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class CorrectPrdController extends Controller
{    
    protected $tempInv; 
    protected $TempInventoryController;
    
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
        $thisPeriode = date('my');
        $company = Auth::user()->company;

        $countPeriode = DB::table('inv_correction')
            ->where([
                ['periode',$thisPeriode],
                ['comp_id',$company]
                ])
            ->count();

        $mcomp = DB::table('m_company')
            ->select('company_code')
            ->where('idm_company',$company)
            ->first();
        $cmpcode = $mcomp->company_code;
        if($countPeriode=='0'){
            $stp = '1';
            $nostp = "K".$cmpcode."-".$thisPeriode."".sprintf("%07d",$stp);
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
                $nostp = "K".$cmpcode."-".$thisPeriode."".sprintf("%07d",$stp);
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

   public function filterByDate($fromDate, $endDate, $status)
   {
        $company = Auth::user()->company;
        if ($fromDate == '0' && $endDate == '0') {
            $tanggalAwal = Carbon::now()->startOfMonth();
            $tanggalAkhir  = Carbon::now()->endOfMonth();
        }
        else {
            $tanggalAwal = $fromDate;
            $tanggalAkhir  = $endDate;
        }
        $listOnProces = DB::table('inv_correction')
            ->whereBetween("status", ['1', '2'])
            ->get();
            
        $lisDatKoreksi = DB::table('inv_correction');
        if ($status == "All") {
            $lisDatKoreksi = $lisDatKoreksi->whereBetween("status", ['2','3']);
        }
        else {
            $lisDatKoreksi = $lisDatKoreksi->where('status',$status);            
        }
        $lisDatKoreksi = $lisDatKoreksi->whereBetween("dateInput", [$tanggalAwal, $tanggalAkhir]);
        $lisDatKoreksi = $lisDatKoreksi->where('comp_id',$company);
        $lisDatKoreksi = $lisDatKoreksi->limit(100);
        $lisDatKoreksi = $lisDatKoreksi->get();

        $approval = $this->userApproval();
        
        return view('StockCorrection/tableDokKereksi', compact('lisDatKoreksi','approval','listOnProces','tanggalAwal','tanggalAkhir'));
   }
   
   public function listInputBarang(){
        $numberKrs = $this->activeNumber();
        $nKrs = $this->numberSO();
        $createdBy = Auth::user()->name;
        $dateInput = date("Y-m-d");
        $company = Auth::user()->company;
        
        $mProduct = DB::table('m_product')
            ->where('comp_id',$company)
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
       $company = Auth::user()->company;
       
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
                    'comp_id'=>$company
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

            $lastStock = $selectItem->stock;
            $invID = $selectItem->idinv_stock;
            $sizeCode = $selectItem->size_code;

            if ($t_type == "D") {
                $a = $lastStock + $qty;
            }
            elseif ($t_type == "K") {
                $a = $lastStock - $qty;
            }

            $mProduct = DB::table('m_product')                
                ->where('idm_data_product',$product)
                ->first();
            $volB = $mProduct->large_unit_val;
            $volK = $mProduct->medium_unit_val;
            $volKonv = $mProduct->small_unit_val;

            $mUnit = DB::table('m_product_unit')
                ->select('size_code','product_volume')
                ->where('core_id_product',$product)
                ->orderBy('size_code','desc')
                ->first();

            $sizeCodeDesc = $mUnit->size_code;

            if ($sizeCodeDesc == '1') {
                $inputSaldo = $a;
            }
            elseif ($sizeCodeDesc == '2') {
                if ($satuan == "BESAR") {
                    $i = $a * $volB;
                    $inputSaldo = (int)$i;
                }
                elseif ($satuan == "KECIL") {
                    $inputSaldo = $a;
                }
            }
            elseif ($sizeCodeDesc == '3') {
                if ($satuan == "BESAR") {
                    $i = $a * $volKonv;
                    $inputSaldo = (int)$i;
                }
                elseif ($satuan == "KECIL") {
                    $i = $a * $volK;
                    $inputSaldo = (int)$i;
                }
                elseif ($satuan == "KONV") {
                    $inputSaldo = $a;
                }
            }

            $display = '1';
            DB::table('inv_list_correction')
                ->insert([
                    'number_correction'=>$numberKoreksi, 
                    'inv_id'=>$invID,
                    'product_correcId'=>$product,
                    'location'=>$location,
                    'd_k'=>$t_type,
                    'input_qty'=>$qty,
                    'qty'=>$a,
                    'stock'=>$lastStock,
                    'created_by'=>$createdBy,
                    'saldo'=>$inputSaldo,
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
            ['display','1'],
            // ['status','1']
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
       $company = Auth::user()->company;

       //get item koreksi
        $inv = DB::table('inv_list_correction as a')
            ->select('a.*','b.product_size','b.product_satuan','b.size_code','b.product_volume')
            ->leftJoin('view_product_stock as b','b.idinv_stock','=','a.inv_id')
            ->where('a.number_correction',$number)
            ->get();
        
        // update stock di table inv_stock
        foreach($inv as $i){
            $invId = $i->inv_id;
            $saldo = $i->saldo;
            $qty = $i->qty;
            $prdID = $i->product_correcId;
            $prdSize = $i->product_size; // BESAR-KECIL-KONV
            $location = $i->location;

            //select Product by product id
            $selectUnit = DB::table('m_product_unit')
                ->where('core_id_product',$prdID)
                ->get();

            $mProduct = DB::table('m_product')
                ->where('idm_data_product',$prdID)
                ->first();

            $volB = $mProduct->large_unit_val;
            $volK = $mProduct->medium_unit_val;
            $volKonv = $mProduct->small_unit_val;

            foreach ($selectUnit as $unit) {                
                if ($prdSize == "BESAR") { // Jika yang di input adalah data size besar
                    if ($unit->product_size == "BESAR") {
                        $a = $qty;
                    }
                    elseif ($unit->product_size == "KECIL") {
                        $a1 = $qty * $volB;
                        $a = (int)$a1;
                    }
                    elseif ($unit->product_size == "KONV") {
                        $a1 = $qty * $volKonv;
                        $a = (int)$a1;
                    }
                }
                elseif ($prdSize == "KECIL") { // Jika yang di input adalah data size kecil
                    if ($unit->product_size == "BESAR") {
                        $a1 = $qty/$volB;
                        $a = (int)$a1;
                    }
                    elseif ($unit->product_size == "KECIL") {
                        $a = $qty;
                    }
                    elseif ($unit->product_size == "KONV") {
                        $a1 = $qty * $volK;
                        $a = (int)$a1;
                    }
                }
                elseif ($prdSize == "KONV") { // Jika yang di input adalah data KONV
                    if ($unit->product_size == "BESAR") {
                        $a1 = $qty/$volKonv;
                        $a = (int)$a1;
                    }
                    elseif ($unit->product_size == "KECIL") {
                        $a1 = $qty/$volK;
                        $a = (int)$a1;
                    }
                    elseif ($unit->product_size == "KONV") {
                        $a = $qty;
                    }
                }

                //Update to stock
                $idProduct_Unit = $unit->idm_product_satuan;
                DB::table('inv_stock')
                    ->where([
                        ['product_id',$idProduct_Unit],
                        ['location_id',$location]
                    ])
                    ->update([
                        'stock'=>$a,
                        'saldo'=>$a,
                        'updated_date'=>now()
                    ]);
            }
            // update status menjadi 3                
            DB::table('inv_list_correction')
                ->where('number_correction',$number)
                ->update([
                    'status'=>'3'    
                ]);
            // End Update Stock.
            
            $prodName = $mProduct->product_name;
            $satuan = $i->product_size;
            $sizeCode = $i->size_code;
            $description = "Koreksi Barang Oleh ".$userName;
            
            $mUnit = DB::table('m_product_unit')
                ->select('size_code','product_volume')
                ->where('core_id_product',$prdID)
                ->orderBy('size_code','desc')
                ->first();

            $sizeCodeDesc = $mUnit->size_code;  

            if ($sizeCodeDesc == '1') {
                $ls = $i->stock;
            }
            elseif ($sizeCodeDesc == '2') {
                if ($satuan == "BESAR") {
                    $ls1 = $i->stock * $volB;
                    $ls = (int)$ls1;
                }
                elseif ($satuan == "KECIL") {
                    $ls = $i->stock;
                }
            }
            elseif ($sizeCodeDesc == '3') {
                if ($satuan == "BESAR") {
                    $ls1 = $i->stock * $volKonv;
                    $ls = (int)$ls1;
                }
                elseif ($satuan == "KECIL") {
                    $ls1 = $i->stock * $volK;
                    $ls = (int)$ls1;
                }
                elseif ($satuan == "KONV") {
                    $ls = $i->stock;
                }
            }

            if ($i->d_k == "D") {
                $inInv = $i->saldo - $ls;
                $outInv = '0';
            }
            else {
                $inInv = '0';
                $outInv = $ls - $i->saldo;
            }
            $dokNumber = $i->number_correction;
            $selectDateCorrection = DB::table('inv_correction')
                ->select('dateInput')
                ->where('number',$dokNumber)
                ->first();
            $correctionDate = $selectDateCorrection->dateInput;
            // Insert into laporan
            DB::table('report_inv')
            ->insert([
                'date_input'=>$correctionDate,
                'number_code'=>$number,
                'product_id'=>$prdID,
                'product_name'=>$prodName,
                'satuan'=>$satuan,
                'satuan_code'=>$sizeCode,
                'description'=>$description,
                'inv_in'=>$inInv,
                'inv_out'=>$outInv,
                'saldo'=>$saldo,
                'created_by'=>$i->created_by,
                'location'=>$i->location,
                'last_saldo'=>$i->stock,
                'vol_prd'=>$i->product_volume,
                'actual_input'=>$i->input_qty,
                'status_trx'=>'4',
                'comp_id'=>$company
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
