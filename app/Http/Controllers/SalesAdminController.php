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
    }

    public function mainProduct (){
        $company = Auth::user()->company;
        $productCode = DB::table('m_product')
            ->select('product_code','product_name')
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
}
