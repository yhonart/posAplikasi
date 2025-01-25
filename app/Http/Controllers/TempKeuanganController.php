<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TempKeuanganController extends Controller
{
    public function kasBesarPenjualan($nominal, $createBy)
    {        
        $dateNoww = date("Y-m-d");
        // count user input
        $countKasBesar = DB::table('lap_kas_besar')
            ->where([
                ['create_by',$createBy],
                ['trx_date',$dateNoww]
            ])
            ->count();
            
        $kredit = DB::table('lap_kas_besar')
            ->select('debit','kredit','saldo')
            ->where([
                ['create_by',$createBy],
                ['trx_date',$dateNoww],
                ['trx_code','1']
            ])
            ->first();
        $description = "Penjualan ".$createBy;
        if ($countKasBesar == '0') {            
            DB::table('lap_kas_besar')
                ->insert([
                    'description'=>$description,
                    'create_by' => $createBy,
                    'trx_date' => $dateNoww,
                    'debit' => $nominal,
                    'kredit' => '0',
                    'saldo' => $nominal,
                    'trx_code' => '1'
                ]);
        }
        else {
            $lastKredit = $kredit->kredit;
            $addKredit = $nominal + $lastKredit;
            DB::table('lap_kas_besar')
                ->where([
                    ['create_by',$createBy],
                    ['trx_date',$dateNoww],
                    ['trx_code','1']
                ])
                ->update([
                    'debit' => $addKredit,                    
                    'saldo' => $addKredit,
                    'trx_code' => '1'
                ]);
        }
    }

    public function kasBesarPembelian ($nominal, $createBy, $trxNumber)
    {
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
                        'trx_code'=>'2'
                    ]);
        }
        else {
             DB::table('lap_kas_besar')
                ->where('trx_number',$trxNumber)
                ->update([
                    'kredit'=>$nominal
                ]);
        }
    }
}
