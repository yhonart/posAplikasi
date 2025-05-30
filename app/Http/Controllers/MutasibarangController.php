<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class MutasibarangController extends Controller
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
    
    public function numberMutasi(){
        $thisPeriode = date('my');
        $company = Auth::user()->company;
        
        $countPeriode = DB::table('inv_moving')
            ->where([
                ['periode',$thisPeriode],
                ['comp_id',$company]
                ])
            ->count();

        $companycode = DB::table('m_company')
            ->where('idm_company',$company)
            ->first();

        $cmpid = $companycode->company_code;
            
        if($countPeriode=='0'){
            $pag = '1';
            $nopag = "M".$cmpid."".$thisPeriode."-".sprintf("%07d",$pag);
        }
        else{
            
            //cek deleted number
            $pag = $countPeriode+1;
            $nopag = "M".$cmpid."".$thisPeriode."-".sprintf("%07d",$pag);
            
            // $deletedNumber = DB::table('inv_moving')
            //     ->where('status','0')
            //     ->first();
                
            // if(empty($deletedNumber)){
            // }
            // else{
            //     $nopag = $deletedNumber->number_so;
            // }
        }
        return $nopag;
    }
    
    public function countNumberActive(){
        $userName = Auth::user()->name;
        $countNumber = DB::table('inv_moving')
            ->where([
                ['created_by',$userName],
                ['status','1']
            ])
            ->count();
        return $countNumber;
    }
    
    public function showNumberActive(){
        $userName = Auth::user()->name;
        $showNumber = DB::table('inv_moving')
            ->where([
                ['created_by',$userName],
                ['status','1']
            ])
            ->first();
        if (!empty($showNumber)) {
            $showNo = $showNumber->number;
        }
        else {
            $showNo = '0';
        }
        return $showNo;
    }
    
    public function userApproval (){
        $userID = Auth::user()->id;
        $cekUserGroup = DB::table('users_group')
            ->where([
                ['user_id',$userID],
                ['group_code','1']
            ])
            ->orWhere([
                ['user_id',$userID],
                ['group_code','2']
            ])
            ->count();
            
        return $cekUserGroup;
    }

    public function mutasi(){
        return view('Mutasi/main');
    }
    
    public function tableDataMutasi(){       
        $userArea = $this->checkuserInfo();
        $mloc = DB::table('m_site')
            ->where('idm_site',$userArea)
            ->first();
            
        return view('Mutasi/listDataMutasi',compact('mloc'));
    }
    
    public function tableDokMutasi($fromDate, $endDate, $status)
    {
        $approval = $this->userApproval();
        $userArea = $this->checkuserInfo();
        $company = Auth::user()->company;

        if ($fromDate == '0' && $endDate == '0') {
            $tanggalAwal = Carbon::now()->startOfMonth();
            $tanggalAkhir  = Carbon::now()->endOfMonth();
        }
        else {
            $tanggalAwal = $fromDate;
            $tanggalAkhir  = $endDate;
        }

        $tableMoving = DB::table('inv_moving');
        if ($status == "All") {
            $tableMoving=$tableMoving->whereBetween('status',['2','4']);
        }
        else {
            $tableMoving=$tableMoving->where('status',$status);
        }
        $tableMoving = $tableMoving->where('comp_id',$company);
        $tableMoving=$tableMoving->whereBetween('date_moving',[$tanggalAwal,$tanggalAkhir]);
        $tableMoving=$tableMoving->orderBy('idinv_moving','desc');
        $tableMoving=$tableMoving->limit(100);
        $tableMoving=$tableMoving->get();

        $mSites = DB::table('m_site')
            ->get();

        return view('Mutasi/tableDokMutasi',compact('tableMoving','approval','userArea','mSites','tanggalAwal','tanggalAkhir'));
    }

    public function getTableInputProduct (){
        $countActive = $this->countNumberActive();
        $number = $this->showNumberActive();
        $company = Auth::user()->company;

        $location = '0';

        $mProduct = DB::table('m_product')
            ->orderBy([
                ['product_name','asc'],
                ['comp_id',$company]
                ])
            ->get();
            
        $tbMutasiL = DB::table('inv_moving')
            ->where('number',$number)
            ->first();
        
        $mLoc = DB::table('m_site')
            ->get();

        if (!empty($tbMutasiL)) {
            $location = $tbMutasiL->from_loc;
        }    
            
        $sumMutasi = DB::table('inv_moving_list')
            ->select(DB::raw('SUM(stock_taken) as totalMoving'))
            ->where('mutasi_code',$number)
            ->first();
            
        return view('Mutasi/formInputBarangMutasi',compact('countActive','mProduct','number','tbMutasiL','sumMutasi','mLoc'));
    }

    public function formEntryMutasi(){
        $number = $this->numberMutasi();
        $countActive = $this->countNumberActive();
        $numberAct = $this->showNumberActive();
        $userID = Auth::user()->name;
        $company = Auth::user()->company;

        $mLoc = DB::table('m_site')
            ->get();

        $counInvMoving = DB::table('inv_moving')
            ->where([
                ['status','1'],
                ['created_by',$userID] ,
                ['comp_id',$company]
                ])
            ->count();

        $mProduct = DB::table('m_product')
            ->where('comp_id',$company)
            ->orderBy('product_name','asc')
            ->get();

        $tbMutasiL = DB::table('inv_moving')
            ->where('number',$numberAct)
            ->first();

        $sumMutasi = DB::table('inv_moving_list')
            ->select(DB::raw('SUM(stock_taken) as totalMoving'))
            ->where('mutasi_code',$numberAct)
            ->first();

        if ($counInvMoving == '0') {
            return view('Mutasi/formInputMutasi',compact('mLoc','number','counInvMoving'));
        }
        else {
            return view('Mutasi/formInputBarangMutasi',compact('countActive','mProduct','numberAct','tbMutasiL','sumMutasi','mLoc'));
        }
            
    }
    
    public function submitMutasi(Request $reqPostMutasi){
        $number = $reqPostMutasi->number;
        $tglMutasi = $reqPostMutasi->tglMutasi;
        $fromLoc = $reqPostMutasi->fromLoc;
        $toLoc = $reqPostMutasi->toLoc;
        $description = $reqPostMutasi->description;
        $userID = Auth::user()->name;
        $thisPeriode = date('my');
        $company = Auth::user()->company;
        
        DB::table('inv_moving')
            ->insert([
                'number'=>$number,    
                'date_moving'=>$tglMutasi,    
                'from_loc'=>$fromLoc,    
                'to_loc'=>$toLoc,    
                'notes'=>$description,    
                'created_by'=>$userID,
                'periode'=>$thisPeriode,
                'status'=>'1',
                'comp_id'=>$company
            ]);
    }
    
    public function entryStock($satuanVal, $productVal, $warehouse){
        $lastStock = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productVal],
                ['product_size',$satuanVal],
                ['location_id',$warehouse],
                ])
            ->first();
            
            return response()->json([
                'lastQty' => $lastStock->stock,
                'invID' => $lastStock->idinv_stock
            ]);
            return response()->json(['error' => 'Product not found'], 404);
    }
    
    public function listBarang($mutasiCode){
        // echo $mutasiCode;
        $listMutasi = DB::table('inv_moving_list as a')
            ->leftJoin('view_product_stock as b', 'a.inv_id', '=', 'b.idinv_stock')
            ->where('a.mutasi_code',$mutasiCode)
            ->orderBy('a.idm_list','asc')
            ->get();
            
        return view('Mutasi/formInputTableMutasi',compact('listMutasi','mutasiCode'));
    }
    
    public function submitDataBarang (Request $reqbarang){
        $numberMutasi = $reqbarang->noMutasi;
        $invID = $reqbarang->invID;
        $warehouse = $reqbarang->warehouse;
        $mProduct = $reqbarang->product;
        $satuan = $reqbarang->satuan;
        $lastStock = $reqbarang->lastStock;
        $qty = $reqbarang->qty;
        $keterangan = $reqbarang->keterangan;
        $userID = Auth::user()->name;

        //Hitung saldo berdasarkan nilai konversi. 
        //Cari nilai konversi
        $mUnit = DB::table('m_product_unit')
                ->select('size_code','product_volume')
                ->where('core_id_product',$mProduct)
                ->orderBy('size_code','desc')
                ->first();

        $sizeCodeDesc = $mUnit->size_code;
        $stockAsalBarang = $lastStock - $qty;

        $masterProduct = DB::table('m_product')
                    ->where('idm_data_product',$mProduct)
                    ->first();

                $volB = $masterProduct->large_unit_val;
                $volK = $masterProduct->medium_unit_val;
                $volKonv = $masterProduct->small_unit_val;

        //Hitung total dari asal barang
        if ($sizeCodeDesc == '1') {
            $saldoAsalBarang = $stockAsalBarang;
        }
        elseif ($sizeCodeDesc == '2') {
            if ($satuan == "BESAR") {
                $saldoAsalBarang1 = $stockAsalBarang * $volB;
                $saldoAsalBarang = (int)$saldoAsalBarang1;
            }
            elseif ($satuan == "KECIL") {
                $saldoAsalBarang = $stockAsalBarang;
            }
        }
        elseif ($sizeCodeDesc == '3') {
            if ($satuan == "BESAR") {
                $saldoAsalBarang1 = $stockAsalBarang * $volKonv;
                $saldoAsalBarang = (int)$saldoAsalBarang1;
            }
            elseif ($satuan == "KECIL") {
                $saldoAsalBarang1 = $stockAsalBarang * $volK;
                $saldoAsalBarang = (int)$saldoAsalBarang1;
            }
            elseif ($satuan == "KONV") {
                $saldoAsalBarang = $stockAsalBarang;
            }
        }

        //Hitung tambah saldo tujuan barang.
        $tujuanMoving = DB::table('inv_moving')
            ->select('to_loc')
            ->where('number',$numberMutasi)
            ->first();

        //Cari konv stock pada tabel inventori
        $invLocStock = DB::table('view_product_stock')
            ->select('stock')
            ->where([
                ['idm_data_product',$mProduct],
                ['location_id',$tujuanMoving->to_loc],
                ['product_size',$satuan]
            ])
            ->orderBy('size_code','desc')
            ->first();

        $stockTujuanBarang = $invLocStock->stock;
        $saldo = $stockTujuanBarang + $qty;

        if ($sizeCodeDesc == '1') {
            $saldoTujuanBarang = $saldo;
        }
        elseif ($sizeCodeDesc == '2') {
            if ($satuan == "BESAR") {
                $saldoTujuanBarang1 = $saldo * $volB;
                $saldoTujuanBarang = (int)$saldoTujuanBarang1;
            }
            elseif ($satuan == "KECIL") {
                $saldoTujuanBarang = $saldo;
            }
        }
        elseif ($sizeCodeDesc == '3') {
            if ($satuan == "BESAR") {
                $saldoTujuanBarang1 = $saldo * $volKonv;
                $saldoTujuanBarang = (int)$saldoTujuanBarang1;
            }
            elseif ($satuan == "KECIL") {
                $saldoTujuanBarang1 = $saldo * $volK;
                $saldoTujuanBarang = (int)$saldoTujuanBarang1;
            }
            elseif ($satuan == "KONV") {
                $saldoTujuanBarang = $saldo;
            }
        }
        DB::table('inv_moving_list')
            ->insert([
                'mutasi_code'=>$numberMutasi,   
                'inv_id'=>$invID,   
                'product_id'=>$mProduct,   
                'satuan'=>$satuan,   
                'last_stock'=>$lastStock,   
                'stock_taken'=>$qty,   
                'notes'=>$keterangan, 
                'from_loc_saldo'=>$saldoAsalBarang,
                'destination_loc_saldo'=>$saldoTujuanBarang
            ]);
    }
    
    public function submitTotalMutasi (Request $reqPostTotal){
        $sumTotalMutasi = $reqPostTotal->sumTotalMutasi;
        $noMutasi = $reqPostTotal->noMutasi;
        $userName = Auth::user()->name;
        DB::table('inv_moving')
            ->where('number',$noMutasi)
            ->update([
                'total_mutasi'=>$sumTotalMutasi,
                'updated_by'=>$userName,
                'status'=>'2'
            ]);
            
        DB::table('inv_moving_list')
            ->where('mutasi_code',$noMutasi)
            ->update([
                'status'=>'2'
            ]);
            
        return back();
    }
    
    public function submitUpdateMutasi (Request $reqUpdateMutasi){
        DB::table('inv_moving')
            ->where('number',$reqUpdateMutasi->number)
            ->update([
                'date_moving'=>$reqUpdateMutasi->tglMutasi,  
                'from_loc'=>$reqUpdateMutasi->fromLoc,  
                'to_loc'=>$reqUpdateMutasi->toLoc,  
                'notes'=>$reqUpdateMutasi->description,  
            ]);
    }
    
    public function detailMutasi($idParam){
        $docMutasi = DB::table('inv_moving')
            ->where('number',$idParam)
            ->first();
        $locationID = $docMutasi->from_loc;

        $listMutasi = DB::table('inv_moving_list as a')
            ->select('a.*','b.product_name','b.product_satuan')
            ->leftJoin('view_product_stock as b', 'a.inv_id','=','b.idinv_stock')
            ->where('a.mutasi_code',$idParam)
            ->get();

        $userArea = $this->checkuserInfo();
        $mlocDetail = DB::table('m_site')
            ->where('idm_site',$userArea)
            ->first();

        $asalBarang = DB::table('inv_moving as a')
            ->select('a.from_loc','b.site_name')
            ->leftJoin('m_site as b','a.from_loc','=','b.idm_site')
            ->where('a.number',$idParam)
            ->first();

        $tujuanBarang = DB::table('inv_moving as a')
            ->select('a.to_loc','b.site_name')
            ->leftJoin('m_site as b','a.to_loc','=','b.idm_site')
            ->where('a.number',$idParam)
            ->first();
            
        return view('Mutasi/detailTableMutasi',compact('docMutasi','listMutasi','idParam','mlocDetail','asalBarang','tujuanBarang'));
    }
    
    public function editDocMutasi ($idParam){
        // echo $idParam;
        
        $tbMutasi = DB::table('inv_moving')
            ->where('number',$idParam)
            ->first();
        
        $asalBarang = DB::table('inv_moving as a')
            ->select('a.from_loc','b.site_name')
            ->leftJoin('m_site as b','a.from_loc','=','b.idm_site')
            ->where('a.number',$idParam)
            ->first();

        $tujuanBarang = DB::table('inv_moving as a')
            ->select('a.to_loc','b.site_name')
            ->leftJoin('m_site as b','a.to_loc','=','b.idm_site')
            ->where('a.number',$idParam)
            ->first();
        
        
        $mLoc = DB::table('m_site')
            ->get();
            
        return view('Mutasi/editDocMutasi',compact('tbMutasi','mLoc','asalBarang','tujuanBarang'));
    }
    
    public function satuan($productId, $docNumber){
        $createdBy = Auth::user()->name;
        $location = DB::table('inv_moving')
            ->where([
                ['number', $docNumber]
            ])
            ->first();
        
        $productSatuan = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productId],
                ['location_id',$location->from_loc]
                ])
            ->orderBy('size_code','desc')
            ->get();
        
        return view('StockOpname/listSatuan', compact('productSatuan'));
   }
   
   public function delivery ($idParam){
        DB::table('inv_moving')
            ->where('number',$idParam)
            ->update([
                'status'=>'3'    
            ]);
        
        DB::table('inv_moving_list')
            ->where('mutasi_code',$idParam)
            ->update([
                'status'=>'3'    
            ]);
   }
   
   public function pickup($idParam){
        $updateBy = Auth::user()->name;
        $company = Auth::user()->company;

        // get list data berdasarkan asal barang
        $listProduk = DB::table('inv_moving_list as a')
            ->select('a.*','b.product_size','b.product_satuan','b.size_code','b.product_volume','b.product_name','b.stock','b.location_id','b.idinv_stock')
            ->leftJoin('view_product_stock as b', 'b.idinv_stock','=','a.inv_id')
            ->where('a.mutasi_code',$idParam)
            ->get();
            
        $docMutasi = DB::table('inv_moving')
            ->where('number',$idParam)
            ->first();
            
        $toLoc = $docMutasi->to_loc;
        $fromLoc = $docMutasi->from_loc;
        $dateMutasi = $docMutasi->date_moving;
        
        //Untuk membuat description
        $mToLoc = DB::table('m_site')
            ->where('idm_site',$toLoc)
            ->first();
            
        $mFromLoc = DB::table('m_site')
            ->where('idm_site',$fromLoc)
            ->first();
        
        $fromLocName = $mFromLoc->site_name;    
        $toLocName = $mToLoc->site_name;    
        $description = "Moving Dari ".$fromLocName." ke ".$toLocName;
        //End create Description

        foreach($listProduk as $lp){
            $productID = $lp->product_id;
            $satuan = $lp->satuan; //BESAR,KECIL,KONV
            $lastStock = $lp->stock; //Aktual stok dari table stok
            $takenStock = $lp->stock_taken; //Stok diambil
            $asalBarang = $lp->from_loc_saldo;
            $tujuanBarang = $lp->destination_loc_saldo;            
            $penguranganStock = $lastStock - $takenStock; // Untuk dilakukan update ke stok asal barang
            $prodName = $lp->product_name;
            $sizeCode = $lp->size_code;
            $locAsalBarang = $lp->location_id;
            $invID = $lp->idinv_stock;

            $mProduct = DB::table('m_product')
                    ->where('idm_data_product',$productID)
                    ->first();

            $volB = $mProduct->large_unit_val;
            $volK = $mProduct->medium_unit_val;
            $volKonv = $mProduct->small_unit_val;
            $prodName = $mProduct->product_name;

            $mUnit = DB::table('m_product_unit')
                ->select('size_code','product_volume')
                ->where('core_id_product',$productID)
                ->orderBy('size_code','desc')
                ->first();

            $sizeCodeDesc = $mUnit->size_code;

            if ($sizeCodeDesc == '1') {
                $qtyMoving = $takenStock;
                $qtyLastStock = $lastStock;
            }
            elseif ($sizeCodeDesc == '2') {
                if ($satuan == "BESAR") {
                    $qtyMoving1 = $takenStock * $volB;
                    $qtyMoving = (int)$qtyMoving1;
                    $qtyLastStock1 = $lastStock * $volB;
                    $qtyLastStock = (int)$qtyLastStock1;
                }
                elseif ($satuan == "KECIL") {
                    $qtyMoving = $takenStock;
                    $qtyLastStock = $lastStock;
                }
            }
            elseif ($sizeCodeDesc == '3') {
                if ($satuan == "BESAR") {
                    $qtyMoving1 = $takenStock * $volKonv;
                    $qtyMoving = (int)$qtyMoving1;
                    $qtyLastStock1 = $lastStock * $volKonv;
                    $qtyLastStock = (int)$qtyLastStock1;
                }
                elseif ($satuan == "KECIL") {
                    $qtyMoving1 = $takenStock * $volK;
                    $qtyMoving = (int)$qtyMoving1;
                    $qtyLastStock1 = $lastStock * $volK;
                    $qtyLastStock = (int)$qtyLastStock1;
                }
                elseif ($satuan == "KONV") {
                    $qtyMoving = $takenStock;
                    $qtyLastStock = $lastStock;
                }
            }

            //Cek saldo di laporan inventory yang terakhir sebelum dilakukan approval
            if ($fromLoc == $locAsalBarang) {
                $itemIn = '0';
                $itemOut = $qtyMoving;
                $reportSaldo = $qtyLastStock - $qtyMoving;

                DB::table('report_inv')
                    ->insert([
                        'date_input'=>$dateMutasi,
                        'number_code'=>$idParam,
                        'product_id'=>$productID,
                        'product_name'=>$prodName,
                        'satuan'=>$satuan,
                        'satuan_code'=>$lp->size_code,
                        'description'=>$description,
                        'inv_in'=>$itemIn,
                        'inv_out'=>$itemOut,
                        'saldo'=>$reportSaldo,
                        'created_by'=>$updateBy,
                        'location'=>$fromLoc,
                        'last_saldo'=>$lastStock,
                        'vol_prd'=>$sizeCode,
                        'actual_input'=>$takenStock,
                        'status_trx'=>'4',
                        'comp_id'=>$company
                    ]);
            }

            $this->TempInventoryController->reportBarangMasuk ($productID, $invID, $satuan, $toLoc, $takenStock, $description, $idParam, $updateBy, $dateMutasi);

            //Update Stock
            $this->TempInventoryController->penguranganItem ($productID, $penguranganStock, $satuan, $fromLoc);
            $this->TempInventoryController->penambahanItem ($productID, $takenStock, $satuan, $toLoc);
        }
        
        DB::table('inv_moving')
            ->where('number',$idParam)
            ->update([
                'status'=>'4'    
            ]);
        
        DB::table('inv_moving_list')
            ->where('mutasi_code',$idParam)
            ->update([
                'status'=>'4'    
            ]);        
   }
   
   public function editMutasi ($idparam){
        $company = Auth::user()->company;

        $mProduct = DB::table('m_product')
            ->where('comp_id',$company)
            ->orderBy('product_name','asc')
            ->get();
            
        $tbMutasi = DB::table('inv_moving')
            ->where('number',$idparam)
            ->first();
            
        $mLoc = DB::table('m_site')
            ->get();
            
        $location = $tbMutasi->from_loc;
            
        $sumMutasi = DB::table('inv_moving_list')
            ->select(DB::raw('SUM(stock_taken) as totalMoving'))
            ->where('mutasi_code',$idparam)
            ->first();
            
       return view ("Mutasi/editDetailMutasi", compact('mProduct','tbMutasi','mLoc','location','sumMutasi'));
   }
   
   public function deleteData($id){
       DB::table('inv_moving_list')
        ->where('idm_list',$id)
        ->delete();
   }
   
   public function editTable(Request $reqTable){
       $tableName = $reqTable->tablename;
       $coloumn = $reqTable->column;
       $editVal = $reqTable->editval;
       $id = $reqTable->id;
       $colId = $reqTable->colId;
       
       DB::table($tableName)
        ->where($colId,$id)
        ->update([
            $coloumn => $editVal
            ]);
   }

    public function deleteMutasi($noDok){
        DB::table('inv_moving')
            ->where('number',$noDok)
            ->update([
                'status'=>'0'
            ]);

        DB::table('inv_moving_list')
            ->where('mutasi_code',$noDok)
            ->update([
                'status'=>'0'
            ]);
    }
}
