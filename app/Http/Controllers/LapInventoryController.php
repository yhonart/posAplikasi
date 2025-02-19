<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LapInventoryController extends Controller
{
    public function checkuserInfo (){
        $userID = Auth::user()->id;
        $cekUserArea = DB::table('users_area AS a')
            ->select('a.area_id','b.site_code','b.site_name')
            ->leftJoin('m_site AS b','a.area_id','=','b.idm_site')
            ->where('a.user_id',$userID)
            ->first();
        if (!empty($cekUserArea)) {
            # code...
            $userAreaID = $cekUserArea->area_id;            
        }
        else {
            $userAreaID = 0;
        }
        return $userAreaID;
    }
    
    public function userApproval (){
        $userID = Auth::user()->id;
        $cekUserGroup = DB::table('users_group')
            ->where([
                ['user_id',$userID],
                ['group_code','1']
            ])
            ->count();
            
        return $cekUserGroup;
    }
    
    public function mainlapInv(){
        $checkArea = $this->checkuserInfo();
        $approval = $this->userApproval();
        return view ('LapInventory/main', compact('checkArea','approval'));
    }
    
    public function formFiltering(){
        $mProduct = DB::table('m_product')
            ->orderBy('product_name','asc')
            ->get();
            
        $mSite = DB::table('m_site')
            ->get();
            
        return view ('LapInventory/formFiltering',compact('mProduct','mSite'));
    }
    
    public function postFilter(Request $postFilter){
        $produk = $postFilter->produk;
        $fromDate = $postFilter->fromDate;
        $endDate = $postFilter->endDate;
        $lokasi = $postFilter->lokasi;
        
        // $dataSaldoAwal = DB::table('report_inv');
        //     if($produk <> '0'){
        //         $dataSaldoAwal = $dataSaldoAwal->where('product_id',$produk);
        //     }
        //     if($lokasi <> '0'){
        //         $dataSaldoAwal = $dataSaldoAwal->where('location',$lokasi);
        //     }
        //     $dataSaldoAwal = $dataSaldoAwal->where('status_trx','4');
        //     $dataSaldoAwal = $dataSaldoAwal->whereBetween('date_input',[$fromDate, $endDate]);
        //     $dataSaldoAwal = $dataSaldoAwal->orderBy('date_input','asc');
        //     $dataSaldoAwal = $dataSaldoAwal->orderBy('idr_inv','asc');
        //     $dataSaldoAwal = $dataSaldoAwal->first();

        $dataReportInv = DB::table('report_inv');
            if($produk <> '0'){
                $dataReportInv = $dataReportInv->where('product_id',$produk);
            }
            if($lokasi <> '0'){
                $dataReportInv = $dataReportInv->where('location',$lokasi);
            }
            $dataReportInv = $dataReportInv->where('status_trx','4');
            $dataReportInv = $dataReportInv->whereBetween('date_input',[$fromDate, $endDate]);
            $dataReportInv = $dataReportInv->orderBy('date_input','asc');
            $dataReportInv = $dataReportInv->orderBy('idr_inv','asc');
            $dataReportInv = $dataReportInv->get();
        
        $sumTrxKeluar = DB::table('report_inv')
            ->select(DB::raw('sum(inv_out) as out'))
            ->where([
                ['status_trx','4'],
                ['inv_in','0'],
                ['product_id',$produk],
                ['location',$lokasi]
            ])
            ->whereBetween('date_input',[$fromDate, $endDate])
            ->orderBy('date_input', 'ascr')
            ->orderBy('ider_inv','asc')
            ->first();
            
        $sumTrxMasuk = DB::table('report_inv')
            ->select(DB::raw('sum(inv_in) as in'))
            ->where([
                ['status_trx','4'],
                ['inv_out','0'],
                ['product_id',$produk],
                ['location',$lokasi]
            ])
            ->whereBetween('date_input',[$fromDate, $endDate])
            ->orderBy('date_input', 'ascr')
            ->orderBy('ider_inv','asc')
            ->first();        

        $mProduct = DB::table('m_product')
            ->select('large_unit_val','medium_unit_val','small_unit_val')
            ->where('idm_data_product',$produk)
            ->first();

        $codeDisplay = '1';

        $lastSaldo = DB::table('view_product_stock')
            ->select('stock')
            ->where([
                ['idm_data_product',$produk],
                ['location_id',$lokasi]
                ])
            ->orderBy('size_code','desc')
            ->first();
        
        return view ('LapInventory/displayFilter', compact('sumTrxMasuk','sumTrxKeluar', 'dataReportInv','codeDisplay','mProduct','lastSaldo','produk','fromDate'));
    }

    public function downloadKartuStock($produk, $fromDate, $endDate, $lokasi){
        
        $dataReportInv = DB::table('report_inv');
            if($produk <> '0'){
                $dataReportInv = $dataReportInv->where('product_id',$produk);
            }
            if($lokasi <> '0'){
                $dataReportInv = $dataReportInv->where('location',$lokasi);
            }
            $dataReportInv = $dataReportInv->where('status_trx','4');
            $dataReportInv = $dataReportInv->whereBetween('date_input',[$fromDate, $endDate]);
            $dataReportInv = $dataReportInv->orderBy('date_input','asc');
            $dataReportInv = $dataReportInv->orderBy('idr_inv','desc');
            $dataReportInv = $dataReportInv->get();

        $dataSaldoAwal = DB::table('report_inv');
            if($produk <> '0'){
                $dataSaldoAwal = $dataSaldoAwal->where('product_id',$produk);
            }
            if($lokasi <> '0'){
                $dataSaldoAwal = $dataSaldoAwal->where('location',$lokasi);
            }
            $dataSaldoAwal = $dataSaldoAwal->where('status_trx','4');
            $dataSaldoAwal = $dataSaldoAwal->whereBetween('date_input',[$fromDate, $endDate]);
            $dataSaldoAwal = $dataSaldoAwal->orderBy('date_input','asc');
            $dataSaldoAwal = $dataSaldoAwal->orderBy('idr_inv','desc');
            $dataSaldoAwal = $dataSaldoAwal->first();

        $mProduct = DB::table('m_product')
            ->where('idm_data_product',$produk)
            ->first();

        $locData = DB::table('m_site')
            ->where('idm_site',$lokasi)
            ->first();

        $codeDisplay = '1';

        $pdf = PDF::loadview('LapInventory/displayKartuStok', compact('dataReportInv','codeDisplay','dataSaldoAwal','mProduct','locData','fromDate','endDate'))->setPaper("A4", 'portrait');
		return $pdf->stream();     
    }
    
    public function getFilter($produk){
        $today = date("Y-m-d");

        $dataReportInv = DB::table('report_inv')
            ->where([
                ['status_trx','4'],
                ['date_input',$today]
                ])
            ->orderBy('idr_inv','asc')
            ->get();

        $mProduct = DB::table('m_product')
            ->select('idm_data_product','large_unit_val','medium_unit_val','small_unit_val')
            ->get();
        
        $codeDisplay = '2'; 
        return view ('LapInventory/displayFilter', compact('dataReportInv','codeDisplay','mProduct','produk'));
    }
    
}
