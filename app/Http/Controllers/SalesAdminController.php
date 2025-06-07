<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SalesAdminController extends Controller
{
    public function mainDashboard (){
    }

    public function mainProduct (){
        $company = Auth::user()->company;

        $id=DB::select("SHOW TABLE STATUS LIKE 'm_product'");            
        $nextID=$id[0]->Auto_increment;

        $productCode = DB::table('m_product')
            ->select('product_code','product_name')
            ->where('comp_id',$company)
            ->get();

        return view('Z_Additional_Admin/AdminMasterData/mainProduct',compact('productCode','company','nextID'));
    }

    public function newProduct (){
        return view('Z_Additional_Admin/AdminMasterData/mainProductNewForm');
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
