<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function mainTransaction (){
        return view ('Stock/Transaction/transactionMain');
    }

    public function StockBarang (){
        return view ('Stock/Transaction/transactionMaintenance');
    }

    public function SearchProduct ($keyword){
        $productList = DB::table('m_product');        
            if ($keyword <> 0) {
                $productList = $productList->where(['product_name','LIKE','%'.$keyword.'%']);
            }
        $productList = $productList->paginate(5);

        $productPrice = DB::table('m_product_unit')
            ->get();            

        return view ('Stock/Transaction/transactionProdList', compact('productList','keyword','productPrice'));
    }
}
