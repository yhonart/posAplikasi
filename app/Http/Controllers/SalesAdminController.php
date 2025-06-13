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

        $countActiveOpname = DB::table('inv_stock_opname')
            ->where([
                ['status','1'],
                ['comp_id',$companyID],
                ['created_by',$creator]
            ])
            ->count();
        if ($countActiveOpname == 0) {
            return view ('Z_Additional_Admin/AdminInventory/mainStockOpnameFormDok');
        }
        else {
            return view ('Z_Additional_Admin/AdminInventory/mainStockOpnameFormItem');
        }
    }
}
