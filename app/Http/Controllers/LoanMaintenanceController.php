<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;


class LoanMaintenanceController extends Controller
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
    
    public function mainAdmin () {
        return view('HutangCustomers/mainEditLoanCustomer');
    }

    public function pembayaran (){
        $company = Auth::user()->company;

        $dbMCustomer = DB::table('m_customers')
            ->where('comp_id',$company)
            ->get();

        return view('HutangCustomers/pembayaran', compact('dbMCustomer'));
    }

    public function saldo (){
        $company = Auth::user()->company;
        $dbMCustomer = DB::table('m_customers')
            ->where('comp_id',$company)
            ->get();

        return view('HutangCustomers/saldoKredit', compact('dbMCustomer'));
    }
    public function lapCustomer (){
        $company = Auth::user()->company;
        $dbMCustomer = DB::table('m_customers')
            ->where('comp_id',$company)
            ->get();

        return view('HutangCustomers/lapCustomers', compact('dbMCustomer'));
    }
    public function laporanCustomer($keyword, $fromDate, $endDate){
        // echo $keyword." ".$fromDate." ".$endDate;
        $company = Auth::user()->company;
        $dbTableKredit = DB::table('view_customer_kredit');
        if ($keyword <> 0) {
            $dbTableKredit = $dbTableKredit->where('from_member_id', $keyword);
        }
        if ($fromDate <> 0 OR $endDate <> 0) {
            $dbTableKredit = $dbTableKredit->whereBetween('created_at',[$fromDate,$endDate]);
        }
        $dbTableKredit = $dbTableKredit->where('comp_id',$company);
        $dbTableKredit = $dbTableKredit->limit(100);
        $dbTableKredit = $dbTableKredit->get();

        return view('HutangCustomers/lapCustomersTable', compact('dbTableKredit'));
    }
    public function setup (){
        $company = Auth::user()->company;
        $dbMCustomer = DB::table('m_customers')
            ->where('comp_id',$company)
            ->get();

        return view('HutangCustomers/setupKredit', compact('dbMCustomer'));
    }

    public function setupPelanggan ($keyword){
        $company = Auth::user()->company;
        $customerListTrx = DB::table('m_customers');
        $customerListTrx = $customerListTrx->where('comp_id', $company);
        if ($keyword <> '0') {
            $customerListTrx = $customerListTrx->where('idm_customer',$keyword);
        }
        $customerListTrx = $customerListTrx->get();

        $totalHutang2 = DB::table('view_customer_kredit');
        $totalHutang2 = $totalHutang2->select(DB::raw('SUM(nom_kredit) as kredit'), 'from_member_id');
        if ($keyword <> '0') {
            $totalHutang2 = $totalHutang2->where('from_member_id', $keyword);
        }
        $totalHutang2 = $totalHutang2->limit(100);
        $totalHutang2 = $totalHutang2->get();
        return view("HutangCustomers/UnlockCustomerLoan", compact('customerListTrx','totalHutang2'));
    }

    public function modalEditLimit ($id){
        $selectCustomer = DB::table('m_customers as a')
            ->select('a.*','b.group_name')
            ->leftJoin('m_cos_group as b','a.customer_type','=','b.idm_cos_group')
            ->where('a.idm_customer',$id)
            ->first();

        return view('HutangCustomers/LimitEditCustomer', compact('selectCustomer'));
    }

    public function postLimitCustomer (Request $reqLimit){
        $customerID = $reqLimit->idCus;
        $nominal = str_replace(".","",$reqLimit->kreditLimit);

        //cek Hutang Customer :
        $aktifHutang = DB::table('tr_kredit')
            ->select(DB::raw('SUM(nom_kredit) as nominalKredit'))
            ->where([
                ['from_member_id',$customerID],
                ['nom_kredit','!=','0']
                ])
            ->first();
        if (!empty($aktifHutang)) {
            $sumKredit = $aktifHutang->nominalKredit;
        }
        else {
            $sumKredit = '0';
        }

        if ($sumKredit > $nominal) {
            $msg = array('warning' => 'Limit kredit pelanggan tidak dapat kurang dari kredit yang belum dibayarkan, yaitu : '.number_format($sumKredit,'0',',','.'));
        }
        else {
            DB::table('m_customers')
                ->where('idm_customer',$customerID)
                ->update([
                    'kredit_limit'=>$nominal
                ]);
                
            $msg = array('success' => 'Limit kredit pelanggan berhasil ter update.');
        }
        return response()->json($msg);
    }

    public function saldoFaktur($pelanggan, $fromDate, $endDate){
        // echo $pelanggan." ".$fromDate." ".$endDate;
        $company = Auth::user()->company;
        $historyFaktur = DB::table('view_payment_kredit');
            $historyFaktur = $historyFaktur->where('comp_id',$company);
            if ($pelanggan <> 0) {
                $historyFaktur = $historyFaktur->where('member_id',$pelanggan);
            }
            if ($fromDate <> 0 OR $endDate <> 0) {
                $historyFaktur = $historyFaktur->whereBetween('date_payment',[$fromDate,$endDate]);
            }
            $historyFaktur = $historyFaktur->orderBy('idtr_payment','desc');
            $historyFaktur = $historyFaktur->get();

        return view('HutangCustomers/saldoKreditFaktur', compact('historyFaktur'));
    }

    public function saldoCustomer($pelanggan){
        $company = Auth::user()->company;
        $sumSaldoCustomer = DB::table('view_customer_kredit');
            $sumSaldoCustomer = $sumSaldoCustomer->select(DB::raw('DISTINCT(from_member_id) as distctMember'), DB::raw('SUM(nominal)as nominal'), DB::raw('SUM(nom_payed) as nomPayed'), DB::raw('SUM(nom_kredit) as saldoKredit'), 'customer_store', 'from_payment_code','created_at','kredit_limit');
            if ($pelanggan <> 0) {
                $sumSaldoCustomer = $sumSaldoCustomer->where('from_member_id',$pelanggan);
            }
            $sumSaldoCustomer = $sumSaldoCustomer->where('comp_id',$company);
            $sumSaldoCustomer = $sumSaldoCustomer->orderBy('idtr_kredit','desc');
            $sumSaldoCustomer = $sumSaldoCustomer->get();
        return view('HutangCustomers/saldoKreditCustomer', compact('sumSaldoCustomer'));
    }

    
}
