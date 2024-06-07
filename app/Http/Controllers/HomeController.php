<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     
     //cek user role
    public function userRole (){
        if (Auth::check()) { 
            $userID = Auth::user()->id;
            $tbUserRole = DB::table('users_role')
                ->where([
                    ['user_id',$userID]
                    ])
                ->first();
            if(!empty($tbUserRole)){
                $userR = $tbUserRole->role_code;
            }
            else{
                $userR='0';
            }
        }
        else{
            return view ('auth/login');
        }
        return $userR;
    }
    
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
    
    public function index()
    {
        $role = $this->userRole();
        $checkArea = $this->checkuserInfo(); 
        
        if($role == '1'){
            return view('home');
        }
        elseif($role == '2'){
            return view('Cashier/maintenancePage', compact('checkArea'));
        }
        // else{
        //     $this->middleware('guest')->except('logout');
        //     return view ('auth/login');
        // }
    }
    
    

    public function getMenu(){
        $dbSystem = DB::table('m_public_system')
            ->where('status','1')
            ->orderBy('idm_system','asc')
            ->get();
        return view ('homeDiv', compact('dbSystem'));
    }

    public function GlobalDelete($dataId, $dataTb, $dataCol){
        DB::table($dataTb)
            ->where($dataCol,$dataId)
            ->delete();
        
            return back();
    }

    public function GlobalEditTable(Request $reqLiveEdit){
        $tableName = $reqLiveEdit->tableName;
        $column = $reqLiveEdit->column;
        $editVal = str_replace(".","",$reqLiveEdit->editVal);
        $id = $reqLiveEdit->id;
        $tableId = $reqLiveEdit->tableId;

        DB::table($tableName)
            ->where($tableId,$id)
            ->update([
                $column => $editVal,
            ]);
        return back();
    }
}
