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

    public function postNewLocation(Request $postDataLocation){
        $company = Auth::user()->company;
        
        DB::table('m_site')
            ->insert([
                'site_code'=>$postDataLocation->kodeLokasi,
                'site_name'=>$postDataLocation->namaLokasi,
                'site_address'=>$postDataLocation->address,
                'site_status'=>'1',
                'site_city'=>$postDataLocation->city,
                'comp_id'=>$company,
                'site_group'=>$postDataLocation->groupLoc
            ]);
    }

    public function tableDataLokasi (){
        $company = Auth::user()->company;
        $dbLokasi = DB::table('m_site')
            ->where('comp_id',$company)
            ->get();

        return view('setLocation/tableDataLokasi', compact('dbLokasi'));
    }
}
