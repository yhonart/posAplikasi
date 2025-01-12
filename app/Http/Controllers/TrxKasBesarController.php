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
        echo $kasir."/".$fromDate."/".$endDate;
        $pembelian = DB::table('purchase_order')
            ->where([
                ['payment_methode','1'],
                ['status','3']
            ])
            ->whereBetween('delivery_date',[$fromDate,$endDate])
            ->get();
        
        $penjualan = DB::table('tr_store')
                ->select(DB::raw('SUM(t_pay) as paymentCus'), 'tr_date','created_by')
                ->whereBetween('tr_date',[$fromDate,$endDate])
                ->groupBy('created_by')
                ->groupBy('tr_date')
                ->get();        

        return view('TrxKasBesar/laporanKasBesarTable', compact('pembelian','penjualan','kasir','fromDate','endDate'));        
    }

    
}
