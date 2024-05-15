<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class cpSetupController extends Controller
{
    public function main (){
        return view ('CompanySetup/main');
    }

    public function contentCompany (){
        $dataCompany = DB::table('m_company')
            ->first();

        $countCompany = DB::table('m_company')
            ->count();

        return view ('CompanySetup/cp_table', compact('dataCompany','countCompany'));
    }

    public function formAddCompany (){
        return view ('CompanySetup/companyFormAdd');
    }

    public function postNewCompany (Request $reqNewCompany){
        $companyName = strtoupper($reqNewCompany->companyName);
        $companyDesc = $reqNewCompany->companyDesc;
        $companyAddress = $reqNewCompany->companyAddress;
        $owner = $reqNewCompany->owner;
        $telefone = "+62".$reqNewCompany->telefone;

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
}
