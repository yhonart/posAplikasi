<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrxKasKecilController extends Controller
{
    public function kasKecil (){
        return view('TrxKasKecil/main');
    }
}
