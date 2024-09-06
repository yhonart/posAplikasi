<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function mainDelivery (){
        return view ('Delivery/main');
    }
    
    public function formEntryDelivery(){
        return view ('Delivery/newFormDelivery');
    }
    public function tableDataDelivery(){
        $listDelivery = DB::table('m_delivery')
            ->get();
            
        return view ('Delivery/tableDataDelivery', compact('listDelivery'));
    }
    
    public function postDataDelivery(Request $postReq){
        $codeDelivery = $postReq->codeDelivery;
        $nameDelivery = $postReq->nameDelivery;
        $keterangan = $postReq->keterangan;
        
        if($nameDelivery == ""){
            $msg = array('warning'=>'Field Nama Harus Diisi !');
        }
        else{
            DB::table('m_delivery')
                ->insert([
                    'delivery_code'=>$codeDelivery,
                    'delivery_name'=>$nameDelivery,
                    'disc'=>$keterangan,
                ]);
            $msg = array('success'=>$nameDelivery.' Berhasil ditambahkan');
        }
        return response()->json($msg);
    }
    
    public function deleteData($idDel){
        DB::table('m_delivery')
            ->where('idm_delivery',$idDel)
            ->delete();
    }
    
}
