<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PersonaliaController extends Controller
{
    public function mainIndex (){
        return view ('hris/masterData/mainIndex');
    }

    public function dataTablePersonalia (){
        $personalia = DB::table('m_employee')
            ->paginate(10);

        return view ('hris/masterData/personaliaMaintenance');
    }
    
    public function newUsers (){
        $mSite = DB::table('m_site')
            ->get();
            
        return view ('hris/masterData/personaliaAddForm',compact('mSite'));
    }
    
    public function postNewUser (Request $userData) {
        $namaLengkap = strtoupper($userData->namaLengkap);
        $userName = $userData->userName;
        $email = $userData->email;
        $hakAkses = $userData->hakAkses;
        $lokasi = $userData->lokasi;
        $levelAdmin = $userData->levelAdmin;
        $password = Hash::make($userData->password);
        $nextId = DB::select("SHOW TABLE STATUS LIKE 'users'")[0]->Auto_increment; 
        
        DB::table('users_area')
            ->insert([
                'user_id'=>$nextId,
                'area_id'=>$lokasi
            ]);
        
        if($levelAdmin <> '0'){
            DB::table('users_role')
                ->insert([
                    'user_id'=>$nextId,
                    'role_code'=>$levelAdmin
                ]);
        }
            
        DB::table('users')
            ->insert([
                'name'=>$namaLengkap,    
                'username'=>$userName,    
                'email'=>$email,    
                'password'=>$password,
                'hakakses'=>$hakAkses
            ]);
        
            
        
    }
    public function delPersonalia ($id) {
        
        DB::table('users_area')
            ->where('user_id',$id)
            ->delete();
            
        DB::table('users_role')
            ->where('user_id',$id)
            ->delete();
            
        DB::table('users')
            ->where('id',$id)
            ->delete();
    }
    
    public function subMenuList ($menuID){
        $submenu = DB::table('m_submenu')
            ->where([
                ['core_system_id',$menuID],
                ['status','1']
                ])
            ->get();
            
        return view ('hris/masterData/selectSubMenu', compact('submenu','menuID'));
    }
    
    public function modalHakAkses ($id){
        $userArea = DB::table('m_site')
            ->select('idm_site','site_name')
            ->get();
            
        $countArea = DB::table('users_area')
            ->where('user_id',$id)
            ->count();
            
        $selectSystem = DB::table('m_public_system')
            ->where('status','1')
            ->get();
            
        $superUser = DB::table('users_role')
            ->where('user_id',$id)
            ->first();
            
        return view ('hris/masterData/userAuthEdit', compact('userArea','id','countArea','selectSystem','superUser'));
    }
    
    public function postEditHakAkses (Request $addAuth){
        $userArea = $addAuth->userArea;
        $userHakAkses = $addAuth->userHakAkses;
        $id = $addAuth->userID;
        
        if($userArea <> '0'){
            DB::table('users_area')
                ->insert([
                    'user_id'=>$id,
                    'area_id'=>$userArea,
                ]);
        }
        
        if($userHakAkses <> '0'){
            DB::table('users_role')
                ->insert([
                    'user_id'=>$id,
                    'role_code'=>$userHakAkses,
                ]);
        }
        
        if($userHakAkses == '3'){
            $nameUser = DB::table('users')
                ->where('id',$reqChange->id)
                ->first();
                
            $countSales = DB::table('m_sales')
                ->count();
            $no = $countSales+1;
            $salesCode = "S".sprintf("%03d",$no);
            
            DB::table('m_sales')
                ->insert([
                    'sales_code'=>$salesCode,
                    'sales_name'=>strtoupper($nameUser->name)
                ]);
        }
    }
    
    public function loadDataHakAkses (Request $reqLoad){
        $id = $reqLoad->id;
        
        $dbUserArea = DB::table('users_area as a')
            ->select('a.*', 'b.site_name','b.idm_site')
            ->leftJoin('m_site as b','a.area_id','=','b.idm_site')
            ->where('a.user_id',$id)
            ->first();
            
        $dbUserAuth = DB::table('users')
            ->where('id',$id)
            ->first();
            
        $dbUserRole = DB::table('users_role')
            ->where('user_id',$id)
            ->first();
            
        $mSite = DB::table('m_site')
            ->get();
            
        $mGAdmin = DB::table('m_group_admin')
            ->get();
        
        $mGroup = DB::table('m_group')
            ->get();
            
        return view ('hris/masterData/userAuthLoad', compact('id','dbUserArea','dbUserAuth','mSite','dbUserRole','mGAdmin','mGroup'));
    }
    
    public function modalEditUser ($id){
        $tbUser = DB::table('users')
            ->where('id',$id)
            ->first();
            
        return view ('hris/masterData/userEditProfile', compact('tbUser','id'));
    }
    
    public function searchData ($keyword){
        $users = DB::table('users as a');
        $users = $users->select('a.*','b.*','c.*','d.site_name');
        $users = $users->leftJoin('users_area as b','a.id','=','b.user_id');
        $users = $users->leftJoin('users_role as c','a.id','=','c.user_id');
        $users = $users->leftJoin('m_site as d','b.area_id','=','d.idm_site');
            if ($keyword <> 0) {
                $users = $users->where('name','LIKE','%'.$keyword.'%');
            }
        $users = $users->get();

        return view ('hris/masterData/personaliaList', compact('users'));
    }
    
    public function changeHakAkses (Request $reqChange){
        DB::table('users')
            ->where('id',$reqChange->id)
            ->update([
                'hakakses'=>$reqChange->changeRole
            ]);
            
        DB::table('users_area')
            ->where('user_id',$reqChange->id)
            ->update([
                    'area_id'=>$reqChange->changeLoc,
                ]
            );
            
        if($reqChange->changeRole == '3'){
            $nameUser = DB::table('users')
                ->where('id',$reqChange->id)
                ->first();
                
            $countSales = DB::table('m_sales')
                ->count();
            $no = $countSales+1;
            $salesCode = "S".sprintf("%03d",$no);
            
            DB::table('m_sales')
                ->insert([
                    'sales_code'=>$salesCode,
                    'sales_name'=>strtoupper($nameUser->name)
                ]);
        }
        
        if($reqChange->changeLevel<>'0'){
            $countLevel = DB::table('users_role')
                ->where('user_id',$reqChange->id)
                ->count();
                
            if($countLevel == '0'){
                DB::table('users_role')
                    ->insert([
                        'user_id'=>$reqChange->id,
                        'role_code'=>$reqChange->changeLevel
                        ]);
            }
            else{
                DB::table('users_role')
                    ->where('user_id',$reqChange->id)
                    ->update([
                        'role_code'=>$reqChange->changeLevel
                        ]);
            }
        }
    }
    
    public function formEditProfile (Request $reqEditPersonalia){
        $namaLengkap = $reqEditPersonalia->namaLengkap;
        $userName = $reqEditPersonalia->userName;
        $email = $reqEditPersonalia->email;
        $id = $reqEditPersonalia->idUser;
        
        DB::table('users')
            ->where('id',$id)
            ->update([
                'name'=>$namaLengkap,
                'username'=>$userName,
                'email'=>$email,
                ]);
    }
    
    public function postHakAksesMenu(Request $hakAksesMenu){
        $menuID = $hakAksesMenu->selectMenu;
        $subMenuId = $hakAksesMenu->subMenu;
        $idUser = $hakAksesMenu->userID;
        
        $existingData = DB::table('users_auth')
            ->where([
                ['users_id',$idUser],
                ['submenu_id',$subMenuId]
                ])
            ->count();
            
        if($existingData == '0'){
            DB::table('users_auth')
                ->insert([
                    'users_id'=>$idUser,
                    'menu_id'=>$menuID,
                    'submenu_id'=>$subMenuId,
                    'auth_create'=>'1',
                    'auth_edit'=>'1',
                    'aut_delete'=>'1',
                    'aut_special'=>'1'
                ]);
        }
    }
    
    public function loadHakAksesMenu($id){
        $hakAksesUser = DB::table('users_auth as a')
            ->leftJoin('m_submenu as b', 'a.submenu_id','=','b.idm_submenu')
            ->leftJoin('m_public_system as c', 'a.menu_id','=','c.idm_system')
            ->where('a.users_id',$id)
            ->get();
            
        return view ('hris/masterData/tableHakAksesMenu', compact('hakAksesUser','id'));
    }
    
    public function deleteAksesMenu ($paramId){
        DB::table('users_auth')
            ->where('idusers_auth',$paramId)
            ->delete();
    }
    
}
