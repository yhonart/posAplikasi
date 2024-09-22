<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        
        $dataReportInv = DB::table('report_inv');
            if($produk <> '0'){
                $dataReportInv = $dataReportInv->where('product_id',$produk);
            }
            if($lokasi <> '0'){
                $dataReportInv = $dataReportInv->where('location',$lokasi);
            }
            $dataReportInv = $dataReportInv->whereBetween('date_input',[$fromDate, $endDate]);
            $dataReportInv = $dataReportInv->get();

        $dataSaldoAwal = DB::table('report_inv');
            if($produk <> '0'){
                $dataSaldoAwal = $dataSaldoAwal->where('product_id',$produk);
            }
            if($lokasi <> '0'){
                $dataSaldoAwal = $dataSaldoAwal->where('location',$lokasi);
            }
            $dataSaldoAwal = $dataSaldoAwal->whereBetween('date_input',[$fromDate, $endDate]);
            $dataSaldoAwal = $dataSaldoAwal->orderBy('idr_inv','asc');
            $dataSaldoAwal = $dataSaldoAwal->first();

        $mProduct = DB::table('m_product')
            ->select('large_unit_val','medium_unit_val','small_unit_val')
            ->where('idm_data_product',$produk)
            ->first();

        $codeDisplay = '1';
        
        return view ('LapInventory/displayFilter', compact('dataReportInv','codeDisplay','dataSaldoAwal','mProduct'));
    }
    
    public function getFilter($prdID){
        
        $dataReportInv = DB::table('report_inv')
            ->get();

        $mProduct = DB::table('m_product')
            ->select('idm_data_product','large_unit_val','medium_unit_val','small_unit_val')
            ->get();
        
        $codeDisplay = '2'; 
        return view ('LapInventory/displayFilter', compact('dataReportInv','codeDisplay','mProduct'));
    }
    
}
