<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LapLabaRugiController extends Controller
{
    public function mainPage(){

        $mProduct = DB::table('m_product')
            ->get();

        return view('lapLabaRugi/main', compact('mProduct'));
    }

    public function getDisplayAll(){
        $today = date("Y-m-d");
        $mProduct = DB::table('tr_store_prod_list as a')
            ->select('a.*','b.product_name')
            ->leftJoin('m_product as b', 'a.product_code','=','b.idm_data_product')
            ->where([
                ['a.date',$today],
                ['status','4']
                ])
            ->orderBy('b.product_name','ASC')
            ->get();

        return view('lapLabaRugi/displayAllTable', compact('mProduct'));
    }

    public function getDownloadExcel($prdID, $fromDate, $endDate, $typeCetak){
        $today = date("Y-m-d");

        $mProduct = DB::table('tr_store_prod_list as a');
        $mProduct = $mProduct->select('a.*','b.product_name');
        $mProduct = $mProduct->leftJoin('m_product as b', 'a.product_code','=','b.idm_data_product');
        if ($prdID <> '0') {
            $mProduct = $mProduct->where([
                    ['a.product_code',$prdID],
                    ['a.date',$today],
                    ['status','4']
            ]);            
        }
        else {
            $mProduct = $mProduct->where([
                    ['a.date',$today],
                    ['status','4']            
            ]);
        }
        $mProduct = $mProduct->whereBetween('a.date',[$fromDate, $endDate]);
        $mProduct = $mProduct->orderBy('b.product_name','ASC');
        $mProduct = $mProduct->get();

        return view('lapLabaRugi/getDownloadExcel', compact('mProduct'));
    }
}
