<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KurirController extends Controller
{
    public function mainKurir(){
        return view('DeliveryJob/mainDelivery');
    }
}
