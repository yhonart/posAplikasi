<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReturnItemController extends Controller
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

    public function productAction ($prdID){
        $satuanItem = DB::table('product_list_view')            
            ->where('core_id_product',$prdID)
            ->get();
            
        return view ('ReturnItem/displaySelectSatuan', compact('satuanItem'));
    }
    
    public function satuanAction ($satuan, $prdID, $idLo){
        $wh = DB::table('view_purchase_lo')
            ->select('warehouse','unit_price')
            ->where('id_lo',$idLo)
            ->first();

        $warehouse = $wh->warehouse;
        $unitPrice = $wh->unit_price;

        // Cek unit volume
        $unitVolume = DB::table('m_product_unit')
            ->select('product_size','size_code')
            ->where('core_id_product',$prdID)
            ->get();
            
        $mUnit = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$prdID],
                ['product_size',$satuan],
                ['location_id',$warehouse]
                ])
            ->first();

        foreach ($unitVolume as $key) {
            $prdSize = $key->product_size;
            $sizeCode = $key->size_code;

            if ($prdSize == $satuan) {
                $price = $mUnit->product_price_order;
            }
            else {
                $mProduct = DB::table('m_product')
                    ->where('idm_data_product',$prdID)
                    ->first();

                $besar = $mProduct->large_unit_val;
                $kecil = $mProduct->medium_unit_val;
                if ($kecil == 0) {
                    $konv = $besar;
                }
                else {
                    $konv = (int)$besar*(int)$kecil;
                }                              
            }
        }
            
        return response()->json([
            'price' => $mUnit->product_price_order,
            'stock' => $mUnit->stock,
            'unit' => $mUnit->product_satuan,
        ]);
        return response()->json(['error' => 'Product not found'], 404);
    }
    
    public function prodListAction ($prdID, $numberPO){
        $trxPmbl = DB::table('view_purchase_lo')
            ->where([
                ['product_id',$prdID],
                ['purchase_number',$numberPO]
                ])
            ->first();

        $satuan = $trxPmbl->size;
        $warehouse = $trxPmbl->warehouse;

        $mUnit = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$prdID],
                ['product_size',$satuan],
                ['location_id',$warehouse]
                ])
            ->first();
           
        return response()->json([
            'qtyPB' => $trxPmbl->qty,
            'unitPB' => $trxPmbl->satuan,
            'dataId' => $trxPmbl->id_lo,
            'price' => $trxPmbl->unit_price,
            'warehouse' => $trxPmbl->site_name,            
            'stock' => $mUnit->stock,
            'unit' => $mUnit->product_satuan,
        ]);
        return response()->json(['error' => 'Product not found'], 404);
    }
    
    public function displayReturnItem($purchCode){    
        $dspReturn = DB::table('purchase_return as a')
            ->select('a.*','b.product_name')
            ->leftJoin('m_product as b', 'a.product_id','=','b.idm_data_product')            
            ->where([
                ['purchase_number',$purchCode],
                ['status','>=','1']
                ])
            ->get();
            
        return view ('ReturnItem/displayPurchaseItemReturn', compact('dspReturn','purchCode'));
    }

    public function deleteItem ($id){
        $selectProduk = DB::table('purchase_return as a')
            ->select('a.*','b.warehouse')
            ->leftJoin('purchase_list_order as b','a.list_order_id','=','b.id_lo')
            ->where('a.id_return',$id)
            ->first();

        $productID = $selectProduk->product_id;
        $location = $selectProduk->warehouse;
        $stockAkhir = $selectProduk->stock_akhir;
        $satuan = $selectProduk->satuan;

        $this->TempInventoryController->stockControl($productID, $location, $stockAkhir, $satuan); 

        DB::table('purchase_return')
            ->where('id_return',$id)
            ->update([
                'status'=>'0'
            ]);

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

        $supplierId = $docPurchase->supplier_id;

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
                'status'=>'1',
                'supplier_id'=>$supplierId,
            ]);
            
        $nomReturn = $hrgSatuan * $qtyReturn;  

        //Hitung Konversi 
        $mProduct = DB::table('m_product')
            ->where('idm_data_product',$listLO->product_id)
            ->first();

        $volB = $mProduct->large_unit_val;
        $volK = $mProduct->medium_unit_val;
        $volKonv = $mProduct->small_unit_val;

        $mUnit = DB::table('m_product_unit')
            ->select('size_code','product_volume')
            ->where('core_id_product',$listLO->product_id)
            ->orderBy('size_code','desc')
            ->first();   
        $sizeCodeDesc = $mUnit->size_code;
        if ($sizeCodeDesc == '1') {
            $qtyReport = $qty;
        }
        elseif ($sizeCodeDesc == '2') {
            if ($satuan == "BESAR") {
                $qtyReport1 = $qty * $volB;
                $qtyReport = (int)$qtyReport1;
            }
            elseif ($satuan == "KECIL") {
                $qtyReport = $qty;
            }
        }
        elseif ($sizeCodeDesc == '3') {
            if ($satuan == "BESAR") {
                $qtyReport1 = $qty * $volKonv;
                $qtyReport = (int)$qtyReport1;
            }
            elseif ($satuan == "KECIL") {
                $qtyReport1 = $qty * $volK;
                $qtyReport = (int)$qtyReport1;
            }
            elseif ($satuan == "KONV") {
                $qtyReport = $qty;
            }
        }   
        DB::table('purchase_point')
            ->insert([
                'purchase_number'=>$purchNumber,
                'supplier_id'=>$docPurchase->supplier_id,
                'nom_return'=>$jumlahHrg,
                'status'=>'1',
                'total_item'=>$qtyReport,
                'product_id'=>$listLO->product_id
            ]);         
        $this->TempInventoryController->stockControl($productID, $location, $stockAkhir, $satuan); 
        return back();
    }

    public function detailHistory ($purchNumber){
        $purchaseOrder = DB::table('view_purchase_order')
            ->where('purchase_number',$purchNumber)
            ->first();

        $purchaseListOrder = DB::table('view_purchase_lo')
            ->where('purchase_number',$purchNumber)
            ->get();

        $purchaseReturn = DB::table('purchase_return as a')
            ->select('a.*','b.product_name')
            ->leftJoin('m_product as b','a.product_id','=','b.idm_data_product')
            ->get();

        return view ('ReturnItem/displayPurchaseDetailReturn', compact('purchNumber','purchaseOrder','purchaseListOrder','purchaseReturn'));
    }

    public function detailItem ($purchCode){
        $viewPurchaseOrder = DB::table('view_purchase_lo')
            ->where('purchase_number',$purchCode)
            ->get();

        return view ('ReturnItem/displayPurchaseDetailItem', compact('viewPurchaseOrder','purchCode'));
    }

    public function returnHistory (){
        $historyReturn = DB::table('purchase_return as a')
            ->select(DB::raw('SUM(a.total_price) as price'),'a.purchase_number','b.store_name')
            ->leftJoin('m_supplier as b', 'a.supplier_id','=','b.idm_supplier')
            ->groupBy('a.purchase_number')
            ->groupBy('b.store_name')
            ->get();

        return view ('ReturnItem/displayPurchaseReturnHistory', compact('historyReturn'));
    }

    public function returnNonInv (){
        return view ('ReturnItem/displayReturnNonInv');
    }

    public function submitRetur ($poNumber){
        DB::table('purchase_return')
            ->where([
                ['purchase_number',$poNumber],
                ['status','1']
            ])
            ->update([
                'status'=>'2'
            ]);

        DB::table('purchase_point')
            ->where([
                ['purchase_number',$poNumber],
                ['status','1']
            ])
            ->update([
                'status'=>'2'
            ]);
    }
}