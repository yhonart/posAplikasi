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
                    ['a.product_code',$prdID]
            ]);            
        }
        $mProduct = $mProduct->where('a.status','4');
        $mProduct = $mProduct->whereBetween('a.date',[$fromDate, $endDate]);
        $mProduct = $mProduct->orderBy('b.product_name','ASC');
        $mProduct = $mProduct->get();

        $tableProduct = DB::table('tr_store_prod_list as a');
        $tableProduct = $tableProduct->select('a.*','b.product_name');
        $tableProduct = $tableProduct->leftJoin('m_product as b', 'a.product_code','=','b.idm_data_product');       
        $tableProduct = $tableProduct->where('a.status','4');
        $tableProduct = $tableProduct->whereBetween('a.date',[$fromDate, $endDate]);
        $tableProduct = $tableProduct->orderBy('b.product_name','ASC');
        $tableProduct = $tableProduct->get();
        
        $sumPrice = DB::table('tr_store_prod_list as a');
        $sumPrice = $sumPrice->select('a.product_code',DB::raw('SUM(m_price) as hargaModal'));
        $sumPrice = $sumPrice->leftJoin('m_product as b', 'a.product_code','=','b.idm_data_product');
        if ($prdID <> '0') {
            $sumPrice = $sumPrice->where([
                    ['a.product_code',$prdID]
            ]);            
        }
        $sumPrice = $sumPrice->where('a.status','4');
        $sumPrice = $sumPrice->whereBetween('a.date',[$fromDate, $endDate]);
        $sumPrice = $sumPrice->orderBy('b.product_name','ASC');
        $sumPrice = $sumPrice->groupBy('a.product_code');
        $sumPrice = $sumPrice->get();

        

        return view('lapLabaRugi/getDownloadExcel', compact('mProduct','tableProduct','sumPrice'));
    }
}
