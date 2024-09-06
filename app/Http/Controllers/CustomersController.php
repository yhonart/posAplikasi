<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{
    public function mainIndex (){
        return view ('AssetManagement/MasterData/CustomersIndex');
    }
    
    public function AddCustomers (){
        $sales = DB::table('m_sales')
            ->where('sales_status',1)
            ->get();

        return view ('AssetManagement/MasterData/CustomersModalFormAdd', compact('sales'));
    }

    public function PostNewCustomer (Request $reqPostCustomer){
        if($reqPostCustomer->Customer == "" OR $reqPostCustomer->Customer==" "){
            $msg = array('warning'=>'<h5>Nama Customer harus diisi</h5>');
        }
        else{
            DB::table('m_customers')
                ->insert([
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
                    'kredit_limit'=>$reqPostCustomer->kreditLimit,
                    'customer_status'=>'1',
                    'created_date'=>now(),
                ]);
            $msg = array('success'=>'<h5>SUCCESS</h5><br>Data Customer '.$reqPostCustomer->Customer." berhasil dimasukkan!");
        }
        return response()->json($msg);
    }

    public function TableDataCustomer ($keyword) {
        $customer = DB::table('m_customers');
            if ($keyword <> 0) {
                $customer = $customer->where('customer_store','LIKE','%'.$keyword.'%');
            }
            $customer = $customer->paginate(50);

        return view ('AssetManagement/MasterData/CustomerTableData', compact('customer'));
    }

    public function EditTable ($id){
        $editCustomer = DB::table('m_customers')
            ->select('m_customers.*','m_sales.sales_name','m_sales.sales_code','c.idm_cos_group','c.group_name')
            ->leftJoin('m_sales', 'm_customers.sales','=','m_sales.sales_code')
            ->leftJoin('m_cos_group as c','m_customers.customer_type','=','c.idm_cos_group')
            ->where('m_customers.idm_customer',$id)
            ->first();

        $sales = DB::table('m_sales')
            ->where('sales_status',1)
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
                'kredit_limit'=>$reqPostEditCust->kreditLimit,
                'updated_date'=>now(),
            ]);
       
    }

    public function DeleteTable ($id){
        DB::table('m_customers')
            ->where('idm_customer',$id)
            ->delete();
    }
}
