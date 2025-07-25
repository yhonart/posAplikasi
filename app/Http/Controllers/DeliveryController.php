<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $company = Auth::user()->company;

        $listDelivery = DB::table('m_delivery')
            ->where('comp_id',$company)
            ->get();
            
        return view ('Delivery/tableDataDelivery', compact('listDelivery'));
    }
    
    public function postDataDelivery(Request $postReq){
        $codeDelivery = $postReq->codeDelivery;
        $nameDelivery = $postReq->nameDelivery;
        $keterangan = $postReq->keterangan;
        $company = Auth::user()->company;

        if($nameDelivery == ""){
            $msg = array('warning'=>'Field Nama Harus Diisi !');
        }
        else{
            DB::table('m_delivery')
                ->insert([
                    'delivery_code'=>$codeDelivery,
                    'delivery_name'=>$nameDelivery,
                    'disc'=>$keterangan,
                    'comp_id'=>$company
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

    public function mainPengiriman(){      

        return view('Z_Additional_Admin/AdminDelivery/main');
    }

    public function selectDatePengiriman ($date){
        $compID = Auth::user()->company;

        $deliveryRecept = DB::table('tr_delivery_receipt as a')
            ->select('a.*','b.customer_store','b.customer_id')
            ->leftJoin('view_delivery_config as b', 'a.config_id','=','b.delconfig_id')
            ->where([
                ['comp_id',$compID],
                ['delivery_date',$date]
                ])
            ->get();

        return view('Z_Additional_Admin/AdminDelivery/mainTableDelivery', compact('deliveryRecept','date'));
    }
    
}
