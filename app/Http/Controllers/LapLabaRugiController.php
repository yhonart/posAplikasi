<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LapLabaRugiController extends Controller
{
    public function mainPage(){
        return view('lapLabaRugi/main');
    }

    public function getDisplayAll(){
        $mProduct = DB::table('tr_store_prod_list as a')
            ->select('a.*','b.product_name')
            ->leftJoin('m_product as b', 'a.product_code','=','b.idm_data_product')
            ->get();

        return view('lapLabaRugi/displayAllTable', compact('mProduct'));
    }
}
