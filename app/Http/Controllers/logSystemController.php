<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class logSystemController extends Controller
{
    public function logSystem()
    {
        $idPelanggan = '1651';
        $nominalBayar = '12000000';
        $hutang = DB::table('tr_kredit')
            ->where('from_member_id',$idPelanggan)
            ->get();
        
        return view('Testing/testing_satu', compact('hutang','nominalBayar'));
    }
}
