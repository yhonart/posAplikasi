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

        $userKasir = DB::table('users')
            // ->where('hakakses','2')
            ->get();
        if ($userRole == '1') {
            return view ('Dashboard/DashboardTransaksi', compact('countPenjualan','countProcess','countKredit','countcompleted','dbUser','userKasir'));
        }
        else {
            return view('Dashboard/WelcomeHome', compact('dbUser'));
        }
            
    }
    
    public function lodaDataTransaksi ($fromDate, $endDate, $kasir){
        // echo $fromDate."/".$endDate;
        $thisPeriode = date("m-Y");
        
        $lastTrxAll = DB::table('trx_record_view');
        $lastTrxAll = $lastTrxAll->select(DB::raw('SUM(total_struk) as totalAll'));
        if ($kasir <> '0') {
            $lastTrxAll=$lastTrxAll->where('created_by',$kasir);
        }
        $lastTrxAll=$lastTrxAll->where('status_by_store','>=','3');
        $lastTrxAll=$lastTrxAll->whereBetween('date_trx',[$fromDate, $endDate]);
        $lastTrxAll=$lastTrxAll->first();
            
        $countTransaksi = DB::table('trx_record_view');
        if ($kasir <> 0) {
            $countTransaksi = $countTransaksi->where('created_by',$kasir);
        }
        $countTransaksi = $countTransaksi->where('status_by_store','>=','3');
        $countTransaksi = $countTransaksi->whereBetween('date_trx',[$fromDate, $endDate]);
        $countTransaksi = $countTransaksi->count();
            
        $lastTrxTransfer = DB::table('tr_payment_record as a');
        $lastTrxTransfer = $lastTrxTransfer->select(DB::raw('SUM(a.total_payment) as totalPayment'),'b.created_by');
        $lastTrxTransfer = $lastTrxTransfer->leftJoin('tr_store as b','a.trx_code','=','b.billing_number');
        if ($kasir <> 0) {
            $lastTrxTransfer = $lastTrxTransfer->where('b.created_by',$kasir);
        }
        $lastTrxTransfer = $lastTrxTransfer->where('a.trx_method','4');
        $lastTrxTransfer = $lastTrxTransfer->whereBetween('a.date_trx',[$fromDate, $endDate]);
        $lastTrxTransfer = $lastTrxTransfer->first();
            
        $lastTrxonProcess = DB::table('view_billing_action');
        $lastTrxonProcess = $lastTrxonProcess->where('status','1');
        if ($kasir <> 0) {
            $lastTrxonProcess = $lastTrxonProcess->where('created_by',$kasir);
        }
        $lastTrxonProcess = $lastTrxonProcess->whereBetween('tr_date',[$fromDate, $endDate]);
        $lastTrxonProcess = $lastTrxonProcess->count();
            
        $lastTrxKredit = DB::table('tr_kredit as a');
        $lastTrxKredit = $lastTrxKredit->leftJoin('tr_store as b','a.from_payment_code','=','b.billing_number');
        if ($kasir <> 0) {
            $lastTrxKredit = $lastTrxKredit->where("b.created_by",$kasir);
        }
        $lastTrxKredit = $lastTrxKredit->whereBetween('a.created_at',[$fromDate, $endDate]);
        $lastTrxKredit = $lastTrxKredit->count();           
        
        $selectYear = DB::table('tr_payment_record as a');        
        $selectYear = $selectYear->select(DB::raw('DATE_FORMAT(a.date_trx,"%Y") as years'));
        $selectYear =$selectYear->leftJoin('tr_store as b','a.trx_code','=','b.billing_number');
        $selectYear = $selectYear->groupBy(DB::raw('DATE_FORMAT(a.date_trx,"%Y")'));
        $selectYear = $selectYear->get();
            
        $totalTransaksi = DB::table('view_billing_action');
        if ($kasir <> '0') {
            $totalTransaksi = $totalTransaksi->where('created_by',$kasir);
        }
        $totalTransaksi = $totalTransaksi->where([
                ['is_return','!=','1']
        ]);
        $totalTransaksi = $totalTransaksi->whereBetween('tr_date',[$fromDate, $endDate]);
        $totalTransaksi = $totalTransaksi->count();
            
        return view ('Dashboard/DashboardLoadTrx', compact('countTransaksi','lastTrxKredit','lastTrxTransfer','lastTrxonProcess','fromDate','endDate','lastTrxAll','totalTransaksi','selectYear','kasir'));
    }

    public function garphPembelian ($year){
        $thisPeriode = date("m-Y");

        $xAxistSet = DB::table('tr_payment_record')
            ->select(DB::raw('SUBSTRING(date_trx,6,2) as periode'))
            ->where(DB::raw('SUBSTRING(date_trx,1,4)'),$year)
            ->groupBy(DB::raw('SUBSTRING(date_trx,6,2)'))
            ->get();

        $penjualan = DB::table('tr_payment_record')
            ->select(DB::raw('SUBSTRING(date_trx,6,2) as displayPeriode'), DB::raw('SUM(total_payment) as totalPayment'))
            ->where(DB::raw('SUBSTRING(date_trx,1,4)'),$year)
            ->groupBy(DB::raw('SUBSTRING(date_trx,6,2)'))
            ->get();

        $pembelian = DB::table('purchase_order')
            ->select(DB::raw('SUBSTRING(purchase_date,6,2) as displayPeriode'), DB::raw('SUM(sub_total) as totalPayment'))
            ->where(DB::raw('SUBSTRING(purchase_date,1,4)'),$year)
            ->groupBy(DB::raw('SUBSTRING(purchase_date,6,2)'))
            ->get();

        return view('Dashboard/DashboardGarphPenjualan', compact('penjualan','pembelian','year','xAxistSet'));
    }
    
    public function onClickDetail (Request $reqPostOnClick){
        $condition = $reqPostOnClick->condition;
        $fromDate = $reqPostOnClick->fromDate;
        $endDate = $reqPostOnClick->endDate;
        $kasir = $reqPostOnClick->kasir;
        
        // echo $condition."-".$fromDate."-".$endDate;
        
        if($condition == "alltrx"){
            $allCondition = DB::table('view_trx_method');
            $allCondition = $allCondition->where('status_by_store','>=','3');
            if ($kasir <> 0) {
                $allCondition = $allCondition->where('created_by',$kasir);
            }
            $allCondition = $allCondition->whereBetween('date_trx',[$fromDate, $endDate]);
            $allCondition = $allCondition->orderBy('core_id_trx','asc');
            $allCondition = $allCondition->get();
        }
        elseif($condition == "onprocess"){
            $allCondition = DB::table('view_billing_action');
            $allCondition = $allCondition->where('status','1');
            if ($kasir <> 0) {
                $allCondition = $allCondition->where('created_by',$kasir);
            }
            $allCondition = $allCondition->whereBetween('tr_date',[$fromDate, $endDate]);
            $allCondition = $allCondition->get();
        }
        elseif($condition == "kredit"){
            $allCondition = DB::table('view_customer_kredit');
            if ($kasir <> 0) {
                $allCondition = $allCondition->where('created_by',$kasir);
            }
            $allCondition = $allCondition->whereBetween('created_at',[$fromDate, $endDate]);
            $allCondition = $allCondition->get();
        }
        elseif($condition == "allSummery"){
            $allCondition = DB::table('view_billing_action');
            $allCondition = $allCondition->where([
                    ['is_return','!=','1']
            ]);
            if ($kasir <> 0) {
                $allCondition = $allCondition->where('created_by',$kasir);
            }
            $allCondition = $allCondition->whereBetween('tr_date',[$fromDate, $endDate]);
            $allCondition = $allCondition->get();
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
        echo $id."+".$status;
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
