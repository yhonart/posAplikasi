<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SalesAdminController extends Controller
{
    public function companyCode (){
        $companyID = Auth::user()->company;
        $company = DB::table('m_company')
            ->select('company_code')
            ->where('idm_company',$companyID)
            ->first();
        $code = $company->company_code;
        return $code;
    }

    public function mainDashboard (){
        $companyID = Auth::user()->company;
        $countItem = DB::table('m_product')
            ->where('comp_id',$companyID)
            ->count();
        return view('Z_Additional_Admin/AdminDashboard/mainDashboard',compact('countItem'));
    }

    public function mainProduct (){
        $company = Auth::user()->company;
        $productCode = DB::table('m_product')
            ->select('product_code','product_name','idm_data_product')
            ->where('comp_id',$company)
            ->get();

        return view('Z_Additional_Admin/AdminMasterData/mainProduct',compact('productCode','company'));
    }

    public function newProduct (){
        $id=DB::select("SHOW TABLE STATUS LIKE 'm_product'");            
        $nextID=$id[0]->Auto_increment;
        $authCompany = Auth::user()->company;
        $number = '0';

        $countPrdComp = DB::table('m_product')
            ->where('comp_id',$authCompany)
            ->count();

        $prdCategory = DB::table('m_asset_category')
            ->where('initial_code','ITC02')
            ->get();

        if ($countPrdComp == '0') {
            $number = '1';
        }
        else {
            $number = $countPrdComp;
        }

        $companyCodePrd = $this->companyCode();
        $prdCode = $companyCodePrd ."". sprintf("%05d",$number);

        return view('Z_Additional_Admin/AdminMasterData/mainProductNewForm',compact('nextID','prdCode','prdCategory'));
    }

    public function postNewProduct(Request $reqPostNewPrd){
        $productID = $reqPostNewPrd->productID;
        $productCode = $reqPostNewPrd->productCode;
        $productName = $reqPostNewPrd->productName;
        $productCategory = $reqPostNewPrd->productCategory;
        $minimumStock = $reqPostNewPrd->minimumStock;
        $company = Auth::user()->company;

        $id=DB::select("SHOW TABLE STATUS LIKE 'm_product_unit'");            
        $nextUnitID=$id[0]->Auto_increment;

        if ($productName == "" || $productCategory == "0") {
            $msg = array('warning' => 'Nama produk dan categori produk wajib diisi!');
        }
        else {
            DB::table('m_product')
                ->insert([
                    'product_code'=>$productCode,
                    'product_name'=>$productName,
                    'product_category'=>$productCategory,
                    'comp_id'=>$company,
                    'minimum_stock'=>$minimumStock,
                    'large_unit_val'=>'0',
                    'medium_unit_val'=>'0',
                    'small_unit_val'=>'0',
                    'product_status'=>'1',
                ]);
                
            DB::table('inv_stock')
                ->insert([
                    'product_id'=>$nextUnitID,
                    'location_id'=>'3',
                    'stock'=>'0',
                    'stock_unit'=>'0',
                    'stock_out'=>'0',
                    'saldo'=>'0',
                    'stock_status'=>'1',
                ]);

            DB::table('m_product_unit')
                ->insert([
                    'core_id_product'=>$productID,
                    'product_satuan'=>'0',
                    'product_price_order'=>'0',
                    'status'=>'1',
                    'product_size'=>'BESAR',
                    'size_code'=>'1',
                    'product_volume'=>'1'
                ]);

            
            $msg = array('success' => 'Produk berhasil ditambahkan');            
        }
        return response()->json($msg);
    }

    public function newPrice($id){

        return view('Z_Additional_Admin/AdminMasterData/mainProductNewPrice', compact('id'));
    }

    public function modalNewVarian ($id){
        return view('Z_Additional_Admin/AdminMasterData/modalVarianPrice', compact('id'));
    }
    
    public function tableVarianPrice ($id){
        $varianPriceList = DB::table('m_z_varian_price')
            ->where('core_product_id',$id)
            ->get();

        return view('Z_Additional_Admin/AdminMasterData/modalVarianPriceList', compact('id','varianPriceList'));
    }

    public function postNewVarian (Request $reqVarPrice){
        $varianCode = $reqVarPrice->valCode;
        $varianPrice = $reqVarPrice->valPrice;
        $id = $reqVarPrice->valID;

        if ($varianCode == "" || $varianPrice == "") {
            $msg = array('warning' => 'Code Varian dan Varian Price Wajib Di Isi!');
        }
        else {
            DB::table('m_z_varian_price')
                ->insert([
                    'varian_price_code'=>$varianCode,
                    'varian_price'=>$varianPrice,
                    'core_product_id'=>$id,
                    'status'=>'1'
                ]);
            $msg = array('success' => 'Success Data Berhasil Dimasukkan');
        }
        return response()->json($msg);
    }

    public function postNewVarianFixed (Request $reqVarPriceFixed){
        $valInit = $reqVarPriceFixed->valInit;
        $valCount = $reqVarPriceFixed->valCount;
        $valMinimum = $reqVarPriceFixed->valMinimum;
        $valDif = $reqVarPriceFixed->valDif;
        $id = $reqVarPriceFixed->id;
        $varianPrice = 0;
        $varianCode = "";

        if ($valInit == "" || $valCount == "" || $valMinimum == "" || $valDif == "") {
            $msg = array('warning' => 'Wajib Di isi semuanya, silahkan cek kembali!');
        }
        else {
            for ($i=0; $i < $valCount ; $i++) { 
                $noCode = $i + 1;
                $varianCode = $valInit."".$noCode;
                $varianPrice = $valMinimum + ($valDif * $i);
                DB::table('m_z_varian_price')
                    ->insert([
                        'varian_price_code'=>$varianCode,
                        'varian_price'=>$varianPrice,
                        'core_product_id'=>$id,
                        'status'=>'1'
                    ]);
            }
            $msg = array('success' => 'Success Data Berhasil Dimasukkan');
        }
        return response()->json($msg);
    }
    public function modalNewVarianFixed ($id){
        return view('Z_Additional_Admin/AdminMasterData/modalVarianPriceFixed', compact('id'));
    }

    public function detailProduct($dataID){
        $companyID = Auth::user()->company;

        $prdCategory = DB::table('m_asset_category')
            ->where('initial_code','ITC02')
            ->get();
        
        $productDetail = DB::table('m_product')
            ->where('idm_data_product',$dataID)
            ->first();

        return view('Z_Additional_Admin/AdminMasterData/mainProductEditForm', compact('dataID','productDetail','prdCategory'));
    }

    public function mainCustomer (){
        return view ('Z_Additional_Admin/AdminMasterData/mainCustomers');
    }

    public function mainSalesOrder (){

    }

    public function mainDeliveryReport (){

    }

    public function mainUser (){
        return view ('Z_Additional_Admin/AdminMasterData/mainUsers');
    }

    public function mainCategory (){
        return view ('Z_Additional_Admin/AdminMasterData/mainCategory');
    }
    
    public function dataTableCategory (){
        return view ('Z_Additional_Admin/AdminMasterData/mainCategoryTable');
    }
    public function newCategory (){
        return view ('Z_Additional_Admin/AdminMasterData/mainCategoryNew');
    }

    //STOCK INVENTORY
    public function mainStock(){
        return view ('Z_Additional_Admin/AdminInventory/mainInventory');
    }

    public function dataResultInv ($prdVal, $catVal){
        $companyID = Auth::user()->company;

        $docInventory = DB::table('view_product_stock');
        $docInventory = $docInventory->where('comp_id', $companyID);
        if ($prdVal <> '0') {
            $docInventory = $docInventory->where('idm_data_product',$prdVal);
        }
        elseif ($catVal <> '0') {
            $docInventory = $docInventory->where('product_category',$catVal);
        }
        $docInventory = $docInventory->orderBy('product_code','asc');
        $docInventory = $docInventory->get();

        return view ('Z_Additional_Admin/AdminInventory/mainInventoryTable', compact('docInventory','companyID'));
    }

    //STOCK OPNAME
    public function mainStockOpname (){
        return view ('Z_Additional_Admin/AdminInventory/mainStockOpname');
    }

    public function displayStockOpname (){
        $companyID = Auth::user()->company;
        $creator = Auth::user()->name;
        $compCode = $this->companyCode(); 
        $periode = date("mY");
        $dateNo = date("dmy");

        $countNumbOpname = DB::table('inv_stock_opname')
            ->where([
                ['comp_id',$companyID],
                ['periode',$periode]
                ])
            ->count();

        if ($countNumbOpname == '0') {
            $no = '1';
        }
        else {
            $no = $countNumbOpname + 1;
        }       
        $numberDok = "OP" . $compCode . $dateNo . "-" . sprintf("%04d",$no);
        $countActiveOpname = DB::table('inv_stock_opname')
            ->where([
                ['status','1'],
                ['comp_id',$companyID],
                ['created_by',$creator]
            ])
            ->count();

        $mSite = DB::table('m_site')
            ->where('comp_id',$companyID)
            ->get();
        
        if ($countActiveOpname == 0) {
            return view ('Z_Additional_Admin/AdminInventory/mainStockOpnameFormDok',compact('periode','numberDok','mSite'));
        }
        else {
            $getNumber = DB::table('inv_stock_opname')
                ->select('number_so','loc_so')
                ->where([
                    ['status','1'],
                    ['comp_id',$companyID],
                    ['created_by',$creator]
                ])
                ->first();

            $getProduct = DB::table('m_product')
                ->where('comp_id',$companyID)
                ->get();

            return view ('Z_Additional_Admin/AdminInventory/mainStockOpnameFormItem', compact('getNumber','getProduct'));
        }
    }

    public function postDokumen (Request $reqPostDok){
        $dokNumber = $reqPostDok->dokNumber;
        $dateDok = $reqPostDok->dateDok;
        $location = $reqPostDok->location;
        $description = $reqPostDok->description;
        $periode = date("mY");
        $createdBy = Auth::user()->name;
        $companyID = Auth::user()->company;

        DB::table('inv_stock_opname')
            ->insert([
                'number_so'=>$dokNumber,
                'periode'=>$periode,
                'date_so'=>$dateDok,
                'loc_so'=>$location,
                'note_submit'=>$description,
                'created_by'=>$createdBy,
                'status'=>'1',
                'date_input'=>now(),
                'comp_id'=>$companyID
            ]);

        return back();
    }

    public function displaySatuanProduct ($prdID){
        $productSatuan = DB::table('m_product_unit')
            ->where([
                ['core_id_product',$prdID],
                ['product_volume','!=','0'],
                ['product_satuan','!=','']
                ])
            ->orderBy('size_code','desc')
            ->get();
        return view('Z_Additional_Admin/AdminInventory/listSatuan', compact('productSatuan'));
    }

    public function displayStock ($satuan, $prdID, $loc){
        $explodeSatuan = explode("|",$satuan);
        $prdSize = $explodeSatuan[0];
        $prdSatuan = $explodeSatuan[1];

        $countData = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$prdID],
                ['product_size',$prdSize],
                ['location_id',$loc],
                ])
            ->count();

        $lastStock = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$prdID],
                ['product_size',$prdSize],
                ['location_id',$loc],
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

    public function postItem (Request $reqItem){
        $dokNumber = $reqItem->dokNumber;
        $productID = $reqItem->product;
        $satuan = explode("|", $reqItem->satuan);
        $qty = $reqItem->qty;
        $lastStock = $reqItem->lastStock;
        $total = $reqItem->total;
        $invID = $reqItem->invID;
        $satuanSize = $satuan[0];
        $satuanName = $satuan[1];
        $createdBy = Auth::user()->name;
        
        DB::table('inv_list_opname')
            ->insert([
                'sto_number'=>$dokNumber,
                'inv_id'=>$invID,
                'product_id'=>$productID,
                'product_size'=>$satuanSize,
                'last_stock'=>$lastStock,
                'input_qty'=>$qty,
                'selisih'=>$total,
                'created_at'=>now(),
                'created_by'=>$createdBy,
                'status'=>'1',
                'display'=>'1',
                'saldo_konv'=>$lastStock
            ]);
    }

    public function tableInputItem($docNo){
        $listBarang = DB::table('inv_list_opname as a')
            ->join('view_product_stock as b','a.inv_id','=','b.idinv_stock')
            ->where([
                ['a.sto_number',$docNo],
            ])
            ->get(); 
        return view('Z_Additional_Admin/AdminInventory/tableStockOpnameItem', compact('listBarang'));
    }

    public function submitTransItem ($docNumber){
        $countItem = DB::table('inv_list_opname')
            ->where('sto_number',$docNumber)
            ->count();

        if ($countItem == '0') {
            # code...
        }
        else {
            DB::table('inv_list_opname')
                ->where('sto_number',$docNumber)
                ->update([
                    'status'=>'3'
                ]);

            DB::table('inv_stock_opname')
                ->where('number_so',$docNumber)
                ->update([
                    'status'=>'3'
                ]);

            //update stock!
            $selectItemOpname = DB::table('inv_list_opname')
                ->where('sto_number',$docNumber)
                ->get();

            foreach ($selectItemOpname as $keyItem) {
                $prdID = $keyItem->product_id;
                $qtystockOpname = $keyItem->input_qty;

                $getPrdUnit = DB::table('m_product_unit')
                    ->where('core_id_product',$prdID)
                    ->get();

                foreach ($getPrdUnit as $keyUnit) {
                    $prdUnitID = $keyUnit->idm_product_satuan;
                    DB::table('inv_stock')
                        ->where('product_id',$prdUnitID)
                        ->update([
                            'stock'=>$qtystockOpname
                        ]);
                }
            }
        }

        return back();
    }

    public function submitBatalTransItem ($docNumber){
        DB::table('inv_list_opname')
            ->where('sto_number',$docNumber)
            ->update([
                'status'=>'0'
            ]);

        DB::table('inv_stock_opname')
            ->where('number_so',$docNumber)
            ->update([
                'status'=>'0'
            ]);
    }

    public function mainTableStockOpname (){
        $compID = Auth::user()->company;
        $tableOpname = DB::table('inv_stock_opname as a')
            ->select('a.*','b.site_code','b.site_name')
            ->leftJoin('m_site as b','a.loc_so','=','b.idm_site')
            ->where([
                ['a.comp_id',$compID]
            ])
            ->get();
        return view('Z_Additional_Admin/AdminInventory/mainTableStockOpname', compact('tableOpname'));        
    }
}
