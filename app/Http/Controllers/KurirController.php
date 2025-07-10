<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KurirController extends Controller
{
    public function mainKurir(){        
        return view('DeliveryJob/mainDelivery');
    }

    public function funcDate ($date){
        $today = Carbon::now()->dayOfWeekIso;
        // $selectedDay = $request->input('day', $today);
        $dayNames = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
        
        echo $dayNames[$today];
    }
}
