<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class cpSetupController extends Controller
{
    public function main (){
        return view ('CompanySetup/main');
    }

    public function contentCompany (){
        $userHakAkses = Auth::user()->hakakses;
        $company = Auth::user()->company;
        $location = Auth::user()->location;

        $dataCompany = DB::table('m_company as a');
        $dataCompany = $dataCompany->select('a.*','location_name');
        $dataCompany = $dataCompany->leftJoin('m_company_loc b','b.location_id','=','a.location');
        if ($userHakAkses <> '3') {
            $dataCompany = $dataCompany->where([
                ['idm_company',$company],
                ['location',$location]
            ]);
        }
        $dataCompany = $dataCompany->get();

        return view ('CompanySetup/cp_table', compact('dataCompany','userHakAkses'));
    }

    public function formAddCompany (){
        $selectLocation = DB::table('m_comp_loc')
            ->where('is_delete','0')
            ->get();

        return view ('CompanySetup/companyFormAdd', compact('selectLocation'));
    }

    public function postNewCompany (Request $reqNewCompany){
        $companyName = strtoupper($reqNewCompany->companyName);
        $companyDesc = $reqNewCompany->companyDesc;
        $companyAddress = $reqNewCompany->companyAddress;
        $owner = $reqNewCompany->owner;
        $telefone = "+62".$reqNewCompany->telefone;
        $location = $reqNewCompany->location;

        $countData = DB::table('m_company')
            ->count();

        if ($countData>=1) {
            $msg = array('warning' => '! WARNING, Data nama perusahaan sudah ada, mohon hapus terlebih dahulu.');        
        }
        else{
            DB::table('m_company')
                ->insert([
                    'company_name'=>$companyName,
                    'address'=>$companyAddress,
                    'company_description'=>$companyDesc,
                    'owner'=>$owner,
                    'telefone'=>$telefone,
                    'location'=>$location,
                ]);
            $msg = array('success' => '✔ DATA BERHASIL DIMASUKKAN.');
        }
        return response()->json($msg);
    }

    public function contentSite (){
        return view ('CompanySetup/siteMaintenance');
    }

    public function AddWarehouse(){
        return view ('CompanySetup/siteModalFormAdd');
    }

    public function postDataWarehouse (Request $reqSite){
        DB::table('m_site')
            ->insert([                
                'site_code'=>strtoupper($reqSite->locationCode),
                'site_name'=>$reqSite->locationName,
                'site_address'=>$reqSite->locationAddress,
                'site_city'=>$reqSite->cityName,
                'site_status'=>'1',
            ]);
        $msg = array('success' => '✔ DATA BERHASIL DIMASUKKAN.');
        return response()->json($msg);
    }

    public function warehouseTable (){
        $tableSite = DB::table('m_site')
            ->get();

        $tableCompany = DB::table('m_company')
            ->first();

        return view ('CompanySetup/siteTable', compact('tableSite', 'tableCompany'));
    }

    public function deleteLocWarehouse ($id){
        DB::table('m_site')
            ->where('idm_site',$id)
            ->delete();
    }
    
    public function siteDataUpdate (Request $reqUpdateSite){
        $tableName = $reqUpdateSite->tableName;
        $column = $reqUpdateSite->column;
        $editVal = $reqUpdateSite->editVal;
        $id = $reqUpdateSite->id;
        $tableId = $reqUpdateSite->tableID;
        
        DB::table($tableName)
            ->where($tableId,$id)
            ->update([
                $column => $editVal,    
            ]);
    }

    public function deleteToko (Request $reqDelToko){
        DB::table('m_company')
            ->delete();
    }
}
