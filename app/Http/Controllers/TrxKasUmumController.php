<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class TrxKasUmumController extends Controller
{
    public function mainTrx(){
        return view('TrxJualBeli/main');
    }

    public function tambahBiaya()
    {
        return view('TrxJualBeli/modalTambahBiaya');
    }
}
