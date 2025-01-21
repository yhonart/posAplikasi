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
}
