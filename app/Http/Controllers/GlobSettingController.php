<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class GlobSettingController extends Controller
{
    protected $tempInv;
    protected $tempUser;
    
    public function __construct(TempInventoryController $tempInv, TempUsersController $tempUser)
    {
        $this->TempInventoryController = $tempInv;
        $this->TempUsersController = $tempUser;
    }
    
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
        return view ('globalSetting/newFormKas');
    }
    
    public function tableSetKasKasir(){
        $tbKasKasir = DB::table('m_set_kas')
            ->get();
            
        return view ('globalSetting/tableKasKasir', compact('tbKasKasir'));
    }
    
}
