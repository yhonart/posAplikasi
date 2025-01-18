<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrxReumbersController extends Controller
{
    public function trxReumbers ()
    {
        return view('TrxReumbers/main');
    }

    public function addReumbers ()
    {
        $dateNow = date('Y-m-d');

        $mStaff = DB::table('m_sales')
            ->where('sales_status','1')
            ->get();
        
        $mAdmin = DB::table('users')
            ->get();

        $akunTrs = DB::table('view_trx_kas')
            ->get();

        return view('TrxReumbers/addReumbers', compact('mStaff','mAdmin','akunTrs'));
    }

    public function postTransaksiReumbers(Request $reqPosting)
    {
        $nomor = $reqPosting->nomor;
        $keterangan = $reqPosting->keterangan;
        $akunUser = explode("|",$reqPosting->akunUser);
        $typeReumbers = explode("|",$reqPosting->typeReumbers);
        $fromAkunDana = $reqPosting->fromAkunDana;
        $nominal = str_replace(".","",$reqPosting->nominal);

        $idUser = $akunUser[0];
        $persname = $akunUser[1];
        $typeCode = $typeReumbers[0];
        $typeName = $typeReumbers[1];

        $creator = Auth::user()->name;

        DB::table('tr_reumbersment')
            ->insert([
                'reumbers_no'=>$nomor,
                'description'=>$keterangan,
                'persno_id'=>$idUser,
                'persname'=>$persname,
                'from_akun'=>$fromAkunDana,
                'type_reumbers'=>$typeCode,
                'type_description'=>$typeName,
                'create_date'=>now(),
                'create_by'=>$creator,
                'status'=>'1',
                'reumbers_date'=>now(),
                'nominal'=>$nominal,
            ]);
    }
    
    public function tableReumbers ()
    {
        $tbReumbers = DB::table('tr_reumbersment')
            ->orderBy('reumbers_id','desc')
            ->get();

        return view('TrxReumbers/tableReumbers',compact('tbReumbers'));
    }
}
