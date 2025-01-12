<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrxKasBesarController extends Controller
{
    public function kasBesar(){
        return view('TrxKasBesar/main');
    }

    public function laporanKasBesar(){
        $userKasir = DB::table('users')
            ->get();

        return view('TrxKasBesar/laporanKasBesar', compact('userKasir'));
    }

    public function tableLaporan ($kasir, $fromDate, $endDate){
        $pembelian = DB::table('purchase_order')
            ->where([
                ['payment_methode','1'],
                ['status','3']
            ])
            ->whereBetween('delivery_date',[$fromDate,$endDate])
            ->get();
        
        $penjualan = DB::table('tr_payment_record as a')
            ->select(DB::raw("SUM(a.total_payment) as payment"),'b.created_by','a.date_trx')
            ->leftJoin('tr_store as b','a.trx_code','=','b.billing_number')
            ->where([
                ['trx_method','8']
            ])
            ->whereBetween('date_trx',[$fromDate,$endDate])
            ->groupBy('b.created_by')
            ->groupBy('b.date_trx')
            ->get();

        return view('TrxKasBesar/laporanKasBesarTable', compact('pembelian','penjualan'));        
    }

    
}
