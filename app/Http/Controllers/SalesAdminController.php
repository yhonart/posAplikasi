<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SalesAdminController extends Controller
{
    public function mainDashboard (){

    }

    public function mainProduct (){
        return view('Z_Additional_Admin/AdminMasterData/mainProduct');
    }

    public function mainCustomer (){

    }

    public function mainSalesOrder (){

    }

    public function mainDelivery (){

    }
}
