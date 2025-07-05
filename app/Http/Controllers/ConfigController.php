<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    public function mainConfigCustomer (){
        $compID = Auth::user()->company;
        $dbCustomer = DB::table('m_customers')
            ->where('comp_id',$compID)
            ->get();

        return view("Z_Additional_Admin/AdminConfig/ConfigCustomer", compact('dbCustomer'));
    }
}
