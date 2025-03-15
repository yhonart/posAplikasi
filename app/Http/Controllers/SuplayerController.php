<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuplayerController extends Controller
{
    public function getCodeSupplier (){
        $company = Auth::user()->company;
        //cek jumlah supplier dalam company yang sama.
        $countSupByComp = DB::table('m_supplier')
            ->where('comp_id',$company)
            ->count();

        $no = $countSupByComp + 1;
        $code = "SUP.".sprintf("%07d", $no);

        return $code;
    }
    public function mainIndex (){
        return view ('AssetManagement/MasterData/SupplierIndex');
    }

    public function AddSupliyer (){
        $kodeSupplier = $this->getCodeSupplier();
        return view ('AssetManagement/MasterData/SupplierModalFormAdd', compact('kodeSupplier'));
    }

    public function PostNewSupplier (Request $reqPostSup){
        $suppName = strtoupper($reqPostSup->Supplier);
        $suppAddress = $reqPostSup->Address;
        $suppCity = strtoupper($reqPostSup->City);
        $suppPhone = $reqPostSup->Phone;
        $suppEmail = $reqPostSup->Email;
        $suppSchedule = $reqPostSup->Schedule;
        $supppaymentType = $reqPostSup->paymentType;
        $suppSalesman = $reqPostSup->Salesman;
        $suppLevel = $reqPostSup->Level;
        $suppStatus = $reqPostSup->Status;
        $kode = $reqPostSup->kode;
        $company = Auth::user()->company;

        DB::table('m_supplier')
            ->insert([
                'supplier_code'=> $kode,
                'store_name'=> $suppName,
                'phone_number'=>$suppPhone,
                'address'=>$suppAddress,
                'city'=>$suppCity,
                'email'=>$suppEmail,
                'schedule_delivery'=>$suppSchedule,
                'payment_type'=>$supppaymentType,
                'salesman'=>$suppSalesman,
                'level'=>$suppLevel,
                'supplier_status'=>$suppStatus,
                'created_at'=>now(),
                'comp_id'=>$company
            ]);
    }

    public function tableSupplier ($keyWord){
        $company = Auth::user()->company;

        $supplier = DB::table('m_supplier');
        if($keyWord <> '0'){
            $supplier = $supplier->where('store_name','like','%'.$keyWord.'%');
        }
            $supplier = $supplier->where('comp_id',$company);
            $supplier = $supplier->orderBy('store_name','asc');
            $supplier = $supplier->get();
        
        return view ('AssetManagement/MasterData/SupplierTableData', compact('supplier'));        
    }

    public function editSupplier ($id){
        $editSupplier = DB::table('m_supplier')
            ->where('idm_supplier',$id)
            ->first();

        return view ('AssetManagement/MasterData/SupplierModalFormEdit', compact('editSupplier','id'));
    }

    public function postEditSupplier (Request $reqPostEditSup){
        $suppName = strtoupper($reqPostEditSup->Supplier);
        $suppAddress = $reqPostEditSup->Address;
        $suppCity = strtoupper($reqPostEditSup->City);
        $suppPhone = $reqPostEditSup->Phone;
        $suppEmail = $reqPostEditSup->Email;
        $suppSchedule = $reqPostEditSup->Schedule;
        $supppaymentType = $reqPostEditSup->paymentType;
        $suppSalesman = $reqPostEditSup->Salesman;
        $suppLevel = $reqPostEditSup->Level;
        $suppStatus = $reqPostEditSup->Status;
        $supID = $reqPostEditSup->suppID;

        DB::table('m_supplier')
            ->where('idm_supplier',$supID)
            ->update([
                'store_name'=> $suppName,
                'phone_number'=>$suppPhone,
                'address'=>$suppAddress,
                'city'=>$suppCity,
                'email'=>$suppEmail,
                'schedule_delivery'=>$suppSchedule,
                'payment_type'=>$supppaymentType,
                'salesman'=>$suppSalesman,
                'level'=>$suppLevel,
                'supplier_status'=>$suppStatus,
                'updated_at'=>now(),
            ]); 
    }

    public function deleteSupplier ($id){
        DB::table('m_supplier')
            ->where('idm_supplier',$id)
            ->delete();
    }

    public function downloadExcelSupplier(){
        $masterSupplier = DB::table('m_supplier')
            ->get();

        return view ('AssetManagement/MasterData/SupplierDownloadExcel', compact('masterSupplier'));
    }
}
