<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class TrxKasUmumController extends Controller
{
    public function mainTrx(){
        return view('TrxKasUmum/main');
    }

    public function tambahBiaya()
    {
        $kasKategori = DB::table('m_category_kas')
            ->where('status','1')
            ->orderBy('cat_name','asc')
            ->get();

        $mStaff = DB::table('m_sales')
            ->where('sales_status','1')
            ->get();
        
        $mAdmin = DB::table('users')
            ->get();

        return view('TrxKasUmum/modalTambahBiaya', compact('kasKategori','mAdmin','mStaff'));
    }

    public function selectKategori($kategori)
    {
        $selectOption = DB::table('m_subcategory_kas')
            ->where('from_cat_id',$kategori)
            ->orderBy('subcat_name','asc')
            ->get();

        return view('TrxKasUmum/selectOptionSubKategori', compact('selectOption'));
    }

    public function postTrxPembiayaan(Request $reqAddPembiayaan)
    {
        echo "OK";
    }
}
