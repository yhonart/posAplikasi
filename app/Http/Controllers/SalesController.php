<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SalesController extends Controller
{
    public function main(){

    }

    public function daftarKunjungan (){

    }

    public function formKunjungan (){
        return view('Sales/formKunjungan');
    }

    public function salesDasboard (){
        
    }
}
