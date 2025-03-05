<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockListController extends Controller
{
    protected $tempInv;
    protected $tempUser;    
    protected $TempUsersController;
    protected $TempInventoryController;

    public function __construct(TempInventoryController $tempInv, TempUsersController $tempUser)
    {
        $this->TempUsersController = $tempUser;
        $this->TempInventoryController = $tempInv;
    }

    public function countAccessDok (){
        $userID = Auth::user()->id;

        $countUserComp = DB::table('view_user_comp_loc')
            ->where('id',$userID)
            ->count();

        return $countUserComp;
    }
    
    public function getProductCode (){
        $countUserCompany = $this->countAccessDok();
        $authUserCompany = Auth::user()->company;
        $authUserID = Auth::user()->id;

        if ($countUserCompany == '0') {
            $codeComp = "PID";
        }
        else {
            $codeCompany = DB::table('view_user_comp_loc')
                ->select('company_code')
                ->where('id',$authUserID)
                ->first();
            $codeComp = $codeCompany->company_code;
        }

        $countPrdID = DB::table('m_product')
            ->where('comp_id',$authUserCompany)
            ->count();

        $no = (int)$countPrdID + 1;

        // $id=DB::select("SHOW TABLE STATUS LIKE 'm_product'");
        //     $no=$id[0]->Auto_increment;
        
        $productCode = "BR".$codeComp."-".sprintf("%05d",$no);  
        return $productCode;
    }
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
            
        $dashboardMenu = DB::table('m_submenu')
            ->where([
                'status'=>'1',
                'group_menu'=>'3',
                ])
            ->orderBy('ordering','asc')
            ->get();           

        return view ('Stock/MasterData/main', compact('mastermenu','transactionmenu','dashboardMenu'));
    }

    public function stockList (){
        return view ('Stock/MasterData/stockIndex');
    }

    public function AddProduct(){
        $productCode = $this->getProductCode();
        
        $catProduct = DB::table('m_asset_category')
            ->where('category_status',1)
            ->get();
        $unit = DB::table('m_unit')
            ->orderBy('unit_note','ASC')
            ->get();
        $manufacture = DB::table('m_asset_manufacture')
            ->where('manufacture_status','1')
            ->orderBy('manufacture_name','asc')
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

        $listGroup = DB::table('m_cos_group')
            ->where('group_status','1')
            ->get();
            
        $id=DB::select("SHOW TABLE STATUS LIKE 'm_product'");
            $next_id=$id[0]->Auto_increment;

        return view ('Stock/MasterData/stockFormNew', compact('catProduct', 'unit','manufacture','product','nextID','nextIdSatuan','listGroup','productCode','next_id'));
    }

    public function PostProductSetSizing (Request $reqPostSize){
        $idProduct = $reqPostSize->idProduct;
        $size = $reqPostSize->Size;
        $unit = $reqPostSize->Unit;
        $volume = $reqPostSize->Volume;
        $priceOrder = str_replace(".","",$reqPostSize->PriceOrder);
        $setBarcode = $reqPostSize->SetBarcode;
        
        DB::table('m_product_unit')
            ->insert([
                'core_id_product'=>$idProduct,
                'product_satuan'=>$unit,
                'product_price_order'=>$priceOrder,
                'status'=>'1',
                'created_at'=>now(),
                'set_barcode'=>$setBarcode,
                'product_size'=>$size,
                'product_volume'=>$volume,
            ]);

        return back()->withInput();
    }

    public function PostProductSetGrouping (Request $reqPriceGrouping){
        $productID = $reqPriceGrouping->routeID;
        $size = $reqPriceGrouping->unitHarga;
        $cosGroup = $reqPriceGrouping->cosGroup;
        $priceOrder = str_replace(".","",$reqPriceGrouping->priceOrder);
        $priceSell = str_replace(".","",$reqPriceGrouping->priceSell);
        
        //cek data di dalam produk jual
        $countTbSell = DB::table('m_product_price_sell')
            ->where([
                ['core_product_price',$productID],
                ['size_product',$size],
                ['cos_group',$cosGroup]
                ])
            ->count();
            
        $countUnit = DB::table('m_product_unit')
            ->where([
                ['core_id_product',$productID],
                ['product_size',$size]
                ])
            ->count();

        if($countUnit == "0"){
            $msg = array('warning' => 'Pastikan satuan pada pengaturan volume & satuan sudah dimasukkan!');
        }
        elseif($cosGroup == '0'){
            $msg = array('warning' => 'Anda belum memasukkan tipe pelanggan!');
        }
        else{
            if($countTbSell == '0'){ //input data jika didalam produk jual kosong
                DB::table('m_product_price_sell')
                    ->insert([
                        'core_product_price'=>$productID,
                        'size_product'=>$size,
                        'cos_group'=>$cosGroup,
                        'price_sell'=>$priceSell,
                        'price_sell_status'=>'1'
                    ]);
                    
                $getCusGroup = DB::table('m_cos_group')
                    ->where('idm_cos_group','!=',$cosGroup)
                    ->get();
                    
                foreach($getCusGroup as $gcg){
                    DB::table('m_product_price_sell')
                    ->insert([
                        'core_product_price'=>$productID,
                        'size_product'=>$size,
                        'cos_group'=>$gcg->idm_cos_group,
                        'price_sell'=>'0',
                        'price_sell_status'=>'1'
                    ]);
                }
                
                DB::table('m_product_unit')
                    ->where([
                        ['core_id_product',$productID],
                        ['product_size',$size]
                    ])
                    ->update([
                        'product_price_order'=>$priceOrder    
                    ]);
            }
            $msg = array('success' => 'Sukses!');
        }
            
        return response()->json($msg);
    }

    public function prodCategoryInput($idPrd){
        $mGroupCus = DB::table('m_cos_group')
            ->get();
            
        $mPrdUnit = DB::table('m_product_unit')
            ->where('core_id_product',$idPrd)
            ->get();
            
        $groupProdList = DB::table('m_product_price_sell')
            ->where('core_product_price',$idPrd)
            ->get();
            
            
        $listSizeGroup = DB::table('m_size')
            ->get();

        return view ('Stock/MasterData/stockFormNewGroupListPrd', compact('idPrd','groupProdList','listSizeGroup','mGroupCus','mPrdUnit'));    
    }

    public function listSizePrdInput ($idPrd){
        // echo $idPrd;
        $listSizePrd = DB::table('m_product_unit')
            ->where('core_id_product',$idPrd)
            ->orderBy('size_code','ASC')
            ->get();
        
        $listUnit = DB::table('m_unit')
            ->get();
            
        $listSize = DB::table('m_size')
            ->get();

        return view ('Stock/MasterData/stockFormNewSizeListPrd', compact('idPrd','listSizePrd','listUnit','listSize'));
    }
    
    public function cencelSubmit($idPrd){
        DB::table('m_product_unit')
            ->where('core_id_product',$idPrd)
            ->delete();
            
        DB::table('m_product_price_sell')
            ->where('core_product_price',$idPrd)
            ->delete();
            
        return back();
    }
    
    public function deleteProductPermanent($idPrd){
        $prdUnit = DB::table('m_product_unit')
            ->where('core_id_product',$idPrd)
            ->get();
            
        foreach($prdUnit as $p){
            $satuanID = $p->idm_product_satuan;
            DB::table('inv_stock')
                ->where('product_id',$satuanID)
                ->delete();
        }
        
        DB::table('m_product')
            ->where('idm_data_product',$idPrd)
            ->delete();
            
        DB::table('m_product_unit')
            ->where('core_id_product',$idPrd)
            ->delete();
            
        DB::table('m_product_price_sell')
            ->where('core_product_price',$idPrd)
            ->delete();
            
        return back();
    }
    public function PostProduct(Request $reqProd){
        $authUserComp = Auth::user()->company;
        $prodCode = strtoupper($reqProd->ProductCode);
        $prodName = strtoupper($reqProd->ProductName);
        $prodCategory = $reqProd->KatProduk;
        $brand = $reqProd->brand;
        $productImage = $reqProd->productImage; 
        $nextID = $reqProd->PrdNextID;
        $NameDoc = "";
        $TypeDoc = "";

        $productCheck = DB::table('m_product')
            ->where('product_code',$prodCode)
            ->orWhere('product_name',$prodName)
            ->count();

        $id=DB::select("SHOW TABLE STATUS LIKE 'm_product'");
            $nextIdProd=$id[0]->Auto_increment;

        // $statement = DB::table('m_product')
        //     ->select('idm_data_product')
        //     ->orderBy('idm_data_product','desc')
        //     ->first();
        
        // $nextIdProd = $statement->idm_data_product;

        if ($prodName=="" OR $prodCategory=="0") {
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

            $valBesar = DB::table('m_product_unit')
                ->select('product_volume')
                ->where([
                    ['core_id_product',$nextID],
                    ['size_code','1']

                ])
                ->first();

            $valKecil = DB::table('m_product_unit')
                ->select('product_volume')
                ->where([
                    ['core_id_product',$nextID],
                    ['size_code','2']

                ])
                ->first();

            $valKonv = DB::table('m_product_unit')
                ->select('product_volume')
                ->where([
                    ['core_id_product',$nextID],
                    ['size_code','3']
                ])
                ->first();
            
            $volBesar = $valBesar->product_volume;

            if (!empty($valKecil)) {
                $volKecil = $valKecil->product_volume;
            }
            else {
                $volKecil = '0';
            }

            if (!empty($valKonv)) {
                $volKonv = $valKonv->product_volume;
            }
            else {
                $volKonv = '0';
            }
            
            DB::table('m_product')
                ->insert([
                    'product_code'=>$prodCode,
                    'product_name'=>$prodName,
                    'brand'=>$brand,
                    'file_name'=>$NameDoc,
                    'file_type'=>$TypeDoc,
                    'product_category'=>$prodCategory,
                    'large_unit_val'=>$volBesar,
                    'medium_unit_val'=>$volKecil,
                    'small_unit_val'=>$volKonv,
                    'comp_id'=>$authUserComp
                ]); 
                
            $mUnit = DB::table('m_product_unit')
                ->where('core_id_product',$nextID)
                ->get();
                
            $mLoc = DB::table('m_site')
                ->get();
            
            foreach($mUnit as $sl){
                foreach($mLoc as $mL){
                    DB::table('inv_stock')
                        ->insert([
                            'product_id'=>$sl->idm_product_satuan,
                            'location_id'=>$mL->idm_site,
                            'stock'=>'0',
                            'stock_unit'=>'0',
                            'stock_out'=>'0',
                            'saldo'=>'0',
                            'stock_status'=>'1',
                            ]);
                }
            }
            $msg = array('success' => '✔ DATA BERHASIL DIMASUKKAN.');
        }
        return response()->json($msg);
    }

    public function ProductMaintenance(){
        return view ('Stock/MasterData/productMaintenance');
    }

    public function ProductSearch($keyword){
        $productList = DB::table('m_product');
            if ($keyword <> 0) {
                $productList = $productList->where('product_name','LIKE','%'.$keyword.'%');
            }
            $productList = $productList->paginate(10);

        $prodUnit = DB::table('m_product_unit')
            ->where('status','1')
            ->orderBy('product_name','ASC')
            ->get();

        return view ('Stock/MasterData/productList', compact('productList','keyword','prodUnit'));
    }

    public function PriceEdit ($id){
        $mProduct = DB::table('m_product')
            ->where('idm_data_product',$id)
            ->first();
            
        $mProdUnit = DB::table('m_product_unit')
            ->where('core_id_product',$id)
            ->orderBy('product_size','asc')
            ->get();
            
        $mSize = DB::table('m_size')
            ->get();
        
        $countPrdSell = DB::table('m_product_price_sell')
            ->where('core_product_price',$id)
            ->count();
            
        $mPriceSell = DB::table('m_product_price_sell')
            ->where('core_product_price',$id)
            ->get();
            
        $mPoint = DB::table('m_product_point')
            ->where('core_product_id',$id)
            ->get();
            
        $mPointType = DB::table('m_type_point')
            ->get();
            
        $mUnit = DB::table('m_unit')
            ->get();
            
        $cosGroup = DB::table('m_cos_group')
            ->get();
            
        $category = DB::table('m_asset_category')
            ->get();
            
        $brand = DB::table('m_asset_manufacture')
            ->orderBy('manufacture_name','asc')
            ->get();

        return view ('Stock/MasterData/productModalFormPrice', compact('mProdUnit','mProduct','mPriceSell','mPoint','mPointType','mUnit','cosGroup','category','brand','id','countPrdSell','mSize'));
    }
    
    public function deleteProduct ($id){
        echo $id;
        DB::table('m_product')
            ->where('idm_data_product',$id)
            ->update([
                'product_status'=>'0',    
            ]);
            
        // DB::table('m_product_unit')
        //     ->where('core_id_product',$id)
        //     ->delete();
            
        // DB::table('m_product_price_sell')
        //     ->where('core_product_price',$id)
        //     ->delete();
    }
    public function activeProduct ($id){
        echo $id;
        DB::table('m_product')
            ->where('idm_data_product',$id)
            ->update([
                'product_status'=>'1',    
            ]);
    }
    
    public function postEditProduct (Request $reqpostedit){
        $tableName = $reqpostedit->tableName;
        $coloumn = $reqpostedit->column;
        $editVal = str_replace(".","",$reqpostedit->editVal);
        $idData = $reqpostedit->id;
        $tableID = $reqpostedit->tableID;
        $idProd = $reqpostedit->idProd;
        
        if($coloumn == "product_volume"){
            DB::table($tableName)
                ->where($tableID,$idData)
                ->update([
                    $coloumn => $editVal    
                ]);
                
            // cek data
            $volData1 = DB::table('m_product_unit')
                ->where([
                    ['core_id_product',$idProd],
                    ['size_code','1']
                    ])
                ->first();
               
            $volData2 = DB::table('m_product_unit')
                ->where([
                    ['core_id_product',$idProd],
                    ['size_code','2']
                    ])
                ->first();
                
            $selectCode = DB::table('m_product_unit')
                ->select('size_code')
                ->where($tableID,$idData)
                ->first();
                
            if(empty($volData2)){
                $a = $editVal;
            }
            elseif($volData2->product_volume=='0'){
                $a = $editVal;
            }
            else{
                if($selectCode->size_code == '1'){
                    $a = $editVal * $volData2->product_volume;
                }
                elseif($selectCode->size_code == '2'){
                    $a = $editVal * $volData1->product_volume;
                }
            }
            
            DB::table('m_product_unit')
                ->where([
                    ['core_id_product',$idProd],
                    ['size_code','3']
                    ])
                ->update([
                    'product_volume'=>$a
                ]);
            
            if ($selectCode->size_code == '1') {
                $colM_Product = "large_unit_val";
            }
            elseif ($selectCode->size_code == '2') {
                $colM_Product = "medium_unit_val";
            }
            elseif ($selectCode->size_code == '3') {
                $colM_Product = "small_unit_val";
            }
            
            DB::table('m_product')
                ->where('idm_data_product',$idProd)
                ->update([
                    $colM_Product => $editVal
                ]);
            
        }
        elseif ($coloumn == "product_price_order") {
            echo $coloumn;
            $selectCode = DB::table('m_product_unit')
                ->select('size_code','product_volume')
                ->where([
                    ['core_id_product',$idProd],
                    ['size_code','!=','1']
                    ])
                ->get();

            $selectCode1 = DB::table('m_product_unit')
                ->select('size_code','product_volume')
                ->where([
                    ['core_id_product',$idProd],
                    ['size_code','1']
                    ])
                ->first();           
                
            foreach ($selectCode as $sc) {
                if ($sc->size_code == '2') {
                    $colUpdateHrg = $editVal / $selectCode1->product_volume;                    
                }
                else {
                    $colUpdateHrg = $editVal / $sc->product_volume;                                        
                }
                
                DB::table('m_product_unit')
                    ->where([
                        ['core_id_product',$idProd],
                        ['size_code',$sc->size_code]
                    ])
                    ->update([
                        'product_price_order'=>$colUpdateHrg
                    ]);
            }

            DB::table($tableName)
                ->where($tableID,$idData)
                ->update([
                    $coloumn => $editVal    
                ]);
        }
        elseif ($coloumn == "product_size") {
            if ($editVal == "BESAR") {
                $sizeCode = '1';
            }
            elseif ($editVal == "KECIL") {
                $sizeCode = '2';
            }
            elseif ($editVal == "KONV") {
                $sizeCode = '3';
            }
            else {
                $sizeCode = '0';
            }

            DB::table($tableName)
                ->where($tableID,$idData)
                ->update([
                    $coloumn => $editVal,
                    'size_code' => $sizeCode   
                ]);
        }
        else{
            DB::table($tableName)
                ->where($tableID,$idData)
                ->update([
                    $coloumn => $editVal    
                ]);
        }
        return back();
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

    public function MenuEditHarga ($idProduct){
        $mUnit = DB::table('m_unit')
            ->orderBy('unit_note','asc')
            ->get();        

        $dataEditCosGroup = DB::table('m_product_price_sell')
            ->where('core_product_price',$idProduct)
            ->get();

        $dataCosGroup = DB::table('m_cos_group')
            ->get();
        
        $listSizeNew = DB::table('m_size')
            ->get();

        return view ('Stock/MasterData/productModalFormPriceEdit', compact('dataEditCosGroup','mUnit','idProduct','dataCosGroup','listSizeNew'));
    }

    public function listSizePrdEdit($coreProdId){
        $dataEditUnit = DB::table('m_product_unit')
            ->where('core_id_product',$coreProdId)
            ->get();

        return view ('Stock/MasterData/productModalFormPriceEditSize', compact('dataEditUnit'));
    }
    
    public function deleteUnit($id){
        $m_unit = DB::table('m_product_unit')
            ->select('core_id_product','size_code')
            ->where('idm_product_satuan',$id)
            ->first();

        $colM_Product = '';

        if ($m_unit->size_code == '1') {
            $colM_Product = "large_unit_val";
        }
        elseif ($m_unit->size_code == '2') {
            $colM_Product = "medium_unit_val";
        }
        elseif ($m_unit->size_code == '3') {
            $colM_Product = "small_unit_val";
        }
        DB::table('m_product')
            ->where('idm_data_product',$m_unit->core_id_product)
            ->update([
                $colM_Product => '0'
            ]);
            
        DB::table('m_product_unit')
            ->where('idm_product_satuan',$id)
            ->delete();
    }
    
    public function postAddUnit(Request $reqPostUnit){
        $prdID = $reqPostUnit -> prdID;
        $prdSize = $reqPostUnit -> size;
        $satuan = $reqPostUnit -> satuan;
        $volume = $reqPostUnit -> volume;
        $setBarcode = $reqPostUnit -> setBarcode;
        $stock = $reqPostUnit -> stock;
        $sizecode = '0';
        
        if($prdSize == "BESAR"){
            $sizecode = '1';
            $colM_Product = "large_unit_val";
        }elseif($prdSize == "KECIL"){
            $sizecode = '2';
            $colM_Product = "medium_unit_val";
        }elseif($prdSize == "KONV"){
            $sizecode = '3';
            $colM_Product = "small_unit_val";
        }
        
        $id=DB::select("SHOW TABLE STATUS LIKE 'm_product_unit'");
        $next_id=$id[0]->Auto_increment;
        
        // Cek jumlah data unit pada table m_product_unit;
        $cekDatUnit = DB::table('view_product_stock')
            ->where('core_id_product',$prdID)
            ->count();
            
        $siteLoc = DB::table("m_site")
                ->get();

        // Jika jumlah data lebih atau sama dengan 1 maka akan dijalankan proses pemecahan stock    
        if($cekDatUnit >= '1'){
            // Ambil satuan volume unit dengan size code 1  

            // Insert into inv_stock dengan id baru / next ID dari m_product_unit   
            foreach($siteLoc as $ls){
                $location = $ls->idm_site;
                
                DB::table('inv_stock')
                    ->insert([
                        'product_id'=>$next_id,
                        'location_id'=>$location,
                        'stock'=>'0',
                        'stock_unit'=>'0',
                        'stock_out'=>'0',
                        'saldo'=>'0',
                        'stock_status'=>'1',
                    ]);
                
                $unitVolSatu = DB::table('view_product_stock')
                    ->where([
                        ['core_id_product',$prdID],
                        ['size_code','1'],
                        ['location_id',$location]
                        ])
                    ->first();
                    
                $volSatu = $unitVolSatu->product_volume;    
                $stockSatu = $unitVolSatu->stock;  
                
                $unitVolDua = DB::table('view_product_stock')
                    ->where([
                        ['core_id_product',$prdID],
                        ['size_code','2'],
                        ['location_id',$location]
                        ])
                    ->first();
                    
                if(!empty($unitVolDua)){
                    $volDua = $unitVolDua->product_volume;    
                    $stockDua = $unitVolDua->stock; 
                } 
                else{
                    $volDua = $volSatu;    
                    $stockDua = $stockSatu; 
                }
                
                if ($prdSize == "KECIL"){
                    $qty = $stockSatu * $volSatu;
                }
                elseif($prdSize == "KONV"){
                    $qty = $stockDua * $volDua;
                }
                //echo $qty.";";
                
                DB::table('inv_stock')
                    ->where([
                        ['product_id',$next_id],
                        ['location_id',$location]
                        ])
                    ->update([
                        'stock'=>$qty,
                        'stock_unit'=>'0',
                        'stock_out'=>'0',
                        'saldo'=>$qty,
                    ]);
                
            }

            DB::table('m_product')
                ->where('idm_data_product',$prdID)
                ->update([
                    $colM_Product => $volume
                ]);
            
        }
        
        
        DB::table('m_product_unit')
            ->insert([
                'core_id_product'=>$prdID,    
                'product_size'=>$prdSize,    
                'product_satuan'=>$satuan,    
                'product_volume'=>$volume,    
                'set_barcode'=>$setBarcode,    
                'stock'=>$stock,    
                'size_code'=>$sizecode,
                'status'=>'1'
            ]);
        
        $getCusGroup = DB::table('m_cos_group')
            ->get();
            
        foreach($getCusGroup as $gcg){
            DB::table('m_product_price_sell')
            ->insert([
                'core_product_price'=>$prdID,
                'size_product'=>$prdSize,
                'cos_group'=>$gcg->idm_cos_group,
                'price_sell'=>'0',
                'price_sell_status'=>'1'
            ]);
        }
        
            
        // $countKonv = DB::table('m_product_unit')
        //     ->where([
        //         ['core_id_product',$prdID],
        //         ['size_code','3']
        //         ])
        //     ->count();
        
        //Jika tidak ada data konversi di database maka create data konversi kedatabase.     
        // if($countKonv == '0' AND $prdSize == "KECIL"){
        //     $unitBesar = DB::table('m_product_unit')
        //         ->where([
        //             ['core_id_product',$prdID],
        //             ['size_code','1']
        //             ])
        //         ->first();
                
        //     $volBesar = $unitBesar->product_volume;
        //     $volKonv = $volBesar * $volume;
            
        //     DB::table('m_product_unit')
        //         ->insert([
        //             'core_id_product'=>$prdID,    
        //             'product_size'=>"KONV",     
        //             'product_volume'=>$volKonv,    
        //             'set_barcode'=>$setBarcode, 
        //             'size_code'=>'3',
        //             'stock'=>$stock,  
        //             'status'=>'1'
        //         ]);
        // }
        
    }
    
    public function postDeleteItem($dataId, $dataSize){
        $deleteSell = DB::table('m_product_price_sell')
            ->where([
                ['core_product_id',$dataId],
                ['size_product',$dataSize]
                ])
            ->delete();
    }
}
