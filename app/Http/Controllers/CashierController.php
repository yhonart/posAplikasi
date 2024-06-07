<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


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

    // BUAT NOMOR TRANSAKSI
    public function checkBillNumber (){
        $areaID = $this->checkuserInfo();
        $trxActived = $this->checkProdActive();
        $thisDate = date("dmy");
        $dateDB = date("Y-m-d");
        // count number 
        $countTrx = DB::table("tr_store")
            ->where([
                ['store_id', $areaID],
                ['tr_date',$dateDB]
                ])
            ->count();
                
            if($countTrx == '0'){
                $no = "1";
                $pCode = "P".$thisDate."-".sprintf("%07d",$no);
            }
            elseif($countTrx >= '1'){
                $no = $countTrx + 1;
                $pCode = "P".$thisDate."-".sprintf("%07d",$no);
            }
        return $pCode;
    }
    
    public function getInfoNumber (){
        $username = Auth::user()->name;
        $area = $this->checkuserInfo();
        $dateNow = date("Y-m-d");
        
        $billNumbering = DB::table("tr_store")
            ->where([
                ['store_id',$area],
                ['status','1'],
                ['created_by',$username]
                ])
            ->first();
            
        if(!empty($billNumbering)){
            $nomorstruk = $billNumbering->billing_number;
        }
        else{
            $nomorstruk = "0";
        }
        
        return $nomorstruk;
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
        $billNumber = $this->getInfoNumber();
        $productUnit = DB::table('m_unit')
            ->get();

        $countProdList = DB::table('tr_store_prod_list')
            ->where('status','1')
            ->count();
            
        $countBill = DB::table('tr_store')
            ->where('billing_number',$billNumber)
            ->count();

        $productList = DB::table('product_list_view')
            ->select(DB::raw("distinct(idm_data_product) as idm_data_product"),'product_name')
            ->orderBy('product_name','asc')
            ->get();

        return view ('Cashier/cashierProductList', compact('productUnit','countProdList','productList','billNumber','countBill'));
    }

    public function inputSatuan($idPrd){
        $satuan = DB::table('m_product_unit')
            ->where('core_id_product',$idPrd)
            ->orderBy('product_price_sell','DESC')
            ->get();

        return view ('Cashier/cashierProductListSatuan', compact('satuan'));
    }
    
    public function hargaSatuan($idSatuan, $idPrd){
        // CEK CUSTOMER INFO 
        $countActive = $this->getInfoNumber(); 

        $memberInfo = DB::table('trans_mamber_view')
            ->where('billing_number',$countActive)
            ->first();
        
        $memberType = $memberInfo->customer_type;

        //CEK HARGA DI TABEL PENJUALAN
        $countSellByType = DB::table('m_product_price_sell')
            ->where([
                ['core_product_price',$idPrd],
                ['cos_group',$memberType],
                ['size_product',$idSatuan],
            ])
            ->count();            
        
        if ($countSellByType >= '1') {
            $hargaSatuan = DB::table('m_product_price_sell');
            $hargaSatuan = $hargaSatuan->where([
                ['core_product_price',$idPrd],
                ['cos_group',$memberType],
                ['size_product',$idSatuan],
            ]);
            $hargaSatuan = $hargaSatuan->first();
            return response()->json([
                'price' => $hargaSatuan->price_sell,
                'discount' => '0'
            ]); 
        }
        else {
            $hargaSatuan = DB::table('m_product_unit');
            $hargaSatuan = $hargaSatuan->where([
                ['core_id_product',$idPrd],
                ['product_size',$idSatuan]
            ]);
            $hargaSatuan = $hargaSatuan->first();
            return response()->json([
                'price' => $hargaSatuan->product_price_sell,
                'discount' => '0'
            ]);                
        } 

        // return view ('Cashier/cashierProductListHarga', compact('hargaSatuan'));
        return response()->json(['error' => 'Product not found'], 404);
    }
    public function stoockBarang($idSatuan, $idPrd){
        $productStock = DB::table('product_list_view')
            ->where([
                ['idm_data_product',$idPrd],
                ['product_size',$idSatuan]
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
        $transNumber = $reqPostProd->transNumber;
        $createdBy = $reqPostProd->createdBy;
        $prodName = $reqPostProd->prodNameHidden;
        $prodQty = $reqPostProd->qty;
        $prodSatuan = $reqPostProd->satuan;
        $hargaSatuan = str_replace(".","",$reqPostProd->hargaSatuan);
        $disc = str_replace(".","",$reqPostProd->disc);
        $jumlah = str_replace(".","", $reqPostProd->jumlah);
        $stock = $reqPostProd->stock;
        $intJumlah = (int)$jumlah;
        
        // Cek ketersediaan nomor billing data store 
        $trStore = DB::table('trans_mamber_view')
            ->where('billing_number',$transNumber)
            ->first();

        $tBill = $trStore->t_bill + $intJumlah;
        $tItem = $trStore->t_item + 1;
        $memberType = $trStore->customer_type;

        // CHECK SATUAN 
        $satuanSell = DB::table('m_product_unit')
            ->where([
                ['core_id_product',$prodName],
                ['product_size',$prodSatuan]
            ])
            ->first();

        $dataSatuan = $satuanSell->product_satuan;

        // hitung jumlah produk yang ada list produk store 
        $countProduct = DB::table('tr_store_prod_list')
            ->where([
                ['product_code',$prodName],
                ['from_payment_code',$transNumber],
                ['unit',$dataSatuan]
            ])
            ->count();
        
        if ($countProduct == '0' AND ($jumlah <> '0' OR $jumlah <> '')) { //jika belum ada insert ke table
            
            DB::table('tr_store_prod_list')
                ->updateorInsert([
                    'from_payment_code'=>$transNumber,
                    'product_code'=>$prodName,
                    'qty'=>$prodQty,
                    'unit'=>$dataSatuan,
                    'unit_price'=>$hargaSatuan,
                    'disc'=>$disc,
                    't_price'=>$jumlah,
                    'stock'=>$stock,
                    'status'=>'1',
                    'created_by'=>$createdBy,
                    'date'=>now()
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
                    'unit'=>$dataSatuan,
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
            ['product_satuan',$dataSatuan]
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
        $listSatuanPrd = DB::table('m_product_unit')
            ->select('core_id_product','product_satuan','product_size')
            ->get();
        

        return view ('Cashier/cashierProductListTable', compact('listTrProduct','listSatuanPrd'));
    }

    public function listTableInputPrd(){
        $billNumber = $this->getInfoNumber();
        return view ('Cashier/cashierProductListEmpty', compact('billNumber'));
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
            
        $totalPayment = DB::table('tr_store_prod_list')
            ->select(DB::raw('SUM(t_price) as totalBilling'), DB::raw('COUNT(list_id) as countList'))
            ->where([
                ['from_payment_code',$billNumber],
                ['status','1']
                ])
            ->first();

        return view ('Cashier/cashierButtonList', compact('pCode','members','delivery','countActiveDisplay','trPaymentInfo','totalPayment'));
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
        $createdBy = Auth::user()->name;

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
                    'created_by'=>$createdBy
                ]);
        }
    }

    public function manualSelectProduct (){        
        $areaID = $this->checkuserInfo();        
        $billNumber = $this->getInfoNumber();
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
            
        $trDay = date("N");
        $trDate = date("d");
        $trMonth = date("m");
        $trYear = date("y");
            
        $cekNumber = DB::table("tr_numbering")
            ->where([
                ['tr_date',$trDate],
                ['tr_month',$trMonth],
                ['tr_year',$trYear]
                ])
            ->count(); 
        $areaID = $this->checkuserInfo();
        
        if($cekNumber==0){
            $no = 1;
            DB::table("tr_numbering")
                ->insert([
                    'tr_days'=>$trDay,
                    'tr_date'=>$trDate,
                    'tr_month'=>$trMonth,
                    'tr_year'=>$trYear,
                    'tr_number'=>$no,
                    'core_id_site'=>$areaID
                    ]);
        }
        else{
            $selectNumber = DB::table("tr_numbering")
                ->where([
                    ['tr_date',$trDate],
                    ['tr_month',$trMonth],
                    ['tr_year',$trYear]
                    ])
                ->first();
                
            $no = $selectNumber->tr_number+1;
            
            DB::table("tr_numbering")
                ->where([
                    ['tr_date',$trDate],
                    ['tr_month',$trMonth],
                    ['tr_year',$trYear]
                    ])
                ->update([
                    'tr_number'=>$no
                    ]);
        }
        return back();
    }
    
    
    public function modalDataPenjualan (){
        $method = DB::table('m_payment_method')
            ->get();
        $mydate = date("Y-m-d");
        
        $cekClosing = DB::table('tr_payment_record')
            ->where([
                ['date_trx',$mydate],
                ['status','1']
                ])
            ->count();
            
        return view ('Cashier/cashierModalDataPenjualan', compact('method','cekClosing'));
    }
    
   

    public function funcDataPenjualan ($fromdate, $enddate, $keyword, $method){
        $fields = ['trx_code','customer_store'];
        // echo $fromdate."=".$enddate."=".$keyword."=".$method;
        
        $listDataSelling = DB::table('trx_record_view');
        $listDataSelling = $listDataSelling->whereBetween('date_trx',[$fromdate, $enddate]);
        if($keyword <> '0'){
            $listDataSelling = $listDataSelling->where(function ($query) use($keyword, $fields) {
				for ($i = 0; $i < count($fields); $i++){
				$query->orwhere($fields[$i], 'like',  '%' . $keyword .'%');
				}      
			});
        }
        if($method <> '0'){
            $listDataSelling = $listDataSelling->where('trx_method',$method);
        }
        $listDataSelling = $listDataSelling->paginate(10);
        
        $countBelanja = DB::table('trx_record_view');
        $countBelanja = $countBelanja->select(DB::raw('COUNT(idtr_record) AS countID'), DB::raw('SUM(total_payment) AS sumPayment'));
        $countBelanja = $countBelanja->whereBetween('date_trx',[$fromdate, $enddate]);
        if($keyword <> '0'){
            $countBelanja = $countBelanja->where(function ($query) use($keyword, $fields) {
				for ($i = 0; $i < count($fields); $i++){
				$query->orwhere($fields[$i], 'like',  '%' . $keyword .'%');
				}      
			});
        }
        if($method <> '0'){
            $countBelanja = $countBelanja->where('trx_method',$method);
        }
        $countBelanja = $countBelanja->first();
            
        return view ('Cashier/cashierModalDataPenjualanList', compact('listDataSelling','countBelanja'));
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
    
    public function searchDataReturn ($keyword, $fromDate, $endDate){
        $fields = ['billing_number','customer_name'];
        $dateNow = date('Y-m-d');
        echo $fromDate." s/d ".$endDate;
        $listDataNumber = DB::table('view_billing_action');
        $listDataNumber = $listDataNumber->whereBetween('tr_date',[$fromDate, $endDate]);
        if($keyword <> '0'){
            $listDataNumber = $listDataNumber->where(function ($query) use($keyword, $fields) {
                for ($i = 0; $i < count($fields); $i++){
                $query->orwhere($fields[$i], 'like',  '%' . $keyword .'%');
                }      
            });
        }
        $listDataNumber = $listDataNumber->where('status','4');
        $listDataNumber = $listDataNumber->orderBy('tr_store_id','desc');
        $listDataNumber = $listDataNumber->get();
        
        return view ('Cashier/cashierModalDataReturnList', compact('listDataNumber'));
    }
    
    public function clickListProduk ($dataTrx){
        $dataTransaksi = DB::table('trans_product_list_view')
            ->where('from_payment_code',$dataTrx)
            ->get();

        $unitList = DB::table('m_product_unit')
            ->get();

        return view ('Cashier/cashierModalDataReturnListTrx', compact('dataTransaksi','dataTrx','unitList'));
    }

    public function sumDataInfo ($trxID){
        $sumProdList = DB::table('tr_store_prod_list')
            ->select(DB::raw('SUM(t_price) as tPrice'))
            ->where('from_payment_code',$trxID)
            ->first();

        $tBillLama = DB::table('tr_store')
            ->select('t_bill')
            ->where('billing_number',$trxID)
            ->first();

        return view ('Cashier/cashierModalDataReturnListTrxSumInfo', compact('sumProdList','tBillLama'));
    }
    
    public function searchProdByKeyword($keyword){
        //get the q parameter from URL
        $barcode = "";
        $getBarcode = DB::table('m_product_unit')
            ->where('set_barcode',$keyword)
            ->first();
        if (!empty($getBarcode)) {
            $barcode = $getBarcode->set_barcode;
            $productList = DB::table('m_product as a');
            $productList = $productList->select('a.idm_data_product', 'a.product_name','b.core_id_product');
            $productList = $productList->leftJoin('b.m_product_unit', 'a.idm_data_product','=','b.core_id_product');
            $productList = $productList->where('b.set_barcode',$keyword);
            $productList = $productList->get();
        }
        else {
            $productList = DB::table('m_product');
            if ($keyword <> 0) {
                $productList = $productList->where('product_name','LIKE','%'.$keyword.'%');
            }
            $productList = $productList->orderBy('product_name','ASC');
            // $productList = $productList->limit(10);
            $productList = $productList->get();
        }

        return view ('Cashier/cashierProductListByKeyword', compact('productList','keyword'));
    }
    
    public function modalPembayaran($noBill, $tBayar, $tBill){
        $dataBilling = DB::table('view_billing_action')
            ->where('billing_number',$noBill)
            ->first();
        //echo $memberID;
        
        $memberID = $dataBilling->member_id;
        
        $cekKredit = DB::table('tr_kredit')
            ->where([
                ['from_member_id',$memberID],
                ['status','1']
                ])
            ->first();
            
        $countKredit = DB::table('tr_kredit')
            ->select('nominal')
            ->where([
                ['from_member_id',$memberID],
                ['status','1']
                ])
            ->count();
            
        $paymentMethod = DB::table('m_payment_method')
            ->where('status','1')
            ->get();
            
        $pengiriman = DB::table('m_delivery')
            ->where('status','1')
            ->get();
            
        $totalBayar = DB::table('tr_store_prod_list')
            ->select(DB::raw('SUM(t_price) as totalBilling'), DB::raw('COUNT(list_id) as countList'))
            ->where([
                ['from_payment_code',$noBill],
                ['status','1']
                ])
            ->first();
            
        $bankAccount = DB::table("m_company_payment")
            ->get();
        return view ('Cashier/cashierModalPembayaran', compact('dataBilling','noBill','paymentMethod','tBayar','tBill','pengiriman','totalBayar','cekKredit','countKredit','bankAccount'));
    }
    
    public function postEditItem(Request $editItem){
        $tableName = $editItem->tableName;
        $column = $editItem->column;
        $editVal = $editItem->editVal;
        $id = $editItem->id;
        $tableId = $editItem->tableId;
        
        $prdItem = DB::table('tr_store_prod_list')
            ->where('list_id',$id)
            ->first();
            
        $billingCode = $prdItem->from_payment_code;
        $productID = $prdItem->product_code;
        
        if ($column == "qty"){
            $hrgSatuan = $prdItem->unit_price;
            $totalBelanja = $hrgSatuan * $editVal;
            
            DB::table($tableName)
                ->where('list_id',$id)
                ->update([
                    $column => $editVal,
                    't_price'=>$totalBelanja
                ]);
        }
        elseif ($column == "unit"){
            //cek type member
            $typeMember = DB::table('trans_mamber_view')
                ->select('customer_type')
                ->where('billing_number',$billingCode)
                ->first();
            $cusType = $typeMember->customer_type;
            
            //cek harga jual berdasarkan type member
            $priceSell = DB::table('m_product_price_sell')
                ->where([
                    ['cos_group',$cusType],
                    ['size_product',$editVal],
                    ['core_product_price',$productID]
                    ])
                ->first(); 
            // ambil nama unit 
            $unitName = DB::table('m_product_unit')
                ->select('product_satuan','product_price_sell')
                ->where([
                    ['core_id_product',$productID],
                    ['product_size',$editVal]
                    ])
                ->first();
            echo $unitName->product_price_sell;
            
            // $prdSatuan = $unitName->product_satuan;
                
            // if(!empty($priceSell)){
            //     $hrgSatuan = $priceSell->price_sell;
            //     $qty = $prdItem->qty;
            //     $totalBelanja = $hrgSatuan * $qty;
                
            //     DB::table($tableName)
            //     ->where('list_id',$id)
            //     ->update([
            //         $column => $prdSatuan,
            //         't_price'=>$totalBelanja,
            //         'unit_price'=>$hrgSatuan
            //     ]);
            // }
            // else{
            //     $hrgSatuan = $unitName->product_price_sell;
            //     $qty = $prdItem->qty;
            //     $totalBelanja = $hrgSatuan * $qty;
                
            //     DB::table($tableName)
            //     ->where('list_id',$id)
            //     ->update([
            //         $column => $prdSatuan,
            //         't_price'=>$totalBelanja,
            //         'unit_price'=>$hrgSatuan
            //     ]);
            // }
            
        }
    }
    
    public function postDataPembayaran(Request $dataPembayaran){
        $noBill = $dataPembayaran->billPembayaran;
        $metodePembayaran = $dataPembayaran->metodePembayaran;
        $tBelanja = str_replace(".","",$dataPembayaran->tBelanja);
        $kredit = str_replace(".","",$dataPembayaran->kredit);
        $tplusKredit = str_replace(".","",$dataPembayaran->tPlusKredit);
        $tPembayaran = str_replace(".","",$dataPembayaran->tPembayaran);
        $nomSelisih = str_replace(".","",$dataPembayaran->nomSelisih);
        $absSelisih = abs($nomSelisih);
        
        
        $pengiriman = $dataPembayaran->pengiriman;
        $ppn2 = $dataPembayaran->ppn2;
        $memberID = $dataPembayaran->memberID;
        $nominalPPN2 = str_replace(".","",$dataPembayaran->nominalPPN2);
        $tKredit = $tBelanja-$tPembayaran;
        
        $bankAccount = $dataPembayaran->bankAccount;
        $accountCusNumber = $dataPembayaran->cardName;
        $accountCusName = $dataPembayaran->cardNumber;
        
        if($tPembayaran == ''){
            $tPembayaran = '0';
        }
        $cekPaymentMethod = DB::table('m_payment_method')
            ->where('idm_payment_method',$metodePembayaran)
            ->first();
            
        $nameMethod = $cekPaymentMethod->category;
        
        if($tPembayaran >= $tplusKredit){
            $status = "4";
            $mBayar = $metodePembayaran;
        }
        elseif($tPembayaran < $tplusKredit){
            //Cek data pinjaman member
            $status = "3";
            $mBayar = '8';
            $countKredit = DB::table('tr_kredit')
                ->where([
                    ['from_member_id',$memberID]
                    ])
                ->count();
            
            if($countKredit == '0'){
                DB::table('tr_kredit')
                    ->insert([
                        'from_payment_code'=>$noBill,
                        'from_member_id'=>$memberID,
                        'nominal'=>$tplusKredit,
                        'nom_payed'=>$tPembayaran,
                        'nom_kredit'=>$absSelisih,
                        'nom_last_kredit'=>'0',
                        'status'=>'1',
                        'created_at'=>now()
                    ]);
            }else{
                DB::table('tr_kredit')
                    ->where('from_member_id',$memberID)
                    ->update([
                        'from_payment_code'=>$noBill,
                        'nominal'=>$tplusKredit,
                        'nom_payed'=>$tPembayaran,
                        'nom_kredit'=>$absSelisih,
                        'nom_last_kredit'=>$kredit,
                        'created_at'=>now()
                    ]);
            }
        }
        else{
            $status = "2";
        }
        
        DB::table('tr_store')
            ->where('billing_number',$noBill)
            ->update([
                't_pay'=>$tPembayaran,
                'tr_delivery'=>$pengiriman,
                'ppn'=>$ppn2,
                'ppn_nominal'=>$nominalPPN2,
                'status'=>$status,
                'updated_date'=>now()
            ]);
            
        DB::table('tr_store_prod_list')
            ->where('from_payment_code',$noBill)
            ->update([
                'status'=>$status,
                'updated_date'=>now()
            ]);
        
        //INSERT METODE PEMBAYARAN
        DB::table('tr_payment_method')
            ->insert([
                'core_id_trx'=>$noBill,
                'method_name'=>$mBayar,
                'status'=>'1',
                'bank_transfer'=>$bankAccount,
                'card_cus_account'=>$accountCusName,
                'card_cus_number'=>$accountCusNumber
            ]);
            
        DB::table('tr_payment_record')
                ->insert([
                    'trx_code'=>$noBill,
                    'date_trx'=>now(),
                    'member_id'=>$memberID,
                    'total_payment'=>$tPembayaran,
                    'trx_method'=>$mBayar,
                    'status'=>'1'
                ]);
    }
    
    public function printTemplateCashier($noBill){
        // CASH => 4;
        // LOAN => 3;
        // SIMPAN => 2;
        // echo "Member : ".$noBillPrint;
        
        $trStore = DB::table('view_billing_action')
            ->where('billing_number',$noBill)
            ->first();
            
        $trStoreList = DB::table('trans_product_list_view')
            ->where('from_payment_code',$noBill)
            ->get();
            
        $companyName = DB::table('m_company')
            ->first();
        
        $status = $trStore->status;
        $memberID = $trStore->member_id;
        
        $paymentRecord = DB::table('tr_payment_record')
            ->where([
                ['trx_code',$noBill],
                ['status','1']
                ])
            ->first();
            
        $countBilling = DB::table('tr_kredit')
            ->where([
                ['from_payment_code','!=',$noBill],
                ['status','1'],
                ['from_member_id',$memberID]
                ])
            ->count();
            
        $totalPayment = DB::table('tr_store_prod_list')
            ->select(DB::raw('SUM(t_price) as totalBilling'), DB::raw('COUNT(list_id) as countList'), DB::raw('SUM(disc) as sumDisc'))
            ->where('from_payment_code',$noBill)
            ->first();
            
        $cekBon = DB::table('tr_kredit')
            ->where([
                ['from_payment_code','!=',$noBill],
                ['status','1'],
                ['from_member_id',$memberID]
                ])
            ->first();
        
        if($status == '4' AND $countBilling =='0'){
            return view ('Cashier/cashierPrintOutPembayaran', compact('noBill','trStore','trStoreList','companyName','totalPayment','paymentRecord','cekBon'));
        }
        elseif($status == '3' AND $countBilling >='0'){
            return view ('Cashier/cashierPrintOutKredit', compact('noBill','trStore','trStoreList','companyName', 'totalPayment','paymentRecord','cekBon'));
        }
        elseif($status == '4' AND $countBilling >='1'){
            return view ('Cashier/cashierPrintOutKredit', compact('noBill','trStore','trStoreList','companyName', 'totalPayment','paymentRecord','cekBon'));
        }
    }
    
    public function deleteAllTrx($noBill){
        DB::table('tr_store')
            ->where('billing_number',$noBill)
            ->delete();
            
        DB::table('tr_store_prod_list')
            ->where('from_payment_code',$noBill)
            ->delete();
    
    }
    
    public function tampilDataSimpan($dateTampil){
        $today = date("Y-m-d");
        $dataSaved = DB::table('view_billing_action');
        if ($dateTampil == "" OR $dateTampil == "0")
        $dataSaved = $dataSaved
            ->where('status','2');
        else{
        $dataSaved = $dataSaved
            ->where([
                ['status','2'],
                ['tr_date',$dateTampil]
            ]);
        }
        $dataSaved = $dataSaved->get();
        return view ('Cashier/cashierModalLoadDataSavedList',compact('dataSaved'));
    }
    
    public function loadDataSaved(){
        return view ('Cashier/cashierModalLoadDataSaved');
    }
    
    public function postDataClosing(Request $reqPostClosing){
        $fromdate = $reqPostClosing->fromdate;
        $enddate = $reqPostClosing->enddate;
        
        DB::table('tr_payment_record')
            ->whereBetween('date_trx',[$fromdate, $enddate])
            ->update([
                'date_closing'=>now(),
                'status'=>'2'
            ]);
    }
    
    public function cashierReportDetailPdf ($fromDate, $endDate){
        $tableReport = DB::table("trx_record_view as a")
            ->leftJoin("tr_kredit as b",'a.trx_code','=','b.from_payment_code')
            ->whereBetween('a.date_trx',[$fromDate, $endDate])
            ->get();
            
        $pdf = PDF::loadview('Report/cashierDetailReport',compact('fromDate','endDate','tableReport'))->setPaper("A4", 'landscape');
		return $pdf->stream();
    }
}
