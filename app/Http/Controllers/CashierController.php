<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CashierController extends Controller
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

    // CEK JUMLAH TRANSAKSI DENGAN STATUS AKTIF DENGAN KODE 1
    public function checkProdActive (){
        $areaID = $this->checkuserInfo();
        $countActiveDisplay = DB::table('tr_store')
            ->where([
                ['status',1],
                ['store_id',$areaID]
                ])
            ->count();
        return $countActiveDisplay;
    }

    // CEK NOMOR BILLING AKTIF ATAU TIDAK
    public function checkBillNumber (){
        $areaID = $this->checkuserInfo();
        $countActive = $this->checkProdActive();       
        if ($countActive == 0) {
            $getNextID = DB::table('tr_store')
                ->select('tr_store_id')
                ->orderBy('tr_store_id','desc')
                ->first();

            if (!empty($getNextID)) {
                $nextIdPrice = $getNextID->tr_store_id + 1;            
            }
            else {
                $nextIdPrice = 1;            
            }
            $pCode = "P".date('dmy')."-".sprintf("%07d",$nextIdPrice);
        }
        else {
            $billCode = DB::table('view_billing_action')
                ->select('billing_number')
                ->where([
                    ['status',1],
                    ])
                ->orderBy('tr_store_id','desc')
                ->first();
            $pCode = $billCode->billing_number;
        }

        return $pCode;
    }

    public function mainCashier (){
        $checkArea = $this->checkuserInfo();
        if (Auth::check()) {        
            return view ('Cashier/maintenancePage', compact('checkArea'));
        } else {
            return view ('login');
        }        
    }

    public function productList (){
        $billNumber = $this->checkBillNumber();
        $productUnit = DB::table('m_unit')
            ->get();

        $countProdList = DB::table('tr_store_prod_list')
            ->where('status','1')
            ->count();

        $productList = DB::table('m_product')
            ->select('idm_data_product','product_name')      
            ->orderBy('product_name','asc')
            ->get();

        return view ('Cashier/cashierProductList', compact('productUnit','countProdList','productList','billNumber'));
    }

    public function inputSatuan($idPrd){
        $satuan = DB::table('m_product_unit')
            ->where('core_id_product',$idPrd)
            ->orderBy('product_price_sell','DESC')
            ->get();

        return view ('Cashier/cashierProductListSatuan', compact('satuan'));
    }
    
    public function hargaSatuan($idSatuan, $idPrd){
        $hargaSatuan = DB::table('m_product_unit');
        $hargaSatuan = $hargaSatuan->where([
            ['core_id_product',$idPrd],
            ['product_satuan',$idSatuan]
        ]);
            $hargaSatuan = $hargaSatuan->first();
        if (!empty($hargaSatuan)) {
            return response()->json([
                'price' => $hargaSatuan->product_price_sell,
                'discount' => $hargaSatuan->discount
            ]);
        }
        // return view ('Cashier/cashierProductListHarga', compact('hargaSatuan'));
        return response()->json(['error' => 'Product not found'], 404);
    }
    public function stoockBarang($idSatuan, $idPrd){
        $productStock = DB::table('m_product_unit')
            ->where([
                ['core_id_product',$idPrd],
                ['product_satuan',$idSatuan]
                ])
            ->first();
        if (!empty($productStock)) {
            return response()->json([
                'stock' => $productStock->stock
            ]);
        }
        return response()->json(['error' => 'Product not found'], 404);
    }

    public function postProductList (Request $reqPostProd){
        $transNumber = $reqPostProd->trnNumber;
        $createdBy = $reqPostProd->created;
        $prodName = $reqPostProd->prdName;
        $prodQty = $reqPostProd->qty;
        $prodSatuan = $reqPostProd->satuan;
        $hargaSatuan = str_replace(",","",$reqPostProd->harga);
        $disc = $reqPostProd->disc;
        $jumlah = str_replace(",","", $reqPostProd->jumlah);
        $stock = $reqPostProd->stock;
        
        // Cek ketersediaan nomor billing data store 
        $trStore = DB::table('tr_store')
            ->where('billing_number',$transNumber)
            ->first();

        $tBill = $trStore->t_bill + $jumlah;
        $tItem = $trStore->t_item + 1;

        // hitung jumlah produk yang ada list produk store 
        $countProduct = DB::table('tr_store_prod_list')
            ->where([
                ['product_code',$prodName],
                ['from_payment_code',$transNumber]
            ])
            ->count();
        
        if ($countProduct < 1 AND ($jumlah <> 0 OR $jumlah <> '')) { //jika belum ada insert ke table
            DB::table('tr_store_prod_list')
                ->insert([
                    'from_payment_code'=>$transNumber,
                    'product_code'=>$prodName,
                    'qty'=>$prodQty,
                    'unit'=>$prodSatuan,
                    'unit_price'=>$hargaSatuan,
                    'disc'=>$disc,
                    't_price'=>$jumlah,
                ]); 
            
        }
        else {
            $cekDataQty = DB::table('tr_store_prod_list')
                ->select('qty','unit','unit_price','disc','t_price')
                ->where([
                    ['from_payment_code',$transNumber],
                    ['product_code',$prodName]
                ])
                ->first();
            $updateQty = $cekDataQty->qty + $prodQty;
            $updateTotalHarga = $cekDataQty->t_price + $jumlah;

            DB::table('tr_store_prod_list')
                ->where([
                    ['from_payment_code',$transNumber],
                    ['product_code',$prodName]
                ])
                ->update([
                    'qty'=>$updateQty,
                    'unit'=>$prodSatuan,
                    'unit_price'=>$hargaSatuan,
                    'disc'=>$disc,
                    't_price'=>$updateTotalHarga,
                ]);
        }
        // UPDATE BILLING
        DB::table('tr_store')
        ->where('billing_number',$transNumber)
        ->update([
            't_bill'=>$tBill,
            't_item'=>$tItem,
        ]);
        // UPDATE STOCK 
        DB::table('m_product_unit')
        ->where([
            ['core_id_product',$prodName],
            ['product_satuan',$prodSatuan]
        ])
        ->update([
            'stock'=>$stock
        ]);
    }

    public function listTableTransaksi(){
        $listTrProduct = DB::table('tr_store_prod_list as a')
            ->select('a.*','b.product_name as productName')
            ->leftJoin('m_product as b','a.product_code','=','b.idm_data_product')
            ->where('a.status','1')
            ->orderBy('a.list_id','desc')
            ->get();

        return view ('Cashier/cashierProductListTable', compact('listTrProduct'));
    }

    public function buttonAction (){
        //$priceCode = DB::select("SHOW TABLE STATUS LIKE 'tr_store'");
        $areaID = $this->checkuserInfo();        
        $pCode = $this->checkBillNumber();
        $countActiveDisplay = $this->checkProdActive();

        //Get number billing and display active where status 1
        $cekBillNumber = DB::table('tr_store')
            ->select('tr_store_id','billing_number')
            ->where('status',1)
            ->orderBy('tr_store_id','desc')
            ->first();

        //Variable billing number for displayed
        if (!empty($cekBillNumber)) {
            $billNumber = $cekBillNumber->billing_number;            
        }
        else {
            $billNumber = "";
        }            

        $members = DB::table('m_customers')
            ->where('customer_status','1')
            ->orWhere('customer_status','2')
            ->get();

        $delivery = DB::table('m_delivery')
            ->where('status','1')
            ->get();

        $trPaymentInfo = DB::table('view_billing_action')
            ->where([
                ['status',1],
                ['billing_number',$billNumber]
                ])
            ->orderBy('tr_store_id','desc')
            ->first();

        return view ('Cashier/cashierButtonList', compact('pCode','members','delivery','countActiveDisplay','trPaymentInfo'));
    }
    public function loadHelp (){
        return view ('Cashier/cashierHelp');
    }
    public function postNoBilling (Request $reqPostBill){
        $t_Bill = "0";
        $no_Struck = $reqPostBill->no_Struck;
        $pelanggan = $reqPostBill->pelanggan;
        $t_Pay = "0";
        $t_Difference = "0";
        $t_Item = "0";
        $deliveryBy = $reqPostBill->pengiriman;
        $ppn = $reqPostBill->ppn;
        $t_PayReturn = $t_Pay-$t_Bill;
        $areaID = $this->checkuserInfo();

        // Cek nomor struck ada atau tidak 
        $cekStruck = DB::table('tr_store')
            ->where([
                ['billing_number',$no_Struck],
                ['status','1']
            ])
            ->count();

        if ($cekStruck < 1) {
            $insertToStore = DB::table('tr_store')
                ->insert([
                    'store_id'=>$areaID,
                    'billing_number'=>$no_Struck,
                    'member_id'=>$pelanggan,
                    't_bill'=>$t_Bill,
                    't_pay'=>$t_Pay,
                    't_difference'=>$t_Difference,
                    't_pay_return'=>$t_PayReturn,
                    't_item'=>$t_Item,
                    'tr_delivery'=>$deliveryBy,
                    'ppn'=>$ppn,
                    'status'=>'1',
                    'created_date'=>now(),
                    'tr_date'=>now(),                    
                ]);
        }
    }

    public function manualSelectProduct (){        
        $areaID = $this->checkuserInfo();        
        $billNumber = $this->checkBillNumber();
        $dbProductList = DB::table('m_product')
            ->select('idm_data_product','product_code','product_name','stock')
            ->get();

        return view ('Cashier/cashierProductListModal', compact('areaID', 'billNumber','dbProductList'));
    }

    public function postProductSale (Request $reqPostProdSale){        
        $createdBy = $reqPostProdSale->userName;
        $billNumber = $reqPostProdSale->billNumber;
        $area = $reqPostProdSale->areaGudang;
        
        return view ('Cashier/cashierProductListModalSelect', compact('productList'));
    }

    public function updateToSave ($noBilling){
        DB::table('tr_store')
            ->where('billing_number',$noBilling)
            ->update([
                'status'=>'2'
            ]);
        DB::table('tr_store_prod_list')
            ->where('from_payment_code',$noBilling)
            ->update([
                'status'=>'2'
            ]);
        return back();
    }
    public function modalDataPenjualan (){
        return view ('Cashier/cashierModalDataPenjualan');
    }

    public function funcDataPenjualan ($dateIden){
        $listDataSelling = DB::table('view_billing_action')            
            ->where('tr_date',$dateIden)
            ->orderBy('tr_store_id','desc')
            ->paginate(10);
            
        return view ('Cashier/cashierModalDataPenjualanList', compact('listDataSelling'));
    }

    public function billingIden ($billingIden){
        // CHECK DATA SEBELUMNYA ADA YANG AKTIF ATAU TIDAK 
        $countAc = DB::table('tr_store')
            ->where('status','1')
            ->count();

        if ($countAc >= 1) {
            DB::table('tr_store')
                ->where('status','1')
                ->update([
                    'status'=>'2',
                ]);

            DB::table('tr_store_prod_list')
                ->where('status','1')
                ->update([
                    'status'=>'2',
                ]);
        }

        DB::table('tr_store')
            ->where('billing_number',$billingIden)
            ->update([
                'status'=>'1',
            ]);

        DB::table('tr_store_prod_list')
            ->where('from_payment_code',$billingIden)
            ->update([
                'status'=>'1',
            ]);            
    }

    public function modalDataStock(){
        $userID = Auth::user()->id;
        return view ('Cashier/cashierModalDataStock', compact('userID'));
    }

    public function funcDataStock($point, $keyword){
        echo $point."-".$keyword;
        
        $headerSize = DB::table('m_product_unit')
            ->select('product_size')
            ->groupBy('product_size')
            ->get();

        $productList = DB::table('m_product')
            ->get();

        $productUnitList = DB::table('m_product_unit')
            ->get();

        return view ('Cashier/cashierModalDataStockList', compact('headerSize','productList','productUnitList'));
    }

    public function deleteData ($data){
        // Cek List Data
        $listData = DB::table('tr_store_prod_list')
            ->select('from_payment_code','product_code','qty','unit','t_price')
            ->where('list_id',$data)
            ->first();
        $prodID = $listData->product_code;
        $qty = $listData->qty;
        $unit = $listData->unit;
        $paymentCode = $listData->from_payment_code;
        $tPrice = $listData->t_price;

        //Update stock
        $infoStock = DB::table('m_product_unit')
            ->where([
                ['core_id_product',$prodID],
                ['product_satuan',$unit],
                ])
            ->first();
        $updateStock = $infoStock->stock + $qty;
        DB::table('m_product_unit')
            ->where([
                ['core_id_product',$prodID],
                ['product_satuan',$unit],
                ])
            ->update([
                'stock'=> $updateStock
            ]);
        
        // Update Data Store 
        $infoBilling = DB::table('tr_store')
            ->select('t_bill','t_item')
            ->where('billing_number',$paymentCode)
            ->first();
        $updateBill = $infoBilling->t_bill - $tPrice;
        $updateItem = $infoBilling->t_item - 1;
        DB::table('tr_store')
            ->where('billing_number',$paymentCode)
            ->update([
                't_bill' => $updateBill,
                't_item' => $updateItem
            ]);
        
        //Delete product list into table product list store
        DB::table('tr_store_prod_list')
            ->where('list_id',$data)
            ->delete();

    }

    public function updateToPayment(Request $reqUpdatePay){
        $created = Auth::user()->name;
        $noBill = $reqUpdatePay->noBill;
        $ppn = $reqUpdatePay->ppn;
        $ppnNominal = str_replace(".","",$reqUpdatePay->ppnNominal);
        $tBayar = str_replace(".","",$reqUpdatePay->tBayar);
        $tBill = $reqUpdatePay->tBill;
        $treturn = $tBayar-$tBill;
        
        if ($tBayar >= $tBill) {
            DB::table('tr_store')
                ->where('billing_number',$noBill)
                ->update([
                    't_pay'=>$tBayar,
                    't_pay_return'=>$treturn,
                    'status'=>'5',
                    'ppn'=>$ppn,
                    'ppn_nominal'=>$ppnNominal,
                    'tr_date'=>now()
                ]);
    
            DB::table('tr_store_prod_list')
                ->where('from_payment_code',$noBill)
                ->update([
                    'status'=>'5',
                    'created_by'=>$created,
                    'date'=>now()
                ]);
        }
    }

    public function modalDataPelunasan(){
        return view ('Cashier/cashierModalDataPelunasan');
    }

    public function funcDataPelunasan($keyword, $infoCode){
        $dataPinjaman = DB::table('view_billing_action');
        if ($infoCode == 1) {
            $dataPinjaman = $dataPinjaman->whereBetween('status',['1','3']);
        }
        elseif ($infoCode == 2) {
            $dataPinjaman = $dataPinjaman->where('status','4');
        }
        $dataPinjaman = $dataPinjaman->get();
        
        return view ('Cashier/cashierModalDataPelunasanList', compact('dataPinjaman','infoCode'));
    }

    public function actionDataPinjaman (Request $reqAction){
        $noBilling = $reqAction->noBilling;
        $status = $reqAction->status;
        $tPayment = str_replace(".","", $reqAction->tPayment);
        $tPengembalian = str_replace(".","", $reqAction->tPengembalian);

        $updateTr = DB::table('tr_store');
        $updateTr = $updateTr->where('billing_number',$noBilling);
        if ($status >= 1 AND $status <= 3) {
            $updateTr = $updateTr->update([
                'status'=>'4',
            ]);
        }
        elseif ($status == 4) {
            $updateTr = $updateTr->update([
                't_pay'=>$tPayment,
                't_pay_return'=>$tPengembalian,
                'status'=>'5',
            ]);
        }
        
    }
    public function modalDataReturn(){
        return view ('Cashier/cashierModalDataReturn');
    }
}
