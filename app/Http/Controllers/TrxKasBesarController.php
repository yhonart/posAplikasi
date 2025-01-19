<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Dd;

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
        // Hasil Penjualan Per Kasir
        $penjualan = DB::table('view_trx_method');
        $penjualan = $penjualan->select(DB::raw('SUM(nominal) as paymentCus'),'date_trx','created_by');
        if ($kasir <> 0) {
            $penjualan = $penjualan->where('created_by', $kasir);
        }
        $penjualan = $penjualan->where('status_by_store','>=','3');
        $penjualan = $penjualan->whereBetween('date_trx',[$fromDate,$endDate]);
        $penjualan = $penjualan->groupBy('date_trx','created_by');
        $penjualan = $penjualan->get(); 

        // Pembelian Supplier Cash
        $pembelian = DB::table('view_purchase_order');
        $pembelian = $pembelian->where([
                ['payment_methode','1'],
                ['status','3']
        ]);        
        $pembelian = $pembelian->whereBetween('delivery_date',[$fromDate,$endDate]);
        $pembelian = $pembelian->get();
        
        //DB Reumbers
        
               

        return view('TrxKasBesar/laporanKasBesarTable', compact('pembelian','penjualan','kasir','fromDate','endDate'));        
    }

    public function detailPenjualan($date, $akun)
    {
        $dbDetail = DB::table('view_billing_action')
            ->where([
                ['tr_date',$date],
                ['created_by',$akun],
                ['trx_method','1']
            ])
            ->get();

        return view('TrxKasBesar/detailPenjualan', compact('dbDetail','date','akun'));        
    }

    
}
