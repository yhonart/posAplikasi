<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LapLabaRugiController extends Controller
{
    public function mainPage(){
        $company = Auth::user()->company;
        $mProduct = DB::table('m_product')
            ->where('comp_id',$company)
            ->get();

        return view('lapLabaRugi/main', compact('mProduct'));
    }

    public function getDisplayAll($prdID, $fromDate,$endDate){
        $today = date("Y-m-d");
        $company = Auth::user()->company;
        $mProduct = DB::table('trans_product_list_view');
            $mProduct = $mProduct->select('product_name','product_code');
            if ($prdID <> '0') {
                $mProduct = $mProduct->where([
                        ['product_code',$prdID]
                ]);            
            }
            $mProduct = $mProduct->where([
                ['status','4'],
                ['comp_id',$company]
            ]);
            if ($fromDate <> '0' OR $endDate <> '0'){
                $mProduct = $mProduct->whereBetween('date',[$fromDate, $endDate]);
            }
            else {
                $mProduct = $mProduct->where('date',$today);
            }
            $mProduct = $mProduct->orderBy('product_name','ASC');
            $mProduct = $mProduct->groupBy('product_name');
            $mProduct = $mProduct->get();

        $detailItem = DB::table('trans_product_list_view');            
            if ($prdID <> '0') {
                $detailItem = $detailItem->where([
                        ['product_code',$prdID]
                ]);            
            }
            $detailItem = $detailItem->where([
                ['status','4'],
                ['comp_id',$company]
            ]);
            if ($fromDate <> '0' OR $endDate <> '0'){
                $detailItem = $detailItem->whereBetween('date',[$fromDate, $endDate]);
            }
            else {
                $detailItem = $detailItem->where('date',$today);
            }
            $detailItem = $detailItem->orderBy('product_name','ASC');
            $detailItem = $detailItem->get();

        return view('lapLabaRugi/displayAllTable', compact('mProduct','detailItem'));
    }

    public function getDownloadExcel($prdID, $fromDate, $endDate, $typeCetak){        
        $today = date("Y-m-d");
        $mCompany = DB::table('m_company')
            ->first();

        $mProduct = DB::table('trans_product_list_view');
        if ($prdID <> '0') {
            $mProduct = $mProduct->where([
                    ['product_code',$prdID]
            ]);            
        }
        $mProduct = $mProduct->where('status','4');
        $mProduct = $mProduct->whereBetween('date',[$fromDate, $endDate]);
        $mProduct = $mProduct->orderBy('product_name','ASC');
        $mProduct = $mProduct->groupBy('product_name');
        $mProduct = $mProduct->get();

        $tableProduct = DB::table('tr_store_prod_list as a');
        $tableProduct = $tableProduct->select('a.*','b.product_name');
        $tableProduct = $tableProduct->leftJoin('m_product as b', 'a.product_code','=','b.idm_data_product');       
        $tableProduct = $tableProduct->where('a.status','4');
        $tableProduct = $tableProduct->whereBetween('a.date',[$fromDate, $endDate]);
        $tableProduct = $tableProduct->orderBy('b.product_name','ASC');
        $tableProduct = $tableProduct->get();
        
        $sumPrice = DB::table('tr_store_prod_list as a');
        $sumPrice = $sumPrice->select('a.product_code',DB::raw('SUM(qty) as qty'), DB::raw('SUM(m_price) as hargaJual'), DB::raw('SUM(capital_price) as hargaModal'), DB::raw('SUM(t_price) as totalJual'));
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
        

        return view('lapLabaRugi/getDownloadExcel', compact('mProduct','tableProduct','sumPrice','fromDate','endDate','mCompany'));
    }
}
