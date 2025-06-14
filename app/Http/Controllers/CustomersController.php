<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomersController extends Controller
{
    public function countAccessDok (){
        $userID = Auth::user()->id;

        $countUserComp = DB::table('view_user_comp_loc')
            ->where('id',$userID)
            ->count();

        return $countUserComp;
    }

    public function getCusCode (){
        $countUserCompany = $this->countAccessDok();
        $authUserID = Auth::user()->id;
        $authUserCompany = Auth::user()->company;

        if ($countUserCompany == '0') {
            $codeComp = "ID";
        }
        else {
            $codeCompany = DB::table('view_user_comp_loc')
                ->select('company_code')
                ->where('id',$authUserID)
                ->first();
            $codeComp = $codeCompany->company_code;
        }
        $countCusID = DB::table('m_customers')
            ->where('comp_id',$authUserCompany)
            ->count();
        $no = (int)$countCusID + 1;
        $customerCode = "CUS".$codeComp."-".sprintf("%05d",$no);  
        return $customerCode;        
    }    
    public function mainIndex (){
        return view ('AssetManagement/MasterData/CustomersIndex');
    }
    
    public function AddCustomers (){
        $sales = DB::table('m_sales')
            ->where('sales_status',1)
            ->get();

        $cosGroup = DB::table('m_cos_group')
            ->get();

        return view ('AssetManagement/MasterData/CustomersModalFormAdd', compact('sales','cosGroup'));
    }

    public function PostNewCustomer (Request $reqPostCustomer){
        $cusNumber = $this->getCusCode();
        $authUserCompany = Auth::user()->company;

        if ($reqPostCustomer->kreditLimit == '') {
            $addKreditLimit = '0';
        }
        else {
            $addKreditLimit = str_replace(".","",$reqPostCustomer->kreditLimit);            
        }            
        if($reqPostCustomer->Customer == "" || $reqPostCustomer->Customer==" "){
            $msg = array('warning'=>'<h5>"Nama Pelanggan" harus terisi</h5>');
        }
        elseif ($reqPostCustomer->paymentType == "Tempo" && ($reqPostCustomer->kreditLimit == '' || $reqPostCustomer->kreditLimit == '0')) {
            $msg = array('warning'=>'<h5>Customer dengan type pembayaran "Tempo" wajib mengisi "Limit Kredit"</h5>');
        }
        elseif ($reqPostCustomer->Address == "" || $reqPostCustomer->City == "") {
            $msg = array('warning'=>'<h5>"Alamat dan Kota Pelanggan" wajib diisi!</h5>');
        }
        elseif ($reqPostCustomer->paymentType == "0" || $reqPostCustomer->paymentType == "") {
            $msg = array('warning'=>'<h5>"Type Pembayaran Pelanggan" wajib di isi !</h5>');
        }
        else{
            DB::table('m_customers')
                ->insert([
                    'customer_code'=>$cusNumber,
                    'customer_store'=>strtoupper($reqPostCustomer->Customer),
                    'address'=>$reqPostCustomer->Address,
                    'pic'=>$reqPostCustomer->pic,
                    'phone_number'=>$reqPostCustomer->phone,
                    'city'=>$reqPostCustomer->City,
                    'email'=>$reqPostCustomer->emailUser,
                    'schedule_delivery'=>$reqPostCustomer->Schedule,
                    'payment_type'=>$reqPostCustomer->paymentType,
                    'customer_type'=>$reqPostCustomer->typePenjualan,
                    'sales'=>$reqPostCustomer->Sales,
                    'registered_date'=>$reqPostCustomer->registeredDate,
                    'level'=>$reqPostCustomer->Level,
                    'kredit_limit'=>$addKreditLimit,
                    'customer_status'=>'1',
                    'created_date'=>now(),
                    'comp_id'=>$authUserCompany
                ]);
            $msg = array('success'=>'<h5>SUCCESS</h5><br>Data Customer '.$reqPostCustomer->Customer." berhasil dimasukkan!");
        }
        return response()->json($msg);
    }

    public function TableDataCustomer ($keyword) {
        $authUserComp = Auth::user()->company;
        // echo $authUserComp;
        $customer = DB::table('m_customers');
            if ($keyword <> 0) {
                $customer = $customer->where('customer_store','LIKE','%'.$keyword.'%');
            }
            $customer = $customer->where('comp_id',$authUserComp);
            $customer = $customer->paginate(50);

        return view ('AssetManagement/MasterData/CustomerTableData', compact('customer'));
    }

    public function EditTable ($id){
        $companyID = Auth::user()->company;
        $editCustomer = DB::table('m_customers')
            ->select('m_customers.*','m_sales.sales_name','m_sales.sales_code','c.idm_cos_group','c.group_name')
            ->leftJoin('m_sales', 'm_customers.sales','=','m_sales.sales_code')
            ->leftJoin('m_cos_group as c','m_customers.customer_type','=','c.idm_cos_group')
            ->where('m_customers.idm_customer',$id)
            ->first();

        $sales = DB::table('m_sales')
            ->where([
                ['sales_status',1],
                ['comp_id',$companyID]
                ])
            ->get();
            
        $cosGroup = DB::table('m_cos_group')
            ->get();

        return view ('AssetManagement/MasterData/CustomersModalFormEdit', compact('sales','editCustomer','id','cosGroup'));
    }

    public function PostEditTable (Request $reqPostEditCust){
        $kreditLimit = str_replace(".","",$reqPostEditCust->kreditLimit);
        DB::table('m_customers')
            ->where('idm_customer',$reqPostEditCust->customerID)
            ->update([
                'customer_store'=>strtoupper($reqPostEditCust->Customer),
                'address'=>$reqPostEditCust->Address,
                'pic'=>$reqPostEditCust->pic,
                'phone_number'=>$reqPostEditCust->phone,
                'city'=>strtoupper($reqPostEditCust->City),
                'email'=>$reqPostEditCust->emailUser,
                'schedule_delivery'=>$reqPostEditCust->Schedule,
                'payment_type'=>$reqPostEditCust->paymentType,
                'customer_type'=>$reqPostEditCust->typePenjualan,
                'sales'=>$reqPostEditCust->Sales,
                'registered_date'=>$reqPostEditCust->registeredDate,
                'level'=>$reqPostEditCust->Level,
                'customer_status'=>$reqPostEditCust->Status,
                'kredit_limit'=>str_replace(".","",$reqPostEditCust->kreditLimit),
                'updated_date'=>now(),
            ]);
    }

    public function DeleteTable ($id){
        DB::table('m_customers')
            ->where('idm_customer',$id)
            ->delete();
    }

    public function downloadAllCustomer (){
        $dbCustomer = DB::table('m_customers as a')
            ->select('a.*','b.sales_name','c.group_name','d.method_name')
            ->leftJoin('m_sales as b','a.sales','=','sales_code')
            ->leftJoin('m_cos_group as c','a.customer_type','=','c.idm_cos_group')
            ->leftJoin('m_payment_method as d','a.payment_type','=','d.idm_payment_method')
            ->get();

        return view('AssetManagement/MasterData/CustomersDownloadExcel', compact('dbCustomer'));
    }
}
