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
    public function tableKurir(Request $request){
        $today = Carbon::now()->dayOfWeekIso; // Get the current day of the week
        $selectedDay = $request->input('day', $today); // Get the selected day from the request, default to today

        $dayNames = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
        
        $hari =  $dayNames[$selectedDay];

        $listPengiriman = DB::table('view_delivery_config')
            ->where('day_freq',$hari)
            ->get();

        $getProductOrder = DB::table('view_product_order_customer')
            ->get();

        return view('DeliveryJob/tableSchedule', compact('listPengiriman','getProductOrder'));        
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

    public function postPenerimaan(Request $request){
        $request->validate([
            'image' => 'required', // Data base64 dari foto
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        try {
           // Ambil data base64 dari request
            $imageData = $request->input('image');
            // Pisahkan bagian "data:image/jpeg;base64," dari data sebenarnya
            list($type, $imageData) = explode(';', $imageData);
            list(, $imageData) = explode(',', $imageData);
            $imageData = base64_decode($imageData);

            // Buat nama file unik
            $filename = uniqid() . '.jpeg';
            $path = 'public/images/Delivery/' . $filename; // Path penyimpanan di storage
            // Simpan file ke storage
            Storage::put($path, $imageData);

            DB::table('delivery_receipt')->insert([
                'config_id' => $request->input('configID'),
                'customer_code' => $request->input('customerCode'),
                'image' => $filename, // Simpan nama file
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'created_by' => Auth::user()->name,
                'created_at' => Carbon::now(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan penerimaan: ' . $e->getMessage()], 500);
        }
        return response()->json(['success' => true, 'message' => 'Penerimaan berhasil disimpan']);
    }
}
