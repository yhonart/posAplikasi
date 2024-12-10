<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReturnItemController extends Controller
{
    protected $tempInv;
    protected $tempUser;
    
    public function __construct(TempInventoryController $tempInv, TempUsersController $tempUser)
    {
        $this->TempInventoryController = $tempInv;
        $this->TempUsersController = $tempUser;
    }
    
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
    
    public function mainReturn(){
        $checkArea = $this->checkuserInfo();
        $approval = $this->userApproval();
        return view ('ReturnItem/main', compact('checkArea','approval'));
    }
    
    public function displayPurchase(){
        return view ('ReturnItem/displayPurchase');
    }
    
    public function searchData($keyword){
        $row = ['purchase_number','store_name'];
        $tbPurchase = DB::table('view_purchase_order');
        if($keyword <> '0'){
            $tbPurchase=$tbPurchase->where(function ($query) use($keyword,$row) {
                if ($keyword<>'0') {
                    for ($i = 0; $i < count($row); $i++){
                        $query->orwhere($row[$i], 'like',  '%' . $keyword .'%');
                    }
                }
            });
        }
        $tbPurchase = $tbPurchase->where('status','>=','3');
        $tbPurchase = $tbPurchase->orderBy('id_purchase','desc');
        $tbPurchase = $tbPurchase->get();
            
        return view ('ReturnItem/displayPurchaseSearchList', compact('tbPurchase'));
    }
    
    public function displayItemList ($numberpo){
        
        $itemList = DB::table('view_purchase_lo as a')
            ->where('a.purchase_number',$numberpo)
            ->orderBy('a.product_name','asc')
            ->get();
            
        $unitList = DB::table('m_product_unit')
            ->select('product_satuan','product_size','size_code', 'core_id_product')
            ->get();
            
        return view ('ReturnItem/displayPurchaseItemList', compact('itemList', 'numberpo','unitList'));
    }
    
    public function satuanAction ($satuan, $prdID, $idLo){
        $wh = DB::table('purchase_list_order')
            ->select('warehouse')
            ->where('id_lo',$idLo)
            ->first();
        $warehouse = $wh->warehouse;
        
        $mUnit = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$prdID],
                ['product_size',$satuan],
                ['location_id',$warehouse]
                ])
            ->first();
            
        return response()->json([
            'price' => $mUnit->product_price_order,
            'stock' => $mUnit->stock,
            'unit' => $mUnit->product_satuan,
        ]);
        return response()->json(['error' => 'Product not found'], 404);
    }
    
    public function prodListAction ($prdID, $numberPO){
        $trxPmbl = DB::table('purchase_list_order')
            ->where([
                ['product_id',$prdID],
                ['purchase_number',$numberPO]
                ])
            ->first();
            
        return response()->json([
            'qtyPB' => $trxPmbl->qty,
            'unitPB' => $trxPmbl->satuan,
            'dataId' => $trxPmbl->id_lo
        ]);
        return response()->json(['error' => 'Product not found'], 404);
    }
    
    public function displayReturnItem($purchCode){    
        $dspReturn = DB::table('purchase_return as a')
            ->select('a.*','b.product_name')
            ->leftJoin('m_product as b', 'a.product_id','=','b.idm_data_product')
            ->where('purchase_number',$purchCode)
            ->get();
            
        return view ('ReturnItem/displayPurchaseItemReturn', compact('dspReturn','purchCode'));
    }
    
    public function postItemReturn(Request $reqReturn){
        $id = $reqReturn->id;
        $purchaseNumber = $reqReturn->purchaseNumber;
        $recive = $reqReturn->recive;
        $qtyReturn = $reqReturn->qtyRetur;
        $hrgSatuan = str_replace(".","",$reqReturn->hargaSatuan);
        $jumlahHrg = str_replace(".","",$reqReturn->point);
        $prdId = $reqReturn->product;
        $satuan = $reqReturn->satuan;
        $qtyPbl = $reqReturn->qtyPbl;
        $unit = $reqReturn->unit;
        $stockAwal = $reqReturn->stock;
        $stockAkhir = $reqReturn->saldo;
        $userName = Auth::user()->name;
        
        DB::table('purchase_return')
            ->insert([
                'purchase_number'=>$purchaseNumber,
                'list_order_id'=>$id,
                'product_id'=>$prdId,
                'satuan'=>$satuan,
                'unit'=>$unit,
                'received'=>$qtyPbl,
                'return'=>$qtyReturn,
                'unit_price'=>$hrgSatuan,
                'total_price'=>$jumlahHrg,
                'stock_awal'=>$stockAwal,
                'stock_akhir'=>$stockAkhir,
                'created_by'=>$userName,
                'status'=>'1'
            ]);
        
        // Updating stock
        
        $listLO = DB::table('purchase_list_order')
            ->where('id_lo',$id)
            ->first();
            
        $productID = $listLO->product_id;
        $location = $listLO->warehouse;
        $qty = $qtyReturn;
        $prodSatuan = $listLO->size;
        $purchNumber = $listLO->purchase_number;
        
        $docPurchase = DB::table("purchase_order")
            ->where('purchase_number',$purchNumber)
            ->first();
            
        $nomReturn = $hrgSatuan * $qtyReturn;  
        DB::table('purchase_point')
            ->insert([
                'purchase_number'=>$purchNumber,
                'supplier_id'=>$docPurchase->supplier_id,
                'nom_return'=>$jumlahHrg,
                'status'=>'1'
                ]);
        
        $mUnit = DB::table('m_product_unit')
            ->where('core_id_product',$listLO->product_id)
            ->get();
        
         
        $updateInv = $this->TempInventoryController->stockControl($productID, $location, $stockAkhir, $satuan); 
        
        // foreach($mUnit as $pl){
        //     //UPDATE STOCK;
        //     $dataStock = DB::table('view_product_stock')
        //     ->where([
        //         ['idm_data_product',$productID],
        //         ['location_id',$location]
        //     ])
        //     ->get();
            
        //     echo $productID."/".$location;
        //     // Cek volume by kode size 2
        //     $codeSatu = DB::table('view_product_stock')
        //     ->where([
        //         ['idm_data_product',$productID],
        //         ['location_id',$location],
        //         ['size_code','1'],
        //     ])
        //     ->first();
            
        //     // Cek volume by kode size 2
        //     $codeDua = DB::table('view_product_stock')
        //     ->where([
        //         ['idm_data_product',$productID],
        //         ['location_id',$location],
        //         ['size_code','2'],
        //     ])
        //     ->first();
            
        //     $codeTiga = DB::table('view_product_stock')
        //     ->where([
        //         ['idm_data_product',$productID],
        //         ['location_id',$location],
        //         ['size_code','3'],
        //     ])
        //     ->first();
        //     if(!empty($codeTiga)){
        //         $volTiga = $codeTiga->product_volume;
        //         $stokTiga = $codeTiga->stock;
        //     }
        //     else{
        //         $volTiga = $codeSatu->product_volume;
        //         $stokTiga = $codeSatu->stock;
        //     }
            
        //     if(!empty($codeDua)){
        //         $volDua = $codeDua->product_volume;
        //         $stokDua = $codeDua->stock;
        //     }
        //     else{
        //         $volDua = $volTiga;
        //         $stokDua = $stokTiga;
        //     }
            
        //     foreach($dataStock as $ds){
        //         if($prodSatuan == "BESAR"){ // Jika yang dimasukkan adalah satuan Besar
        //             if($ds->size_code == '1'){ // Jika kode dalam list 1
        //                 $a = $ds->stock - $qty;
        //             }
        //             elseif($ds->size_code == '2'){
        //                 $a1 = $ds->product_volume * $qty; //contoh 1 x 10 = 10
        //                 $a = $ds->stock - $a1;
        //             }
        //             elseif($ds->size_code == '3'){
        //                 $a1 = $ds->product_volume * $qty;
        //                 $a = $ds->stock - $a1;
        //             }
        //         }
        //         elseif($prodSatuan == "KECIL"){ // Jika yang idmasukkan adalah satuan kecil
        //             if($ds->size_code == '1'){ // Jika kode dalam list 1
        //                 $a1 = $stokDua - $qty;
        //                 $a2 = $a1/$ds->product_volume;
        //                 $a = (int)$a2;
        //             }
        //             elseif($ds->size_code == '2'){
        //                 $a1 = $ds->stock - $qty;
        //                 $a = (int)$a1;
        //             }
        //             elseif($ds->size_code == '3'){
        //                 $a1 = $volDua * $qty;
        //                 $a2 = $ds->stock-$a1;
        //                 $a = (int)$a2;
        //             }
        //         }
        //         elseif($prodSatuan == "KONV"){
        //             $ab = $stokTiga - $qty;
                    
        //             if($ds->size_code == '1'){ // Jika kode dalam list 1
        //                 $a1 = $ab / $volTiga;
        //                 $a = (int)$a1;
        //             }
        //             elseif($ds->size_code == '2'){
        //                 $a1 = $ab / $volDua;
        //                 $a = (int)$a1;
        //             }
        //             elseif($ds->size_code == '3'){
        //                 $a = $ds->stock-$qty;
        //             }
        //         }
        //         if($a < '0'){
        //             $a = '0';
        //         }
        //         DB::table('inv_stock')
        //         ->where('idinv_stock',$ds->idinv_stock)
        //         ->update([
        //             'stock'=>$a,    
        //             'saldo'=>$a    
        //         ]);
        //     }
        // }
        return back();
    }
}
