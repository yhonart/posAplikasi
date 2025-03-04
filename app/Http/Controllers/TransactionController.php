<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function mainTransaction (){
        return view ('Stock/Transaction/transactionMain');
    }

    public function StockBarang (){
        return view ('Stock/Transaction/transactionMaintenance');
    }

    public function SearchProduct ($keyword){
        $authUserCompany = Auth::user()->company;

        $productList = DB::table('m_product');
        $productList = $productList->select('idm_data_product','product_name');
        if ($keyword <> 0) {
            $productList = $productList->where('product_name','LIKE','%'.$keyword.'%');
        }
        $productList = $productList->where('comp_id',$authUserCompany);
        $productList = $productList->orderBy('product_name','ASC');
        $productList = $productList->get();

        $productPrice = DB::table('m_product_unit')
            ->get();            

        return view ('Stock/Transaction/transactionProdList', compact('productList','keyword','productPrice'));
    }
}
