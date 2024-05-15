<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockListController extends Controller
{
    public function getMenu () {
        $mastermenu = DB::table('m_submenu')
            ->where([
                'status'=>'1',
                'group_menu'=>'1',
                ])
            ->orderBy('ordering','asc')
            ->get();  

        $transactionmenu = DB::table('m_submenu')
            ->where([
                'status'=>'1',
                'group_menu'=>'2',
                ])
            ->orderBy('ordering','asc')
            ->get();           

        return view ('Stock/MasterData/main', compact('mastermenu','transactionmenu'));
    }

    public function stockList (){
        return view ('Stock/MasterData/stockIndex');
    }

    public function AddProduct(){
        $catProduct = DB::table('m_asset_category')
            ->where('category_status',1)
            ->get();
        $unit = DB::table('m_unit')
            ->orderBy('unit_note','ASC')
            ->get();
        $manufacture = DB::table('m_asset_manufacture')
            ->where('manufacture_status','1')
            ->get();
        $product = DB::table('m_product')
            ->get();

        $nextID = DB::table('m_product')
            ->select('idm_data_product')
            ->orderBy('idm_data_product','DESC')
            ->first();

        $nextIdSatuan = DB::table('m_product_unit')
            ->select('idm_product_satuan')
            ->orderBy('idm_product_satuan','DESC')
            ->first();

        return view ('Stock/MasterData/stockFormNew', compact('catProduct', 'unit','manufacture','product','nextID','nextIdSatuan'));
    }

    public function PostProductSetSizing (Request $reqPostSize){
        $idProduct = $reqPostSize->idProduct;
        $size = $reqPostSize->Size;
        $unit = $reqPostSize->Unit;
        $volume = $reqPostSize->Volume;
        $priceOrder = str_replace(".","",$reqPostSize->PriceOrder);
        $priceSell = str_replace(".","",$reqPostSize->PriceSell);
        $setBarcode = $reqPostSize->SetBarcode;
        
        DB::table('m_product_unit')
            ->insert([
                'core_id_product'=>$idProduct,
                'product_satuan'=>$unit,
                'product_price_order'=>$priceOrder,
                'product_price_sell'=>$priceSell,
                'status'=>'1',
                'created_at'=>now(),
                'set_barcode'=>$setBarcode,
                'product_size'=>$size,
                'product_volume'=>$volume,
            ]);

        return back()->withInput();
    }

    public function listSizePrdInput ($dataIdProd){
        $listSizePrd = DB::table('m_product_unit')
            ->where('core_id_product',$dataIdProd)
            ->orderBy('idm_product_satuan','ASC')
            ->get();

        return view ('Stock/MasterData/stockFormNewSizeListPrd', compact('dataIdProd','listSizePrd'));
    }

    public function PostProduct(Request $reqProd){
        $prodCode = strtoupper($reqProd->ProductCode);
        $prodName = strtoupper($reqProd->ProductName);
        $prodCategory = $reqProd->KatProduk;
        $brand = $reqProd->brand;
        $productImage = $reqProd->productImage;        
        $NameDoc = "";
        $TypeDoc = "";

        $productCheck = DB::table('m_product')
            ->where('product_code',$prodCode)
            ->orWhere('product_name',$prodName)
            ->count();

            
        $statement = DB::table('m_product')
            ->select('idm_data_product')
            ->orderBy('idm_data_product','desc')
            ->first();

        $nextIdProd = $statement->idm_data_product;

        if ($prodCode=="" OR $prodName=="" OR $prodCategory=="0") {
            $msg = array('warning' => '! FIELD YANG BERTANDA BINTANG WAJIB DI ISI (*).');        
        }
        elseif ($productCheck >= 1) {
            $msg = array('warning' => '! CODE ATAU NAMA PRODUKSI YANG DIMASUKKAN SUDAH ADA.');
        }
        else{
            if ($productImage <> "") {
                $TypeDoc = $productImage->getClientOriginalExtension();
                $NameDoc = $productImage->getClientOriginalName(); 
                $dirPublic = public_path() . "/images/Upload/Product/";
                $dirImage = $dirPublic . $nextIdProd . "/";

                if (!file_exists($dirImage)) {
                    mkdir($dirImage, 0777);
                    $productImage->move($dirImage, $NameDoc);
                }
                else{
                    $productImage->move($dirImage, $NameDoc);
                }
            }
            DB::table('m_product')
                ->insert([
                    'product_code'=>$prodCode,
                    'product_name'=>$prodName,
                    'brand'=>$brand,
                    'file_name'=>$NameDoc,
                    'file_type'=>$TypeDoc,
                    'product_category'=>$prodCategory,
                ]);   
            $msg = array('success' => '✔ DATA BERHASIL DIMASUKKAN.');
        }
        return response()->json($msg);
    }

    public function ProductMaintenance(){
        return view ('Stock/MasterData/productMaintenance');
    }

    public function ProductSearch($keyword){
        $productList = DB::table('product_list_view');
            if ($keyword <> 0) {
                $productList = $productList->where('product_name','LIKE','%'.$keyword.'%');
            }
            $productList = $productList->paginate(5);

        $prodUnit = DB::table('m_product_unit')
            ->where('status','1')
            ->get();

        return view ('Stock/MasterData/productList', compact('productList','keyword','prodUnit'));
    }

    public function PriceEdit ($id){
        $mProdUnit = DB::table('m_product_unit')
            ->where('core_id_product',$id)
            ->get();

        return view ('Stock/MasterData/productModalFormPrice', compact('mProdUnit'));
    }

    public function PostNewProductPrice(Request $reqNewPrice){
        $HppLg = $reqNewPrice->priceLg;
        $HppMd = $reqNewPrice->priceMd;
        $HppSm = $reqNewPrice->priceSm;
        $SellLg = $reqNewPrice->sellPriceLg;
        $SellMd = $reqNewPrice->sellPriceMd;
        $SellSm = $reqNewPrice->sellPriceSm;
        $productId = $reqNewPrice->productID;
        $userLog = $reqNewPrice->userName;

        DB::table('m_product_price')
            ->insert([
                'core_product_id'=>$productId,
                'product_price_lg'=>$HppLg,
                'product_price_md'=>$HppMd,
                'product_price_sm'=>$HppSm,
                'price_status'=>'1',
            ]);
        
        DB::table('m_product_price_sell')
            ->insert([
                'core_product'=>$productId,
                'product_sell_lg'=>$SellLg,
                'product_sell_md'=>$SellMd,
                'product_sell_sm'=>$SellSm,
                'price_sell_status'=>'1',
            ]);

        DB::table('log_edit_table')
            ->insert([
                'user'=>$userLog,
                'edit_table_code'=>"Price HPP & Price Sell",
                'action'=>"New Data",
                'created_date'=>now(),
                'description'=>"Menambahkan harga produk pembelian dan harga penjualan."
            ]);
        $msg = array('success' => '✔ SUCCESS DATA BERHASIL DIMASUKKAN.');
        return response()->json($msg);
    }

    public function PostEditProductPrice (Request $reqPostEditPrice){
        $tableName = $reqPostEditPrice->tableName;
        $column = $reqPostEditPrice->column;
        $editVal = str_replace(".","",$reqPostEditPrice->editVal);
        $id = $reqPostEditPrice->id;
        $priceId = $reqPostEditPrice->priceId;

        DB::table($tableName)
            ->where($priceId,$id)
            ->update([
                $column => $editVal,
            ]);
        return back();
    }

    public function ProductInventory($id){
        $dataproduct = DB::table('m_product')
            ->select('product_name','sku','stock','minimum_stock')
            ->where('idm_data_product',$id)
            ->first();

        return view ('Stock/MasterData/productModalFormInventory', compact('id','dataproduct'));
    }

    public function PostInventory (Request $reqPostInv){
        $sku = $reqPostInv->sku;
        $qty = $reqPostInv->StockQty;
        $minimumStock = $reqPostInv->MinimumStock;
        $productID = $reqPostInv->productID;
        $userLog = $reqPostInv->userName;
        $productName = $reqPostInv->productName;

        DB::table('m_product')
            ->where('idm_data_product',$productID)
            ->update([
                'sku'=>$sku,
                'stock'=>$qty,
                'minimum_stock'=>$minimumStock,
            ]);

        DB::table('log_edit_table')
            ->insert([
                'user'=>$userLog,
                'edit_table_code'=>"Update Inventory : ".$productName,
                'action'=>"Update Data",
                'description'=>"Melakukan update SKU pada inventory product ".$productName,
                'created_date'=>now()
            ]);

        $msg = array('success' => '✔ SUCCESS DATA BERHASIL DIUPDATE.');
        return response()->json($msg);  
    }
}
