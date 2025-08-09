<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class setLokasiController extends Controller
{
    public function main (){
        return view('setLocation/main');
    }
}
