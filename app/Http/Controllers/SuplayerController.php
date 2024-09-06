<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuplayerController extends Controller
{
    public function mainIndex (){
        return view ('AssetManagement/MasterData/SupplierIndex');
    }

    public function AddSupliyer (){
        return view ('AssetManagement/MasterData/SupplierModalFormAdd');
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

        DB::table('m_supplier')
            ->insert([
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
            ]);
    }

    public function tableSupplier ($keyWord){
        $supplier = DB::table('m_supplier');
        if($keyWord <> '0'){
            $supplier = $supplier->where('store_name','like','%'.$keyWord.'%');
        }
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
                'updated_date'=>now(),
            ]); 
    }

    public function deleteSupplier ($id){
        DB::table('m_supplier')
            ->where('idm_supplier',$id)
            ->delete();
    }
}
