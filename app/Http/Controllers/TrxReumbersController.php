<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxReumbersController extends Controller
{
    public function trxReumbers ()
    {
        return view('TrxReumbers/main');
    }

    public function addReumbers ()
    {
        return view('TrxReumbers/addReumbers');
    }
    
    public function tableReumbers ()
    {
        $tbReumbers = DB::table('tr_reumbersment')
            ->orderBy('reumbers_id','desc')
            ->get();

        return view('TrxReumbers/tableReumbers',compact('tbReumbers'));
    }
}
