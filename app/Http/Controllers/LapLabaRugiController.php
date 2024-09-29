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
        $mProduct = DB::table('trans_product_list_view')
            ->get();

        return view('lapLabaRugi/displayAllTable', compact('mProduct'));
    }
}
