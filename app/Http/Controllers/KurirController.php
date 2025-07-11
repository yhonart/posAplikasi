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
        // $today = Carbon::now()->dayOfWeekIso;
        $today = Carbon::parse($date)->dayOfWeekIso; // Use the provided date to determine the day of the week
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
        
        $hari =  $dayNames[$today];

        $listPengiriman = DB::table('view_delivery_config')
            ->where('day_freq',$hari)
            ->get();

        $getProductOrder = DB::table('view_product_order_customer')
            ->get();

        return view('DeliveryJob/tableSchedule', compact('listPengiriman','getProductOrder'));        
    }

    public function penerimaan($configID, $customerCode){
        return view('DeliveryJob/modalPenerimaan', compact('configID','customerCode'));
    }
}
