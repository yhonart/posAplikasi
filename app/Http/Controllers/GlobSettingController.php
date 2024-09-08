<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class GlobSettingController extends Controller
{   
    public function userApproval (){
        $userID = Auth::user()->id;
        $cekUserGroup = DB::table('users_role')
            ->where([
                ['user_id',$userID],
                ['role_code','1']
            ])
            ->count();
            
        return $cekUserGroup;
    }
    
    public function setKasKasir (){
        return view ('globalSetting/setKasKasir');
    }
    
    public function newNominal(){
        $userKasir = DB::table('users')
            ->where('hakakses','2')
            ->get();

        return view ('globalSetting/newFormKas',compact('userKasir'));
    }

    public function postNewNominal(Request $reqPostNom){
        $userKasir = $reqPostNom->selectPersonil;
        $nominalKas = $reqPostNom->nominalKas;

        if ($nominalKas <> '' OR $nominalKas <> '0') {
            DB::table('m_set_kas')
                ->insert([
                    'personal_id'=>$userKasir,
                    'nominal'=>$nominalKas,
                ]);
        }
    }
    
    public function tableSetKasKasir(){
        $tbKasKasir = DB::table('m_set_kas as a')
            ->leftJoin('users as b','a.personal_id','=','b.id')
            ->get();
            
        return view ('globalSetting/tableKasKasir', compact('tbKasKasir'));
    }
    
}
