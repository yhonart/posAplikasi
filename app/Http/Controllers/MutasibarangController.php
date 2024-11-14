<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;


class MutasibarangController extends Controller
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
    
    public function numberMutasi(){
        $thisPeriode = date('my');
        
        $countPeriode = DB::table('inv_moving')
            ->where('periode',$thisPeriode)
            ->count();
            
        if($countPeriode=='0'){
            $pag = '1';
            $nopag = "PAG-".$thisPeriode."-".sprintf("%07d",$pag);
        }
        else{
            
            //cek deleted number
            $deletedNumber = DB::table('inv_moving')
                ->where('status','0')
                ->first();
                
            if(empty($deletedNumber)){
                $pag = $countPeriode+1;
                $nopag = "PAG-".$thisPeriode."-".sprintf("%07d",$pag);
            }
            else{
                $nopag = $deletedNumber->number_so;
            }
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

        $tableMoving = DB::table('inv_moving');
        $tableMoving=$tableMoving->where('status',$status);
        if ($fromDate<>'0' OR $endDate<>'0') {
            $tableMoving=$tableMoving->whereBetween('date_moving',['$fromDate','$endDate']);
        }
        $tableMoving=$tableMoving->orderBy('idinv_moving','desc');
        $tableMoving=$tableMoving->limit(100);
        $tableMoving=$tableMoving->get();

        return view('Mutasi/tableDokMutasi',compact('tableMoving','approval','userArea'));
    }
    public function formEntryMutasi(){
        $number = $this->numberMutasi();
        $userID = Auth::user()->name;

        $mLoc = DB::table('m_site')
            ->get();

        $counInvMoving = DB::table('inv_moving')
            ->where([
                ['status','1'],
                ['created_by',$userID] 
                ])
            ->count();

        echo $counInvMoving;
            
        return view('Mutasi/formInputMutasi',compact('mLoc','number','counInvMoving'));
    }
    
    public function submitMutasi(Request $reqPostMutasi){
        $number = $reqPostMutasi->number;
        $tglMutasi = $reqPostMutasi->tglMutasi;
        $fromLoc = $reqPostMutasi->fromLoc;
        $toLoc = $reqPostMutasi->toLoc;
        $description = $reqPostMutasi->description;
        $userID = Auth::user()->name;
        $thisPeriode = date('my');
        
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
            ]);
    }
    
    public function getTableInputProduct (){
        $countActive = $this->countNumberActive();
        $number = $this->showNumberActive();
        $location = '0';

        $mProduct = DB::table('m_product')
            ->orderBy('product_name','asc')
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
    
    public function entryStock($satuanVal, $productVal, $warehouse){
        $lastStock = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productVal],
                ['product_size',$satuanVal],
                ['site_name',$warehouse],
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
        
        DB::table('inv_moving_list')
            ->insert([
                'mutasi_code'=>$numberMutasi,   
                'inv_id'=>$invID,   
                'product_id'=>$mProduct,   
                'satuan'=>$satuan,   
                'last_stock'=>$lastStock,   
                'stock_taken'=>$qty,   
                'notes'=>$keterangan,   
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
        $tbMutasi = DB::table('inv_moving')
            ->where('number',$idParam)
            ->first();
        $locationID = $tbMutasi->from_loc;
        $listMutasi = DB::table('inv_moving_list as a')
            ->select('a.*','b.product_name','b.product_satuan')
            ->leftJoin('view_product_stock as b', function($join){
                $join->on('a.inv_id','=','b.idinv_stock');
            })
            ->where([
                ['a.mutasi_code',$idParam],
                ['b.site_name',$locationID]
                ])
            ->get();
        $userArea = $this->checkuserInfo();
        $mlocDetail = DB::table('m_site')
            ->where('idm_site',$userArea)
            ->first();
            
        return view('Mutasi/detailTableMutasi',compact('tbMutasi','listMutasi','idParam','mlocDetail'));
    }
    
    public function editDocMutasi ($idParam){
        // echo $idParam;
        
        $tbMutasi = DB::table('inv_moving')
            ->where('number',$idParam)
            ->first();
        
        $mLoc = DB::table('m_site')
            ->get();
            
        return view('Mutasi/editDocMutasi',compact('tbMutasi','mLoc'));
    }
    
    public function satuan($productId){
        $createdBy = Auth::user()->name;
        $location = DB::table('inv_moving')
            ->where([
                ['created_by',$createdBy],
                ['status','1']
            ])
            ->first();
            
        $productSatuan = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$productId],
                ['site_name',$location->from_loc]
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
        $listProduk = DB::table('inv_moving_list')
            ->where('mutasi_code',$idParam)
            ->get();
            
        $docMutasi = DB::table('inv_moving')
            ->where('number',$idParam)
            ->first();
            
        $toLocation = $docMutasi->to_loc;
        $fromLocation = $docMutasi->from_loc;
        
        $mToLoc = DB::table('m_site')
            ->where('site_name',$toLocation)
            ->first();
            
        $mFromLoc = DB::table('m_site')
            ->where('site_name',$fromLocation)
            ->first();
            
        $toLoc = $mToLoc->idm_site;
        $fromLoc = $mFromLoc->idm_site;
        
        foreach($listProduk as $lp){
            $productID = $lp->product_id;
            $satuan = $lp->satuan;
            $lastStock = $lp->last_stock;
            $takenStock = $lp->stock_taken;
            $penguranganStock = $lastStock - $takenStock;
            
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
        $mProduct = DB::table('m_product')
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
}
