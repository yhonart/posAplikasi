<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class ZAdditionalPosController extends Controller
{
    public function checkuserInfo()
    {
        $userID = Auth::user()->id;
        $cekUserArea = DB::table('view_user_work_area')
            ->select('area_id')
            ->where('id', $userID)
            ->first();

        if (!empty($cekUserArea)) {
            $userAreaID = $cekUserArea->area_id;
        } else {
            $userAreaID = 0;
        }

        return $userAreaID;
    }
    
    public function getInfoNumber()
    {
        $username = Auth::user()->name;
        $area = $this->checkuserInfo();
        $hakAkses = Auth::user()->hakakses;
        $dateDB = date("Y-m-d");
        $company = Auth::user()->company;

        //Cek apakah ada nomor transaksi yang di return
        $countBill = DB::table('tr_store')
            ->where([
                ['status','1'],
                ['comp_id',$company],
                ['created_by',$username],
                ['tr_date', $dateDB]
            ])
            ->count();

        if ($countBill == '0') { // Jika Tidak Ada
            $countOfBill = DB::table('tr_store')
                ->where([
                    ['comp_id',$company],
                    ['tr_date', $dateDB],
                    ['created_by',$username]
                ])
                ->count();
            $newBillNumber = $countOfBill + 1;
            $newBillNumber = str_pad($newBillNumber, 5, '0', STR_PAD_LEFT);
        }
        else {
            $getBillNumber = DB::table('tr_store')
                ->select('billing_number')
                ->where([
                    ['status','1'],
                    ['comp_id',$company],
                    ['tr_date', $dateDB],
                    ['created_by',$username]
                ])
                ->orderBy('billing_number', 'DESC')
                ->first();
            $newBillNumber = $getBillNumber->billing_number;
        }

        return $newBillNumber;
    }   

    public function AdditionalProductList()
    {
        $billNumber = $this->getInfoNumber();
        return view('Cashier/z_additional_product_list', compact('billNumber'));
    }
}
