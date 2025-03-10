<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;


class MasterDataKategoriKasController extends Controller
{    
    // CEK INFORMASI USER TERKAIT AREA KERJA YANG TERDAFTAR PADA SISTEM
    public function checkuserInfo (){
        $userID = Auth::user()->id;
        $cekUserArea = DB::table('users_area AS a')
            ->select('a.area_id','b.site_code','b.site_name')
            ->leftJoin('m_site AS b','a.area_id','=','b.idm_site')
            ->where('a.user_id',$userID)
            ->first();
        if (!empty($cekUserArea)) {
            # code...
            $userAreaID = $cekUserArea->area_id;            
        }
        else {
            $userAreaID = 0;
        }
        return $userAreaID;
    }
    
    public function mainCatgoryController () {
        return view('AssetManagement/MasterData/KasKategori');
    }

    public function addKategori(){
        return view('AssetManagement/MasterData/KasKategoriModalAdd');
    }
    
    public function addSubKategori(){
        $kategori = DB::table('m_category_kas')
            ->where('status','1')
            ->get();

        return view('AssetManagement/MasterData/KasSubKategoriModalAdd', compact('kategori'));
    }

    public function postKategori(Request $reqPostKategori){
        $namaKategori = strtoupper($reqPostKategori->namaKategori);
        $userName = Auth::user()->name;

        if ($namaKategori=="" OR $namaKategori==" ") {
            $msg = array('warning' => 'Anda belum memasukkan nama kategori'); 
        }
        else {
            DB::table('m_category_kas')
                ->insert([
                    'cat_name'=>$namaKategori,
                    'status'=>'1'
                ]);

            $msg = array('success' => 'Master data berhasil dimasukkan.'); 
        }
        return response()->json($msg);
    }

    public function listTableKategori(){

        $loadTable = DB::table('m_category_kas')
            ->get();
        
        return view('AssetManagement/MasterData/KasKategoriMainTable', compact('loadTable'));
    }

    public function listTableSubKategori(){
        $loadSubKategori = DB::table('m_subcategory_kas as a')
            ->leftJoin('m_category_kas as b', 'a.from_cat_id','=','b.idm_cat_kas')
            ->get();

        return view('AssetManagement/MasterData/KasSubKategoriTable', compact('loadSubKategori'));
    }

    public function postSubKategori(Request $reqSubkategori){
        $subCategoryName = strtoupper($reqSubkategori->namaSubKategori);
        $kategori = strtoupper($reqSubkategori->kategori);
        $lampiran = $reqSubkategori->lampiran;

        if ($subCategoryName == "") {
            $msg = array('warning' => 'Anda belum memasukkan nama sub kategori.'); 
        }
        elseif ($kategori == "0") {
            $msg = array('warning' => 'Anda belum memasukkan group kategori.'); 
        }
        else {
            DB::table('m_subcategory_kas')
                ->insert([
                    'from_cat_id'=>$kategori,
                    'subcat_name'=>$subCategoryName,
                    'lampiran'=>$lampiran
                ]);
            $msg = array('success' => 'Data subkategori berhasil ditambahkan.'); 
        }
        return response()->json($msg);
    }
}
