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
    
    //Set Metod Pembayaran
    public function setPembayaran(){
        return view('globalSetting/setMetodPembayaran');
    }

    public function tableSetPembayaran (){
        $mPayMethod = DB::table('m_payment_method')
            ->orderBy('method_name','asc')
            ->get();

        $mAccountBank = DB::table('m_company_payment')
            ->get();

        return view('globalSetting/setMetodPembayaranList', compact('mPayMethod','mAccountBank'));
    }

    public function newPembayaran(){
        return view('globalSetting/setMetodPembayaranAdd');
    }

    public function postPembayaran(Request $reqPostPmb){
        DB::table('m_payment_method')
            ->insert([
                'method_name'=> $reqPostPmb->mPembayaran,
                'category'=>"CASH",
                'status'=>'1'
            ]);
    }

    public function newAkunBank(){
        return view('globalSetting/setAkunPembayaranAdd');
    }
    
    public function postnewAkunBank(Request $reqAkunBank){
        DB::table('m_company_payment')
            ->insert([
                'core_payment_method'=>'4',
                'bank_code'=>strtoupper($reqAkunBank->kodeBank),
                'bank_name'=>strtoupper($reqAkunBank->namaBank),
                'account_number'=>$reqAkunBank->noRek,
                'account_name'=>strtoupper($reqAkunBank->namaAkun),
            ]);
    }
    public function editAkun($id){
        $tbEditAkun = DB::table('m_company_payment')
            ->where('idm_payment',$id)
            ->first();

        return view('globalSetting/setAkunPembayaranEdit', compact('tbEditAkun','id'));
    }

    public function postEditAkun(Request $reqEditAkun){
        DB::table('m_company_payment')
            ->where('idm_payment',$reqEditAkun->idAkun)
            ->update([
                'core_payment_method'=>'4',
                'bank_code'=>strtoupper($reqEditAkun->kodeBank),
                'bank_name'=>strtoupper($reqEditAkun->namaBank),
                'account_number'=>$reqEditAkun->noRek,
                'account_name'=>strtoupper($reqEditAkun->namaAkun),
            ]);
    }

    public function deleteAkun($id){
        DB::table('m_company_payment')
            ->where('idm_payment',$id)
            ->delete();
    }
}
