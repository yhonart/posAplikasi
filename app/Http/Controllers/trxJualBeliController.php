<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class trxJualBeliController extends Controller
{
    public function mainTrx(){
        return view('TrxJualBeli/main');
    }

    public function displayfiltering(Request $search)
    {
        $jenisTrx = $search->jenisTrx;
        $fromDate = $search->fromDate;
        $endDate = $search->endDate;

        // echo $jenisTrx."/".$fromDate."/".$endDate;
        switch ($jenisTrx) {
            case '1':
                $dataTrx = DB::table('view_purchase_order')
                    ->whereBetween('purchase_date',[$fromDate, $endDate])
                    ->get();
                break;

            case '2':
                $dataTrx = DB::table('view_billing_action')
                    ->whereBetween('tr_date',[$fromDate, $endDate])
                    ->get();
                break;
            
            default:
                $dataTrx = '0';
                break;
        }
        if ($jenisTrx == '1') {
            return view('TrxJualBeli/displayCariPembelian', compact('dataTrx'));
        }
        else {
            return view('TrxJualBeli/displayCariPenjualan', compact('dataTrx'));
        }
    }

    public function editPenjualan($id){
        $docPenjualan = DB::table('view_billing_action')
            ->where('tr_store_id',$id)
            ->first();
        $bilNumber = $docPenjualan->billing_number;

        

        $itemPenjualan = DB::table('trans_product_list_view')
            ->where([
                ['from_payment_code',$bilNumber],
                ['status','!=','0']
            ])
            ->get();
        return view('TrxJualBeli/listItemPenjualan', compact('itemPenjualan','id','docPenjualan'));
    }

    public function totalBelanja($nomor)
    {
        $sumTrxBelanja = DB::table('trans_product_list_view')
            ->select(DB::raw('SUM(t_pay) as sumpayment'))
            ->where([
                ['from_payment_code',$nomor],
                ['status','!=','0']
            ])
            ->first();

        return view('TrxJualBeli/totalBelanja', compact('sumTrxBelanja'));
    }
}
