<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class setLokasiController extends Controller
{
    public function main (){
        return view('setLocation/main');
    }

    public function newFormLokasi (){
        $company = Auth::user()->company;
        
        return view('setLocation/formNewLokasi');
    }

    public function tableDataLokasi (){
        $company = Auth::user()->company;
        $dbLokasi = DB::table('m_site')
            ->where('comp_id',$company)
            ->get();

        return view('setLocation/tableDataLokasi', compact('dbLokasi'));
    }
}
