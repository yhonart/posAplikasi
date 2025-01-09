<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrxKasKecilController extends Controller
{
    public function kasKecil (){
        return view('TrxKasKecil/main');
    }

    public function laporanKasKecil(){
        $userKasir = DB::table('users')
            ->get();

        return view('TrxKasKecil/laporanKasKecil', compact('userKasir'));
    }

    public function tableLaporan($kasir, $fromDate, $endDate){
        echo $kasir;
        $tablePengeluaran = DB::table('view_trx_kas');
        if ($kasir <> '0' OR $kasir <> "") {
            $tablePengeluaran = $tablePengeluaran->where('kas_persCode',$kasir);
        }
        //$tablePengeluaran = $tablePengeluaran->whereBetween('kas_date',[$fromDate,$endDate]);
        $tablePengeluaran = $tablePengeluaran->get();

        return view('TrxKasKecil/laporanKasKecilTable', compact('tablePengeluaran'));
    }
}
