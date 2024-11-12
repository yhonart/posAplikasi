<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;


class StockopnameController extends Controller
{    
    protected $tempInv;
    protected $tempUser;
    protected $TempInventoryController;
    protected $TempUsersController;
    
    public function __construct(TempInventoryController $tempInv, TempUsersController $tempUser)
    {
        $this->TempInventoryController = $tempInv;
        $this->TempUsersController = $tempUser;
    }
    
    public function numberSO(){
        $thisPeriode = date('mY');
        $dateNumber = date('dmy');
        $userName = Auth::user()->name;
        $date = date('Y-m-d');
        
        //cek jumlah pada table inv_stock_opname berdasarkan tanggal sekarang dan created by user yang sama. 
        $countPeriode = DB::table('inv_stock_opname')
            ->where([
                ['date_input',$date],
                ['created_by',$userName],
                ['status','1']
                ])
            ->count();
            
        //cek data transaksi yang di delete.
        $deletedNumber = DB::table('inv_stock_opname')
            ->where('status','0')
            ->first();
            
        // Jika data tidak ditemukan
        if($countPeriode=='0'){
            // cek jumlah data pada tanggal yang sama 
            $countData = DB::table('inv_stock_opname')
                ->where([
                    ['date_input',$date]
                    ])
                ->count();
                
            // Jika data di tanggal yang sama tidak ditemukan
            if($countData == '0'){
                $stp = '1';
                $nostp = "STP-".$dateNumber."-".sprintf("%07d",$stp);
            }else{
                $stp = $countData + 1;
                $nostp = "STP-".$dateNumber."-".sprintf("%07d",$stp);
            }
                
        }
        // Jika data ditemukan.
        else{
            if(empty($deletedNumber)){
                $stp = $countPeriode+1;
                $nostp = "STP-".$dateNumber."-".sprintf("%07d",$stp);
            }
            else{
                $nostp = $deletedNumber->number_so;
            }
        }
        return $nostp;
    }
    
    public function activeNumber(){
        $userName = Auth::user()->name;
        
        $countopname = DB::table('inv_stock_opname')
            ->where([
                ['created_by',$userName],
                ['status','1']
            ])
            ->count();
        if($countopname >= '1'){
            $noopname = DB::table('inv_stock_opname')
                ->where([
                    ['created_by',$userName],
                    ['status','1']
                ])
                ->first();
            $numberSto = $noopname->number_so;
        }
        else{
            $numberSto = '0';
        }
        
        return $numberSto;
        
    }
    
    public function userApproval (){
        $userID = Auth::user()->id;
        $cekUserGroup = DB::table('users_role')
            ->where([
                ['user_id',$userID],
                ['role_code','1']
            ])
            ->count();
            
        return $cekUserGroup;
    }

   public function stockOpname(){
       $nstp = $this->numberSO();
        $countActiveOpname = DB::table('inv_stock_opname')
            ->where([
                'status'=>'1'    
            ])
            ->count();
            
       return view('StockOpname/main', compact('nstp','countActiveOpname'));
   }
   
   public function listInputBarang(){
        $firstNumber = $this->numberSO();
        $createdBy = Auth::user()->name;
        $dateInput = date("Y-m-d");

        $mProduct = DB::table('m_product')
            ->orderBy('product_name','ASC')
            ->get();
            
        $countOpname = DB::table('inv_stock_opname')
            ->where([
                ['status','1'],
                ['created_by',$createdBy]
            ])
            ->count();
            
        $mSite = DB::table('m_site')
            ->get();
        
        
        if($countOpname == '0'){
            return view('StockOpname/newStockOpname', compact('firstNumber','mSite'));
            
        }else{
            $dataOpname = DB::table('inv_stock_opname')
                ->where([
                    ['status','1'],
                    ['created_by',$createdBy]
                ])
            ->first();
            $opnameNumber = $dataOpname->number_so;
            $sumStockOpname = DB::table('inv_list_opname')
                ->select(DB::raw('SUM(last_stock) as lastStock'), DB::raw('SUM(input_stock) as inputStock'))
                ->where([
                    ['sto_number',$opnameNumber]
                ])
                ->first();
                
            $stockOpname = DB::table('inv_stock_opname as a')
                ->select('a.*','b.site_name')
                ->leftJoin('m_site as b','a.loc_so','=','b.idm_site')
                ->where('number_so',$opnameNumber)
                ->first();
                
            return view('StockOpname/newStockOpnameBarang', compact('mProduct','opnameNumber','sumStockOpname','countOpname','stockOpname','mSite'));
        }
    }
    
    public function disInputBarang(){
        
    }
    
    public function submitStockOpname(Request $reqForm){
        $noStockOpname = $reqForm->noStockOpname;
        $filterTanggal = $reqForm->filterTanggal;
        $pilihLokasi = $reqForm->pilihLokasi;
        $description = $reqForm->description;
        $thisPeriode = date('mY');
        $createdBy = Auth::user()->name;
           
        $cekDelNumber = DB::table('inv_stock_opname')
            ->where('number_so',$noStockOpname)
            ->count();
            
        if($cekDelNumber == '0'){
            DB::table('inv_stock_opname')
                ->insert([
                    'number_so'=>$noStockOpname,
                    'periode'=>$thisPeriode,
                    'date_so'=>$filterTanggal,
                    'loc_so'=>$pilihLokasi,
                    'description'=>$description,
                    'created_by'=>$createdBy,
                    'date_input'=>now()
                ]);
        }
        else{
            DB::table('inv_stock_opname')
                ->where('number_so',$noStockOpname)
                ->update([
                    'periode'=>$thisPeriode,
                    'date_so'=>$filterTanggal,
                    'loc_so'=>$pilihLokasi,
                    'description'=>$description,
                    'created_by'=>$createdBy,
                    'status'=>'1',
                    'date_input'=>now()
                ]);
        }
            
        return back();
    }
   
   public function listDataOpname(){
       return view('StockOpname/listDataOpname');
   }

   public function listTableOpname($fromDate, $endDate, $status)
   {
        $approval = $this->userApproval();

        $summaryOpname = DB::table('inv_stock_opname as a');
        $summaryOpname = $summaryOpname->leftJoin('m_site as b','a.loc_so','b.idm_site');
        if ($fromDate=='0' OR $endDate=='0') {
            $summaryOpname = $summaryOpname->where('a.status',$status);
        }
        else {
            $summaryOpname = $summaryOpname->where('a.status',$status);            
            $summaryOpname = $summaryOpname->whereBetween('a.date_so',[$fromDate,$endDate]);
        }
        $summaryOpname = $summaryOpname->orderBy('a.idinv_opname','desc');
        $summaryOpname = $summaryOpname->limit(100);
        $summaryOpname = $summaryOpname->get();
            
        return view('StockOpname/tableDokOpname', compact('summaryOpname','approval'));
   }
   
   public function detailOpname($opnameCode){
        $detailOpname = DB::table('inv_stock_opname as a')
            ->select('a.*','b.site_name')
            ->leftJoin('m_site as b', 'a.loc_so','=','b.idm_site')
            ->where('a.number_so',$opnameCode)
            ->first();
        $loc = $detailOpname->loc_so;
        
        $detailProductLs = DB::table('inv_list_opname as a')
            ->leftJoin('view_product_stock as b','a.inv_id','=','b.idinv_stock')
            ->where([
                ['a.sto_number',$opnameCode],
                ['a.display','1']
                ])
            ->get();
            
        $sumDetailOpname = DB::table('inv_list_opname')
            ->select(DB::raw('SUM(last_stock) as lastStock'), DB::raw('SUM(input_stock) as inputStock'))
            ->where([
                ['sto_number',$opnameCode]
            ])
            ->first();
            
       return view('StockOpname/listDataOpnameDetail', compact('detailOpname','detailProductLs','sumDetailOpname'));
    }
   
   
   
   public function submitUpdateStockOpname(Request $reqUpdateForm){
       $noStockOpname = $reqUpdateForm->noStockOpname;
       $filterTanggal = $reqUpdateForm->filterTanggal;
       $pilihLokasi = $reqUpdateForm->pilihLokasi;
       $description = $reqUpdateForm->description;
       $thisPeriode = date('mY');
       $createdBy = Auth::user()->name;
       
        DB::table('inv_stock_opname')
            ->where('number_so',$noStockOpname)
            ->update([
                'date_so'=>$filterTanggal,
                'loc_so'=>$pilihLokasi,
                'description'=>$description,
                'updated_by'=>$createdBy,
            ]);
            
        return back();
   }
   
    
   
   public function satuan($productId){
       $createdBy = Auth::user()->name;
        $location = DB::table('inv_stock_opname')
            ->where([
                ['created_by',$createdBy]
            ])
            ->first();
            
        $productSatuan = DB::table('m_product_unit')
            ->where([
                ['core_id_product',$productId],
                ['product_volume','!=','0'],
                ['product_satuan','!=','']
                ])
            ->orderBy('size_code','desc')
            ->get();
        
        return view('StockOpname/listSatuan', compact('productSatuan'));
   }
   public function lastQty($satuan, $productId,$location){
       $userArea = $this->TempUsersController->checkuserInfo();
       $countData = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productId],
                ['product_size',$satuan],
                ['location_id',$location],
                ])
            ->count();
            
       $lastStock = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productId],
                ['product_size',$satuan],
                ['location_id',$location],
                ])
            ->first();
            
            if($countData<>'0'){
                return response()->json([
                    'lastQty' => $lastStock->stock,
                    'invID' => $lastStock->idinv_stock,
                    'unitID' => $lastStock->product_id,
                    'unitVol' => $lastStock->product_volume,
                ]);
            }
            else{
                return response()->json([
                    'lastQty' => '0',
                    'invID' => '0',
                    'unitID' => '0',
                    'unitVol' => $satuan,
                ]);
            }
            return response()->json(['error' => 'Product not found'], 404);
   }
   
    public function submitOpname (Request $reqSubmit){
        $noOpname = $reqSubmit->noOpname;        
        $product = $reqSubmit->product;
        $satuan = $reqSubmit->satuan;
        $qty = $reqSubmit->qty;
        $lastStock = $reqSubmit->lastStock;
        $total = $reqSubmit->total;

        $invID = $reqSubmit->invID;
        $location = $reqSubmit->location;
        $unitID = $reqSubmit->unitID;
        $unitVol = $reqSubmit->unitVol;

        $createdBy = Auth::user()->name;
        
        //Check Vol Unit 
        //Jika data produk tidak ada pada table inventory
        if($invID=="0"){
            //cari id unit
            $dbUnit = DB::table('product_list_view')
                ->select('idm_product_satuan')
                ->where([
                    ['core_id_product',$product],
                    ['product_size',$satuan]
                    ])
                ->first();
            $prodIDUnit = $dbUnit->idm_product_satuan;
            
            //insert data to inventori
            $insertInv = DB::table('inv_stock')
                ->insert([
                    'product_id'=>$prodIDUnit,    
                    'location_id'=>$location,    
                ]);
                
            $Lastid = DB::getPdo()->lastInsertId($insertInv);
            
            $cekProduct = DB::table('inv_list_opname')
            ->where([
                    ['sto_number',$noOpname],
                    ['inv_id',$Lastid],
                    ['status','1'],
                    ['created_by',$createdBy]
                ])
            ->count();
            
            $productUnit = DB::table('product_list_view as a')
                ->select('a.*','b.location_id','b.stock','b.idinv_stock')
                ->leftJoin('inv_stock as b','a.idm_product_satuan','b.product_id')
                ->where([
                    ['a.core_id_product',$product],
                    ['b.location_id',$location]
                    ])
                ->get();
                
            if($cekProduct == '0' AND ($qty <> '0' AND $qty <> '')){
                foreach($productUnit as $inputUnit){
                    DB::table('inv_list_opname')
                        ->insert([
                            'sto_number'=>$noOpname, 
                            'inv_id'=>$Lastid,
                            'product_id'=>$inputUnit->idm_data_product,
                            'product_size'=>$inputUnit->product_satuan,
                            'last_stock'=>$inputUnit->stock,
                            'input_qty'=>$qty,
                            'selisih'=>$total,
                            'saldo_konv'=>$qty,
                            'created_by'=>$createdBy,
                            'unit_volume'=>$inputUnit->product_volume,
                            'status'=>'1',
                        ]);
                }
                $msg = array('success'=>'<h4>SUCCESS</h4> Produk berhasil dimasukkan! '.$product);
            }
            elseif($cekProduct >= '1' AND ($qty <> '0' OR $qty <> '')){
                $msg = array('warning'=>'<h4>ERROR</h4> Barang yang dimasukkan sudah ada! '.$cekProduct); 
            }
            elseif($cekProduct == '0' AND ($qty == '')){
                $msg = array('warning'=>'<h4>ERROR</h4> Qty tidak boleh kosong!'); 
            }
        }
        else{
            //Cek apakah item sudah ada atau belum
            $cekProduct = DB::table('inv_list_opname')
            ->where([
                    ['sto_number',$noOpname],
                    ['inv_id',$invID],
                    ['status','1'],
                    ['created_by',$createdBy]
                ])
            ->count();
            
            // Hitung saldo konversi
            $mUnit = DB::table('m_product_unit')
                ->select('size_code','product_volume','product_satuan')
                ->where('core_id_product',$product)
                ->orderBy('size_code','desc')
                ->first();
            $sizeCodeDesc = $mUnit->size_code;

            $mProduct = DB::table('m_product')                
                ->where('idm_data_product',$product)
                ->first();
            $volB = $mProduct->large_unit_val;
            $volK = $mProduct->medium_unit_val;
            $volKonv = $mProduct->small_unit_val;

            if ($sizeCodeDesc == '1') {
                $inputSaldo = $qty;
            }
            elseif ($sizeCodeDesc == '2') {
                if ($satuan == "BESAR") {
                    $i = $qty * $volB;
                    $inputSaldo = (int)$i;
                }
                elseif ($satuan == "KECIL") {
                    $inputSaldo = $qty;
                }
            }
            elseif ($sizeCodeDesc == '3') {
                if ($satuan == "BESAR") {
                    $i = $qty * $volKonv;
                    $inputSaldo = (int)$i;
                }
                elseif ($satuan == "KECIL") {
                    $i = $qty * $volK;
                    $inputSaldo = (int)$i;
                }
                elseif ($satuan == "KONV") {
                    $inputSaldo = $qty;
                }
            }
            
            $display = '1';

            if($cekProduct == '0' AND $qty <> ''){
                DB::table('inv_list_opname')
                    ->insert([
                        'sto_number'=>$noOpname, 
                        'inv_id'=>$invID,
                        'product_id'=>$product,
                        'product_size'=>$satuan,
                        'last_stock'=>$lastStock,
                        'input_qty'=>$qty,
                        'selisih'=>$total,
                        'saldo_konv'=>$inputSaldo,
                        'unit_volume'=>$unitVol,
                        'created_by'=>$createdBy,
                        'status'=>'1',
                        'display'=>$display
                    ]);               
                
                $msg = array('success'=>'<h4>SUCCESS</h4> Produk berhasil dimasukkan! ');
            }
            elseif($cekProduct >= '1' AND ($qty <> '0' OR $qty <> '')){
                $msg = array('warning'=>'<h4>ERROR</h4> Barang yang dimasukkan sudah ada! '.$cekProduct); 
            }
            elseif($cekProduct == '0' AND $qty == ''){
                $msg = array('warning'=>'<h4>ERROR</h4>Qty tidak boleh kosong!'); 
            }
        }
        return response()->json($msg);
    }
   
   public function listBarang ($noOpname, $codeDisplay){
       $createdBy = Auth::user()->name;
    //   $mProduct = DB::table('inv_list_opname as a')
    //     ->where([
    //         ['a.sto_number',$noOpname],    
    //         ['a.created_by',$createdBy]    
    //     ])
    //     ->groupBy('a.product_id')
    //     ->get();
        if($codeDisplay == '1'){
            $listBarang = DB::table('inv_list_opname as a')
                ->join('view_product_stock as b','a.inv_id','=','b.idinv_stock')
                ->where([
                    ['a.sto_number',$noOpname],
                    ['a.display','1']
                ])
                ->get();
        }
        else{
            $listBarang = DB::table('inv_list_opname as a')
                ->join('view_product_stock as b','a.inv_id','=','b.idinv_stock')
                ->where([
                    ['a.sto_number',$noOpname],    
                    ['a.created_by',$createdBy],
                    ['a.display','1']
                ])
                ->get();
            
        }
      
        return view('StockOpname/listTableInputBarang', compact('listBarang'));
   }
   
   public function modalEditBarang($idlist){
       $listBarang = DB::table('inv_list_opname')
        ->where('id_list',$idlist)
        ->get();
        
        return view('StockOpname/modalEditBarang', compact('listBarang'));
   }
   
   public function submitOpnameReport (Request $reportOpname){
       $sumLastStock = $reportOpname->sumLastStock;
       $sumInputStock = $reportOpname->sumInputStock;
       $selisih = $reportOpname->selisih;
       $note = $reportOpname->note;
       $noOpname = $reportOpname->noOpname;
       
       DB::table('inv_stock_opname')
        ->where('number_so',$noOpname)
        ->update([
            't_last_stock'=>$sumLastStock,  
            't_input_stock'=>$sumInputStock,  
            'selisih'=>$selisih,  
            'note_submit'=>$note,  
            'status'=>'2',  
        ]);
       DB::table('inv_list_opname')
        ->where('sto_number',$noOpname)
        ->update([
            'status'=>'2',
        ]);
       
   }
   
   public function approvalOpname ($idOpname){
    //   echo $idOpname;
        //   Update Stock
        $listOpname = DB::table('inv_list_opname')
            ->where('sto_number',$idOpname)
            ->get();
            
        $locOpname = DB::table('inv_stock_opname')
            ->select('loc_so')
            ->where('number_so',$idOpname)
            ->first();
            
        $updateBy = Auth::user()->name;
        
        $countBarang = DB::table('inv_list_opname')
            ->where('sto_number',$idOpname)
            ->count();
            
        if($countBarang == '0'){
            $msg = array('warning'=>'ERROR!, Tidak ada product yang dimasukkan');
        }else{
            foreach($listOpname as $lop){
                //$updateStock = $lop->last_stock + $lop->input_stock;
                
                DB::table('inv_stock')
                    ->where('idinv_stock',$lop->inv_id)
                    ->update([
                        'stock'=>$lop->input_stock2,
                        'stock_unit'=>$lop->input_stock,
                        'saldo'=>$lop->input_stock2,
                    ]);
            }
            DB::table('inv_stock_opname')
                ->where('number_so',$idOpname)
                ->update([
                    'status'=>'3'    
                ]);
                
            DB::table('inv_list_opname')
                ->where('sto_number',$idOpname)
                ->update([
                    'status'=>'3'    
                ]);
        }
        $msg = array('success'=>'SUCCESS, Data Berhasil Disimpan ');
        return response()->json($msg);
    }
    
    public function deleteDataOpname ($idOpname){
        DB::table('inv_stock_opname')
            ->where('number_so',$idOpname)
            ->update([
                'status'=>'0'    
            ]);
            
        DB::table('inv_list_opname')
            ->where('sto_number',$idOpname)
            ->delete();
    }
    
    public function deleteBarang($idparam){
        DB::table('inv_list_opname')
            ->where('product_id',$idparam)
            ->delete();
    }
    
    public function editOpname($idparam){
        $docOpname = DB::table('inv_stock_opname')
            ->where('number_so',$idparam)
            ->first();
            
        $mProduct = DB::table('m_product')
            ->get();
            
        $listOpname = DB::table('inv_list_opname as a')
            ->select('a.id_list','a.inv_id','a.product_id','a.last_stock','a.input_stock','a.input_stock2','a.unit_volume','a.status','b.*')
            ->leftJoin('view_product_stock as b', 'a.inv_id','=','b.idinv_stock')
            ->where('a.sto_number',$idparam)
            ->get();
            
        $sumStockOpname = DB::table('inv_list_opname')
                ->select(DB::raw('SUM(last_stock) as lastStock'), DB::raw('SUM(input_stock) as inputStock'))
                ->where([
                    ['sto_number',$idparam]
                ])
                ->first();
            
        return view('StockOpname/editlistOpname', compact('docOpname','listOpname','mProduct','sumStockOpname','idparam'));
    }
    
    public function editDocumentOpname($idParam){
        $docOpname2 = DB::table('inv_stock_opname as a')
                ->select('a.*','b.site_name')
                ->leftJoin('m_site as b','a.loc_so','=','idm_site')
                ->where('number_so',$idParam)
                ->first();
                
        $mLoc = DB::table('m_site')
            ->get();
            
        return view('StockOpname/editFormOpname', compact('docOpname2','mLoc','idParam'));
    }
    
    public function saveToEditTable(Request $reqSaveEdit){
        $table = $reqSaveEdit->tableName;
        $colName = $reqSaveEdit->column;
        $editVal = $reqSaveEdit->editVal;
        $id = $reqSaveEdit->id;
        $colId = $reqSaveEdit->tableId;
        $prdId = $reqSaveEdit->prdId;
        
        // Ambil data terakhir dari product_unit berdasarkan size_code terbesar!
        $unitPrd = DB::table('m_product_unit')
            ->where('core_id_product',$prdId)
            ->orderBy('size_code','desc')
            ->first();
        $valKonv = $unitPrd->product_volume;
        $valSize = $unitPrd->product_size;
        
        // Ambil data ukuran kecil dari product unit
        $unitKecil = DB::table('m_product_unit')
            ->where([
                ['core_id_Product',$prdId],
                ['size_code','2']
                ])
            ->first();
            
        if(!empty($unitKecil)){
            $valKecil = $unitKecil->product_volume;
            $sizeKecil = $unitKecil->product_size;
        }
        
    }
}
