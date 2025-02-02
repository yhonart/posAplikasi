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

    public function storeName (){
        $storeName = DB::table('m_company')
            ->first();

        return view ('storeName', compact('storeName'));
    }

    public function storeNameLogin (){
        $storeName = DB::table('m_company')
            ->first();
            
        return view ('storeName', compact('storeNameLogin'));
    }
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
        $role = Auth::user()->hakakses;
        $checkArea = $this->checkuserInfo(); 
        $userID = Auth::user()->id;

        $dbUser = DB::table('users_role as a')
            ->select('a.*','b.name','b.email')
            ->leftJoin('users as b', 'a.user_id','=','b.id')
            ->where('a.user_id',$userID)
            ->first();

        $userKasir = DB::table('users')
            // ->where('hakakses','2')
            ->get();
            
        $userRoles = $dbUser->role_code;
        
        if($role == '1'){
            if ($userRoles == '1') {
                return view('Dashboard/DashboardTransaksi', compact('userKasir'));
            }
            else {
                return view('Dashboard/WelcomeHome', compact('dbUser'));
            }
        }
        elseif($role == '2'){
            return view('Cashier/maintenancePage', compact('checkArea'));
        }
        // else{
        //     $this->middleware('guest')->except('logout');
        //     return view ('auth/login');
        // }
    }
    
    public function searchingMenu ($keyword){
        $userID = Auth::user()->id;
        // echo $keyword;
        $searchSubMenu = DB::table('m_submenu')
            ->where('name_menu','like','%'.$keyword.'%')
            ->get();

        $cekUserGroup = DB::table('users_role')
            ->where([
                ['user_id',$userID],
                ['role_code','1']
            ])
            ->count();
            
        if($cekUserGroup >= '1'){
            $mainMenu = DB::table('m_public_system')
                ->where('status','1')
                ->orderBy('ordering','asc')
                ->get();
                
            $subMenu = DB::table('m_submenu')
                ->where('status','1')
                ->get();
                
        }
        else{
        $mainMenu = DB::table('users_auth as a')
                ->leftJoin('m_public_system as b','a.menu_id','=','b.idm_system')
                ->where([
                    ['a.users_id',$userID],
                    ['b.status','1']
                    ])
                ->orderBy('b.ordering','asc')
                ->get(); 
                
        $subMenu = DB::table('users_auth as a')
                ->leftJoin('m_submenu as b','a.submenu_id','=','b.idm_submenu')
                ->where([
                    ['a.users_id',$userID],
                    ['b.status','1']
                    ])
                ->get(); 
        }
        if ($keyword == '0') {
            return view('mainDivMenu', compact('mainMenu','subMenu','cekUserGroup')); 
        }
        else {
            return view('mainSearchMenu', compact('searchSubMenu','cekUserGroup')); 
        }

    }

    public function mainMenu(){
        $userID = Auth::user()->id;
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
    
    public function UnderMaintenance (){
        return view ('UnderMaintenance');
    }

    public function changeCloseData(){
        $userName = Auth::user()->name;

        //Cek apakah ada transaksi yang masih di proses.
        $selectTable = DB::table('tr_store')
            ->where([
                ['created_by',$userName],
                ['status','1']
            ])
            ->get();

        foreach($selectTable as $st){
            $id = $st->tr_store_id;
            $numberTrx = $st->billing_number;

            DB::table('tr_store_prod_list')
                ->where('from_payment_code',$numberTrx)
                ->update([
                    'status'=>'0',
                    'is_delete'=>'1'
                ]);

            DB::table('tr_store')
                ->where('tr_store_id',$id)
                ->update([
                    'numbering'=>'0',
                    'member_id'=>'0',
                    't_bill'=>'0',
                    't_pay'=>'0',
                    't_difference'=>'0',
                    't_pay_return'=>'0',
                    't_item'=>'0',
                    'status'=>'0',
                    'return_by'=>$userName,
                    'is_return'=>'1',
                ]);
        }
    }

    public function manualInsertKasBesar ()
    {
        // get transaksi item per day
        $keterangan = '';

        $penjualan = DB::table('view_trx_method');
        $penjualan = $penjualan->select(DB::raw('SUM(nominal) as paymentCus'),'date_trx','created_by'); 
        $penjualan = $penjualan->where('status_by_store','>=','3');
        $penjualan = $penjualan->groupBy('date_trx','created_by');
        $penjualan = $penjualan->get(); 

        foreach ($penjualan as $key) {
            $keterangan = "Penjualan ". $key->created_by;
            $createdBy  = $key->created_by;
            $tanggal  = $key->date_trx;
            $debit = $key->paymentCus;

            DB::table('lap_kas_besar')
                ->insert([
                    'description'=>$keterangan,
                    'create_by'=>$createdBy,
                    'trx_date'=>$tanggal,
                    'debit'=>$debit,
                    'kredit'=>'0',
                    'saldo'=>$debit,
                    'created_date'=>now(),
                    'trx_code'=>'1'
                ]);
        }
    }
}
