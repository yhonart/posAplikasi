<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{    
    // CEK INFORMASI USER TERKAIT AREA KERJA YANG TERDAFTAR PADA SISTEM
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
    
    public function mainDashboard (){
        $datenow = date("Y-m-d");
        $hakAkses = Auth::user()->hakakses;
        $userID = Auth::user()->id;

        $dbUser = DB::table('users_role as a')
            ->select('a.*','b.name','b.email')
            ->leftJoin('users as b', 'a.user_id','=','b.id')
            ->where('a.user_id',$userID)
            ->first();

        $userRole = $dbUser->role_code;
        echo "Role : ".$userRole;

        $countPenjualan = DB::table('tr_store')
            ->where([
                ['tr_date',$datenow]
                ])
            ->count();
            
        $countProcess = DB::table('tr_store')
            ->where([
                ['tr_date',$datenow],
                ['status','2']
                ])
            ->count();
            
        $countKredit = DB::table('tr_store')
            ->where([
                ['tr_date',$datenow],
                ['status','3']
                ])
            ->count();
            
        $countcompleted = DB::table('tr_store')
            ->where([
                ['tr_date',$datenow],
                ['status','4']
                ])
            ->count();
        if ($userRole == '1') {
            return view ('Dashboard/DashboardTransaksi', compact('countPenjualan','countProcess','countKredit','countcompleted','dbUser'));
        }
        else {
            return view('Dashboard/WelcomeHome', compact('dbUser'));
        }
            
    }
    
    public function lodaDataTransaksi ($fromDate, $endDate){
        // echo $fromDate."/".$endDate;
        $thisPeriode = date("m-Y");
        
        $lastTrxAll = DB::table('trx_record_view')
            ->select(DB::raw('SUM(total_struk) as totalAll'))
            ->where('status_by_store','>=','3')
            ->whereBetween('date_trx',[$fromDate, $endDate])
            ->first();
            
        $countTransaksi = DB::table('trx_record_view')
            ->where('status_by_store','>=','3')
            ->whereBetween('date_trx',[$fromDate, $endDate])
            ->count();
            
        $lastTrxTransfer = DB::table('tr_payment_record')
            ->select(DB::raw('SUM(total_payment) as totalPayment'))
            ->whereBetween('date_trx',[$fromDate, $endDate])
            ->where('trx_method','4')
            ->first();
            
        $lastTrxonProcess = DB::table('view_billing_action')
            ->whereBetween('tr_date',[$fromDate, $endDate])
            ->where('status','1')
            ->count();
            
        $lastTrxKredit = DB::table('tr_kredit')
            ->whereBetween('created_at',[$fromDate, $endDate])
            ->count();
            
        $garpPenjualan = DB::table('tr_payment_record')
            ->select(DB::raw('SUM(total_payment) as totalPayment'), 'date_trx')
            ->where(DB::raw('DATE_FORMAT(date_trx,"%m-%Y")'),$thisPeriode)
            ->groupBy('date_trx')
            ->get();
            
        $totalTransaksi = DB::table('view_billing_action')
            ->where([
                ['is_return','!=','1']
                ])
            ->whereBetween('tr_date',[$fromDate, $endDate])
            ->count();
            
        return view ('Dashboard/DashboardLoadTrx', compact('countTransaksi','lastTrxKredit','lastTrxTransfer','lastTrxonProcess','fromDate','endDate','garpPenjualan','lastTrxAll','totalTransaksi'));
    }
    
    public function onClickDetail (Request $reqPostOnClick){
        $condition = $reqPostOnClick->condition;
        $fromDate = $reqPostOnClick->fromDate;
        $endDate = $reqPostOnClick->endDate;
        
        // echo $condition."-".$fromDate."-".$endDate;
        
        if($condition == "alltrx"){
            $allCondition = DB::table('view_trx_method')
                ->whereBetween('date_trx',[$fromDate, $endDate])
                ->where('status_by_store','>=','3')
                ->orderBy('core_id_trx','asc')
                ->get();
        }
        elseif($condition == "onprocess"){
            $allCondition = DB::table('view_billing_action')
                ->whereBetween('tr_date',[$fromDate, $endDate])
                ->where('status','1')
                ->get();
        }
        elseif($condition == "kredit"){
            $allCondition = DB::table('view_customer_kredit')
                ->whereBetween('created_at',[$fromDate, $endDate])
                ->get();
        }
        elseif($condition == "allSummery"){
            $allCondition = DB::table('view_billing_action')
                ->where([
                    ['is_return','!=','1']
                    ])
                ->whereBetween('tr_date',[$fromDate, $endDate])
                ->get();
        }
        
        return view ('Dashboard/DashboardLoadOnClick', compact('allCondition','condition','fromDate','endDate'));
    }

    public function modalLogTrx ($noBill)
    {
        $dbSelectTrx = DB::table('trans_product_list_view')
            ->where('from_payment_code',$noBill)
            ->get();

        return view('Dashboard/modalDashListTrx', compact('dbSelectTrx','noBill'));
    }    
    
    public function postChangesStatus (Request $reqPostChanges)
    {
        $statusChange = $reqPostChanges->changeStatus;
        $splitChange = explode("|",$statusChange);
        $status = $splitChange[0];
        $id = $splitChange[1];
        $trxCode = $reqPostChanges->trxCode;

        if ($status == '4') {
            DB::table('tr_store_prod_list')
                ->where('list_id',$id)
                ->update([
                    'status'=>$status,
                    'is_delete'=>'0'
                ]);
        }
        else {
            DB::table('tr_store_prod_list')
                ->where('list_id',$id)
                ->update([
                    'status'=>$status,
                    'is_delete'=>'1'
                ]);
        }
    }
}
