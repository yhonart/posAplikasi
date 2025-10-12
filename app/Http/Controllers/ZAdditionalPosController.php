<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class ZAdditionalPosController extends Controller
{
    public function getInfoNumber()
    {
        $username = Auth::user()->name;
        $area = $this->checkuserInfo();
        $hakAkses = Auth::user()->hakakses;
        $dateDB = date("Y-m-d");
        $company = Auth::user()->company;

        //Cek apakah ada nomor transaksi yang di return
        $countReturnNumber = DB::table('tr_store')
            ->where([
                ['status','1'],
                ['return_by',$username],
                ['comp_id',$company]
            ])
            ->count();

        if ($countReturnNumber == '0') { // Jika Tidak Ada
            $billNumbering = DB::table("tr_store")
                ->where([
                    ['store_id', $area],
                    ['status', '1'],
                    ['created_by', $username],
                    ['comp_id',$company]
                ])
                ->first();
        }
        else {
            $billNumbering = DB::table("tr_store")
                ->where([
                    ['store_id', $area],
                    ['status', '1'],
                    ['return_by', $username],
                    ['comp_id',$company]
                ])
                ->first();
        }

        if (!empty($billNumbering)) {
            $nomorstruk = $billNumbering->billing_number;
        } else {
            $nomorstruk = "0";
        }
        
        return $nomorstruk;
    }   

    public function AdditionalProductList()
    {
        $billNumber = $this->getInfoNumber();
        return view('Cashier/z_additional_product_list', compact('billNumber'));
    }
}
