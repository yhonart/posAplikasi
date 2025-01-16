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
        // Hasil Penjualan Per Kasir
        $penjualan = DB::table('tr_store');
        $penjualan = $penjualan->select(DB::raw('SUM(t_pay) as paymentCus'),'tr_date','created_by');
        if ($kasir <> 0) {
            $penjualan = $penjualan->where('created_by', $kasir);
        }
        $penjualan = $penjualan->whereBetween('tr_date',[$fromDate,$endDate]);
        $penjualan = $penjualan->groupBy('tr_date','created_by');
        $penjualan = $penjualan->get(); 

        // Pembelian Supplier Cash
        $pembelian = DB::table('view_purchase_order');
        $pembelian = $pembelian->where([
                ['payment_methode','1'],
                ['status','3']
        ]);        
        $pembelian = $pembelian->whereBetween('delivery_date',[$fromDate,$endDate]);
        $pembelian = $pembelian->get();
        
               

        return view('TrxKasBesar/laporanKasBesarTable', compact('pembelian','penjualan','kasir','fromDate','endDate'));        
    }

    
}
