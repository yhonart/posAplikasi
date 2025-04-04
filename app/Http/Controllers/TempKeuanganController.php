<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TempKeuanganController extends Controller
{
    public function kasBesarPenjualan($nominal, $createBy, $trDate)
    {        
        $dateNoww = date("Y-m-d");
        $company = Auth::user()->company;

        // count user input
        $countKasBesar = DB::table('lap_kas_besar')
            ->where([
                ['create_by',$createBy],
                ['trx_date',$trDate]
            ])
            ->count();
            
        $description = "Penjualan ".$createBy;
        
        // check pembayaran menggunakan 2 cara pembayaran.
        $penjualan = DB::table('view_trx_method');
        $penjualan = $penjualan->select(DB::raw('SUM(nominal) as paymentCus'),'created_by'); 
        $penjualan = $penjualan->where([
            ['status_by_store','>=','3'],
            ['created_by',$createBy],
            ['date_trx',$trDate]
        ]);
        $penjualan = $penjualan->groupBy('created_by');
        $penjualan = $penjualan->first(); 

        if (!empty($penjualan)) {
            $updateNominal = $penjualan->paymentCus;
        }
        else {
            $updateNominal = $nominal;
        }

        if ($countKasBesar == '0') {            
            DB::table('lap_kas_besar')
                ->insert([
                    'description'=>$description,
                    'create_by' => $createBy,
                    'trx_date' => $trDate,
                    'debit' => $updateNominal,
                    'kredit' => '0',
                    'saldo' => $updateNominal,
                    'trx_code' => '1',
                    'comp_id' => $company
                ]);
        }
        else {
            DB::table('lap_kas_besar')
                ->where([
                    ['create_by',$createBy],
                    ['trx_date',$trDate],
                    ['trx_code','1']
                ])
                ->update([
                    'debit' => $updateNominal,                    
                    'saldo' => $updateNominal,
                    'trx_code' => '1',
                    'comp_id' => $company
                ]);
        }
    }

    public function kasBesarPembelian ($nominal, $createBy, $trxNumber)
    {
        $company = Auth::user()->company;
        // Cek ketersediaan data 
        $countPembelian = DB::table('lap_kas_besar')
            ->where('trx_number',$trxNumber)
            ->count();

        if ($countPembelian == '0') {
            $getPurchase = DB::table('view_purchase_order')
                ->where('purchase_number',$trxNumber)
                ->first();
            $dateTrx = $getPurchase->delivery_date;
            $description = "Pembayaran ". $getPurchase->store_name ." No.". $getPurchase->purchase_number;
                DB::table('lap_kas_besar')
                    ->insert([
                        'description'=>$description,
                        'create_by'=>$createBy,
                        'trx_date'=>$dateTrx,
                        'debit'=>'0',
                        'kredit'=>$nominal,
                        'saldo'=>'0',
                        'created_date'=>now(),
                        'trx_number'=>$trxNumber,
                        'trx_code'=>'2',
                        'comp_id' => $company
                    ]);
        }
        else {
             DB::table('lap_kas_besar')
                ->where('trx_number',$trxNumber)
                ->update([
                    'kredit'=>$nominal,
                    'comp_id' => $company
                ]);
        }
    }
}
