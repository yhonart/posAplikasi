<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    }
}
