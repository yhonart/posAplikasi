<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PurchasingController extends Controller
{
    protected $tempInv;
    protected $tempUser;  
    protected $TempInventoryController;
    protected $TempUsersController;
    protected $TempKeuanganController;

    public function __construct(TempInventoryController $tempInv, TempUsersController $tempUser, TempKeuanganController $tempKasBesar)
    {
        $this->TempInventoryController = $tempInv;
        $this->TempUsersController = $tempUser;
        $this->TempKeuanganController = $tempKasBesar;
    }

    public function getMonday (){
        $timezone = 'Asia/Jakarta';
        Carbon::setLocale('id'); 

        // Tentukan tanggal hari ini
        $today = Carbon::now($timezone);

        // Tentukan hari pertama minggu ini (Senin)
        $firstDayOfThisWeek = $today->startOfWeek(Carbon::MONDAY);

        return $firstDayOfThisWeek;
    }

    public function userApproval (){
        $userID = Auth::user()->id;
        $cekUserGroup = DB::table('users_role')
            ->where([
                ['user_id',$userID],
                ['role_code','1']
            ])
            ->count();
            
        return $cekUserGroup;
    }
    
    public function poNumber (){
        $thisMonth = date("mY");
        $name = Auth::user()->name;
        $company = Auth::user()->company;
        $monthNumber = date("my");
        $date = date('Y-m-d');
        
        $getCompany = DB::table('m_company')
            ->where('idm_company',$company)
            ->first();
        
        $cmpCode = $getCompany->company_code;
        $poNumber = DB::table('purchase_order')
            ->select('purchase_number')
            ->where([
                ['purchase_date',$date],
                ['created_by',$name],
                ['status','1'],
                ['comp_id',$company]
                ])
            ->count();
            
        if($poNumber == '0'){
            $numberByDate = DB::table('purchase_order')
                ->select('purchase_number')
                ->where([
                        ['periode',$thisMonth]
                    ])
                ->count();
                
                if($numberByDate=="0"){
                    $no = '1';
                    $nomorPembelian = "P".$cmpCode.$monthNumber."-".sprintf("%07d",$no);
                }
                else{
                    $no = $numberByDate + 1;
                    $nomorPembelian = "P".$cmpCode.$monthNumber."-".sprintf("%07d",$no);
                }
        }
        else{
            $numberExisting = DB::table('purchase_order')
                ->select('purchase_number')
                ->where([
                    ['purchase_date',$date],
                    ['created_by',$name],
                    ['status','1'],
                    ['comp_id',$company]
                    ])
                ->first();
                
            $no = $poNumber;
            $nomorPembelian = $numberExisting->purchase_number;
        }
            
        return $nomorPembelian;
    }

    public function purchaseNumber ($date){
        $thisMonth = date("mY");
        $name = Auth::user()->name;
        $company = Auth::user()->company;
        $monthNumber = date("my");

        $getCompany = DB::table('m_company')
            ->where('idm_company',$company)
            ->first();
        
        $cmpCode = $getCompany->company_code;
        $poNumber = DB::table('purchase_order')
            ->select('purchase_number')
            ->where([
                ['purchase_date',$date],
                ['created_by',$name],
                ['status','1'],
                ['comp_id',$company]
                ])
            ->count();
            
        if($poNumber == '0'){
            $numberByDate = DB::table('purchase_order')
                ->select('purchase_number')
                ->where([
                        ['periode',$thisMonth]
                    ])
                ->count();
                
                if($numberByDate=="0"){
                    $no = '1';
                    $nomorPembelian = "P".$cmpCode.$monthNumber."-".sprintf("%07d",$no);
                }
                else{
                    $no = $numberByDate + 1;
                    $nomorPembelian = "P".$cmpCode.$monthNumber."-".sprintf("%07d",$no);
                }
        }
        else{
            $numberExisting = DB::table('purchase_order')
                ->select('purchase_number')
                ->where([
                    ['purchase_date',$date],
                    ['created_by',$name],
                    ['status','1'],
                    ['comp_id',$company]
                    ])
                ->first();
                
            $no = $poNumber;
            $nomorPembelian = $numberExisting->purchase_number;
        }            
        return $nomorPembelian;
    }

    public function mainPurch(){
        $checkArea = $this->TempUsersController->checkuserInfo();
        $approval = $this->userApproval();
        $nomor = $this->poNumber();
        $todayDate = date('Y-m-d');
        $company = Auth::user()->company;

        $selectTrx = DB::table('view_purchase_order')
            ->select('purchase_number','store_name')
            ->where([
                ['faktur_date','$todayDate'],
                ['comp_id',$company]
                ])
            ->orderBy('id_purchase','desc')
            ->get();
            
        return view ('Purchasing/main', compact('checkArea','approval','selectTrx','nomor'));
    }

    //Purchase Request
    public function dataPurchasing (){
        $checkArea = $this->TempUsersController->checkuserInfo();
        $thisPeriode = date('mY');
        $todayDate = date('Y-m-d');
        $day30Ago = date('Y-m-d', strtotime('-30 days'));
        
        $sumTunai = DB::table('purchase_order')
            ->select(DB::raw('SUM(sub_total) as totalTunai'))
            ->where([
                ['periode',$thisPeriode],
                ['payment_methode','1'],
                ['status','3']
            ])
            ->orWhere([
                ['periode',$thisPeriode],
                ['payment_methode','2'],
                ['status','3']
            ])
            ->first();
        
        $sumHutang = DB::table('purchase_order')
            ->select(DB::raw('SUM(sub_total) as totalTunai'))
            ->where([
                ['payment_methode','3'],
                ['payment_status','!=','4'],
                ['status','3']
            ])
            ->first();
            
        $sum30Ago = DB::table('purchase_order')
            ->select(DB::raw('SUM(sub_total) as totalTunai'))
            ->whereBetween('purchase_date',[$day30Ago,$todayDate])
            ->where([
                ['payment_methode','3'],
                ['payment_status','4']
            ])
            ->first();
            
        $doDate = DB::table('view_purchase_order')
            ->select(DB::raw('DATEDIFF(CURDATE(), purchase_date) AS jumlahHari'), 'sub_total','tempo')
            ->where([
                ['payment_methode','3'],
                ['payment_status','!=','4']
                ])
            ->get();
            
        return view ('Purchasing/tableInfoPrc', compact('checkArea','sumTunai','sumHutang','doDate','sum30Ago'));
    }
    
    //Purchase Order
    public function addPurchasing (){
        $checkArea = $this->TempUsersController->checkuserInfo();
        $nomor = $this->poNumber();
        $code = '2';
        $date = date('Y-m-d');
        $userName = Auth::user()->name;
        $company = Auth::user()->company;        

        //menentukan awal dan akhir dalam satu minggu ini.
        $firstDayThisWeek = $this->getMonday();
        $firstDayOfLastWeek = $firstDayThisWeek->copy()->subWeek();
        $lastDayOfLastWeek = $firstDayOfLastWeek->copy()->endOfWeek(Carbon::SUNDAY);

        $StartDate = date("Y-m-d", strtotime($firstDayOfLastWeek));
        $endDate = date("Y-m-d",strtotime($lastDayOfLastWeek));

        $formActive = DB::table('purchase_order')
            ->where([
                ['status','1'],
                ['created_by',$userName],
                ['purchase_date',$date],
                ['comp_id', $company]
                ])
            ->count();
            
        $numberPurchase = DB::table('purchase_order')
            ->where([
                ['status','1'],
                ['created_by',$userName],
                ['purchase_date',$date],
                ['comp_id', $company]
                ])
            ->first();
            
        $supplier = DB::table('m_supplier')
            ->where('comp_id',$company)
            ->get();

        $bankTransfer = DB::table('m_company_payment')
            ->where('comp_id',$company)
            ->get();

        $danaKasir = DB::table('tr_payment_record as a')
            ->select(DB::raw('SUM(a.total_payment) as totKasir'), 'b.created_by')
            ->leftJoin('tr_store as b','a.trx_code','=','b.billing_number')
            ->where([
                ['a.total_payment','!=','8'],
                ['a.date_trx',$date],
                ['b.comp_id',$company]
                ])
            ->groupBy('b.created_by')
            ->get();
        
        $mTrxKasKasir = DB::table('m_trx_kas_kasir')
            ->where('comp_id',$company)
            ->first();
            
        $penggunaanDanaKasir = DB::table('tr_kas')
                ->select(DB::raw('SUM(nominal) as nominal','kas_persName'))
                ->where([
                    ['trx_code','2'],
                    ['comp_id',$company]
                    ])
                ->whereBetween('kas_date',[$StartDate,$endDate])
                ->groupBy('kas_persName')
                ->first();

        $penambahanDanaKasir = DB::table('tr_kas')
                ->select(DB::raw('SUM(nominal_modal) as nominal_modal','kas_persName'))
                ->where([
                    ['trx_code','1'],
                    ['comp_id',$company]
                    ])
                ->whereBetween('kas_date',[$StartDate,$endDate])
                ->groupBy('kas_persName')
                ->first();
        
        $Role = $this->TempUsersController->userRole();
        
        return view ('Purchasing/newPurchaseOrder', compact('danaKasir', 'mTrxKasKasir', 'penggunaanDanaKasir', 'penambahanDanaKasir', 'bankTransfer','checkArea','formActive','nomor','supplier','numberPurchase'));
    }
    
    public function notivePoint($suppID){
        $countPoint = DB::table('purchase_point')
            ->where([
                ['supplier_id',$suppID],
                ['status','1']
                ])
            ->count();
            
        $disPoint = DB::table('purchase_point')
            ->select(DB::raw('SUM(nom_return) as NumRet'))
            ->where([
                ['supplier_id',$suppID],
                ['status','3']
                ])
            ->first();

        $itemReturn = DB::table('purchase_return as a')
            ->select('a.*','b.product_name')
            ->leftJoin('m_product as b','a.product_id','=','b.idm_data_product')
            ->where([
                ['supplier_id', $suppID],
                ['status','3']
            ])
            ->get();
            
        return view ('Purchasing/notivPoint', compact('disPoint','countPoint','suppID','itemReturn'));
    }
    
    public function displayItemReturn($suppID){
        $company = Auth::user()->company;
        $itemReturn = DB::table('purchase_return as a')
            ->select('a.*','b.product_name')
            ->leftJoin('m_product as b','a.product_id','=','b.idm_data_product')
            ->where([
                ['a.supplier_id', $suppID],
                ['a.status','1']
            ])
            ->get();

        return view ('Purchasing/notivModalItem', compact('suppID','itemReturn'));
    }
    
    public function cencelInput($idNo){
        DB::table('purchase_list_order')
            ->where('purchase_number',$idNo)
            ->delete();
            
        DB::table('purchase_order')
            ->where('purchase_number',$idNo)
            ->delete();
    }
    
    public function postPenerimaan (Request $posPenerimaan){
        $noTrx = $posPenerimaan->noTrx;
        $deliveryBy = $posPenerimaan->deliveryBy;
        $methodPayment = $posPenerimaan->methodPayment;
        $tglFaktur = $posPenerimaan->tglFaktur;
        $noSj = $posPenerimaan->noSj;
        $dayKredit = $posPenerimaan->dayKredit;
        $keterangan = $posPenerimaan->keterangan;
        $supplier = $posPenerimaan->supplier;
        $dateDelivery = $posPenerimaan->dateDelivery;
        $noFaktur = $posPenerimaan->noFaktur;
        $ppn = $posPenerimaan->ppn;
        $nomPPN = $posPenerimaan->nomPPN;
        $bankAccount = $posPenerimaan->bankAccount;
        $sumberDana = explode("|", $posPenerimaan->sumberDana);
        $ketDana = $sumberDana[0];
        $nomDana = $sumberDana[1];
        $periode = date("mY");
        $hariIni = date("Y-m-d");
        $monthNumber = date("dmy", strtotime($dateDelivery));
        
        $createdBy = Auth::user()->name;
        $company = Auth::user()->company;        

        if ($dateDelivery <> $hariIni) {
            $nomorPembelian = $this->purchaseNumber($dateDelivery);
        }
        else {
            $nomorPembelian = $noTrx;
        }
        
        if($supplier == '0'){
            $msg = array('warning' => 'Nama supplier belum ada !');
        }
        else{
            if ($methodPayment=='3' OR $methodPayment=='30' OR $methodPayment=='15' OR $methodPayment=='60') {
                DB::table('purchase_kredit')
                    ->insert([
                        'number_dok'=>$nomorPembelian,
                        'supplier_id'=>$supplier,
                        'created_at'=>now(),
                        'tenor'=>$dayKredit,
                        'dok_date'=>$dateDelivery
                    ]);
            }

            DB::table('purchase_order')
                ->insert([
                    'purchase_number'=>$nomorPembelian,    
                    'periode'=>$periode,    
                    'purchase_date'=>now(),    
                    'supplier_id'=>$supplier,    
                    'delivery_by'=>$deliveryBy,    
                    'do_number'=>$noSj,    
                    'delivery_date'=>$dateDelivery,    
                    'payment_methode'=>$methodPayment,    
                    'tempo'=>$dayKredit,    
                    'faktur_number'=>$noFaktur,    
                    'faktur_date'=>$tglFaktur,    
                    'ppn_type'=>$ppn,    
                    'created_by'=>$createdBy,
                    'status'=>'1',
                    'bank_account'=>$bankAccount,
                    'description'=>$keterangan,
                    'comp_id'=>$company
                ]);
                
            DB::table('purchase_list_order')
                ->where('purchase_number',$noTrx)
                ->update([
                    'status'=>'2'
                    ]);

            if ($methodPayment == '1') {
                DB::table('purchase_dana_payment')
                    ->insert([
                        'kasir'=>$ketDana,
                        'status'=>'1',
                        'created_date'=>$hariIni,
                        'trx_date'=>$dateDelivery,
                        'purchase_number'=>$nomorPembelian,
                        'saldo_kas'=>$nomDana,
                        'kode_payment'=>'1'
                    ]);
            }
            $msg = array('success' => 'Dokumen telah berhasil dimasukkan ...');
        }
        return response()->json($msg);
    }
    
    public function tableInputBarang($dokNumber){
        $userCreated = Auth::user()->name;
        $company = Auth::user()->company;
        
        $prodName = DB::table('m_product')
            ->where('comp_id',$company)
            ->orderBy('product_name','asc')
            ->get();
            
        $warehouse = DB::table('m_site')
            ->get();
            
        $statusPurchase = DB::table('view_purchase_order')
            ->select('status','purchase_number', 'store_name')
            ->where([
                ['purchase_number',$dokNumber]
                ])
            ->first();
            
        return view ('Purchasing/tableInputBarang', compact('prodName','warehouse','statusPurchase'));
    }
    
    public function hargaSatuan($satuanUnit, $prdID){
        
        $hargaSatuan = DB::table('m_product_unit');
            $hargaSatuan = $hargaSatuan->where([
                ['core_id_product',$prdID],
                ['product_size',$satuanUnit]
            ]);
            $hargaSatuan = $hargaSatuan->first();
            
            return response()->json([
                'price' => $hargaSatuan->product_price_order,
                'discount' => '0'
            ]);
        
        return response()->json(['error' => 'Product not found'], 404);
    }
    
    public function postBarang(Request $reqPostBarang){
        $warehouse = $reqPostBarang->warehouse;
        $poVal = $reqPostBarang->poVal;
        $prdVal = $reqPostBarang->prdVal;
        $satuanVal = $reqPostBarang->satuanVal;
        $qtyVal = $reqPostBarang->qtyVal;
        $unitPrice = str_replace('.','',$reqPostBarang->unitPrice);
        $disVal = $reqPostBarang->disVal;
        $jumlahVal = str_replace('.','',$reqPostBarang->jumlahVal);
        $stockAwal = $reqPostBarang->stockA;
        $stockAkhir = $reqPostBarang->stockB;
        
        $createdBy = Auth::user()->name;
        
        $satuan = DB::table('m_product_unit')
            ->select('product_satuan')
            ->where([
                ['core_id_product',$prdVal],
                ['product_size',$satuanVal]
            ])
            ->first();
        $supplierIden = DB::table('purchase_order as a')
            ->select('a.supplier_id','b.store_name')
            ->leftJoin('m_supplier as b','a.supplier_id','=','b.idm_supplier')
            ->where('purchase_number',$poVal)
            ->first();
            
        $satuanUnit = $satuan->product_satuan;
        
        DB::table('purchase_list_order')
            ->insert([
                'product_id'=>$prdVal,
                'size'=>$satuanVal,
                'satuan'=>$satuanUnit,
                'qty'=>$qtyVal,
                'unit_price'=>$unitPrice,
                'total_price'=>$jumlahVal,
                'discount'=>$disVal,
                'warehouse'=>$warehouse,
                'created_by'=>$createdBy,
                'status'=>'1',
                'purchase_number'=>$poVal,
                'stock_awal'=>$stockAwal,
                'stock_akhir'=>$stockAkhir,
                'date_input'=>now()
            ]);

        DB::table('supplier_item')
            ->insert([
                'supplier_id'=>$supplierIden->supplier_id,
                'supplier_name'=>$supplierIden->store_name,
                'item_id'=>$prdVal,
            ]);
            
        return back();
    }
    
    public function loadBarang ($numberPO){
        $createdBy = Auth::user()->name;
        $listDataBarang = DB::table('view_purchase_lo')
            ->where([
                ['purchase_number',$numberPO]
            ])
            ->get();
            
        $mProduct = DB::table('m_product')
            ->get();
            
        $satuanBarang = DB::table('m_product_unit')
            ->select('product_satuan','product_size','core_id_product')
            ->get();
            
        $warehouse = DB::table('m_site')
            ->get();
            
        return view ('Purchasing/tableListBarang', compact('listDataBarang','mProduct','satuanBarang','warehouse','numberPO'));
    }
    
    public function tableSum($trxPO){
        // echo $trxPO;
        $sumTransaction = DB::table('view_purchase_lo')
            ->select(DB::raw('COUNT(product_id) as countProduct'),DB::raw('SUM(total_price) as subTotal'))
            ->where([
                ['purchase_number',$trxPO]
            ])
            ->first();
            
        return view ('Purchasing/sumPenerimaan', compact('sumTransaction','trxPO'));
    }
    
    public function postTableSum (Request $reqPostTableSum){
        $purchaseCode = $reqPostTableSum->purchaseCode;
        $noPO = $reqPostTableSum->noPO;
        $subTotalSatuan = str_replace('.','',$reqPostTableSum->subTotalSatuan);
        $subTotal = str_replace('.','',$reqPostTableSum->subTotal);
        $updateBy = Auth::user()->name;
        
        DB::table('purchase_order')
            ->where('purchase_number',$purchaseCode)
            ->update([
                'po_number'=>$noPO,   
                'total_satuan'=>$subTotalSatuan,   
                'sub_total'=>$subTotal,
                'status'=>'2'
            ]);

        DB::table('purchase_kredit')
            ->where('number_dok',$purchaseCode)
            ->update([
                'kredit'=>$subTotal,
                'selisih'=>$subTotal,
                'update_kredit'=>now()
            ]);

        $selectPurchase = DB::table('purchase_order')
            ->where('purchase_number',$purchaseCode)
            ->first();

        $paymentMethod = $selectPurchase->payment_methode;
        
        if ($paymentMethod == '1' OR $paymentMethod == '2') {            
            //update purchase dana pembelian 
            DB::table('purchase_dana_payment')
                ->where([
                    ['purchase_number',$noPO],
                    ['kode_payment','1'],
                    ['status','1']
                ])
                ->update([
                    'nominal'=>$subTotal,
                    'status'=>'2'
                ]);
        }
    }
    
    public function tablePenerimaan($status, $fromDate, $endDate){
        $approval = $this->userApproval();
        $company = Auth::user()->company;

        $listTablePem = DB::table('view_purchase_order');
        $listTablePem = $listTablePem->where([
            ['status',$status],
            ['comp_id',$company]
        ]);
            if ($fromDate <> '0' AND $endDate <> '0') {
                $listTablePem = $listTablePem->whereBetween('purchase_date',[$fromDate,$endDate]);
            }
            $listTablePem = $listTablePem->orderBy('id_purchase','desc');
            $listTablePem = $listTablePem->get();

        //Chek potongan
        $detailPotongan = DB::table('purchase_point')
            ->select(DB::raw('SUM(nom_return) as NumRet'),'supplier_id')
            ->where([
                ['status','3']
            ])
            ->groupBy('supplier_id')
            ->get();

        return view ('Purchasing/tablePenerimaan', compact('listTablePem','approval','status','fromDate','endDate','detailPotongan'));
    }

    public function modalVoucher($supID, $purchNumber){
        $disPoint = DB::table('purchase_point')
            ->select(DB::raw('SUM(nom_return) as NumRet'))
            ->where([
                ['supplier_id',$supID],
                ['status','3']
                ])
            ->first();

        $itemReturn = DB::table('purchase_return as a')
            ->select('a.*','b.product_name')
            ->leftJoin('m_product as b','a.product_id','=','b.idm_data_product')
            ->where([
                ['supplier_id', $supID],
                ['status','3']
            ])
            ->get();

        $itemByNumber = DB::table('purchase_point')
            ->select(DB::raw('SUM(nom_return) as NumRet'),'purchase_number')
            ->where([
                ['supplier_id',$supID],
                ['status','3']
            ])
            ->groupBy('purchase_number')
            ->get();
        
        return view ('Purchasing/modalVoucher', compact('disPoint','itemReturn','supID','itemByNumber','purchNumber'));        
    }

    //Purchase Dashboard
    public function mainDashboard (){
        $checkArea = $this->TempUsersController->checkuserInfo();
    }
    
    public function modalPenerimaanPO ($poNumber){
        $modalDetailPO = DB::table('view_purchase_order')
            ->where('purchase_number',$poNumber)
            ->first();
        $modalDetailBarang = DB::table('view_purchase_lo')
            ->where('purchase_number',$poNumber)
            ->get();
            
        return view ('Purchasing/Modal/modalPurchaseDetail', compact('modalDetailPO','modalDetailBarang'));
    }
    public function modalSupplier ($supplierID){
        echo $supplierID;
    }
    
    public function editTablePO($dataEdit){
        $editPurchase = DB::table('view_purchase_order')
            ->where('purchase_number',$dataEdit)
            ->first();
        $editPurchaseDetail = DB::table('view_purchase_lo')
            ->where('purchase_number',$dataEdit)
            ->get();
        $supplier = DB::table('m_supplier')
            ->get();
            
        $prodName = DB::table('m_product')
            ->get();
            
        $warehouse = DB::table('m_site')
            ->get();
            
        return view ('Purchasing/tableEditPenerimaan', compact('editPurchase','editPurchaseDetail','supplier','prodName','warehouse','dataEdit'));
    }
    
    public function btnApprove($dataEdit){
        $company = Auth::user()->company;

        $dblp = DB::table('view_purchase_lo')
            ->where('purchase_number',$dataEdit)
            ->get();
            
        $idDataReport = DB::table('view_purchase_order')
            ->where('purchase_number',$dataEdit)
            ->first();

        foreach($dblp as $pl){
            $productID = $pl->product_id;
            $satuan = $pl->size;
            $qty = $pl->stock_akhir;
            $location = $pl->warehouse;
            $qtyInput = $pl->qty;

            //INPUT REPORT
            $numberCode = $dataEdit;
            $description = "Pembelian ".$idDataReport->store_name;            
            $loc = $pl->warehouse;
            $prodName = $pl->product_name;
            $createdBy = Auth::user()->name;
            
            $mProduct = DB::table('m_product')
                ->where('idm_data_product',$productID)
                ->first();

            $volB = $mProduct->large_unit_val;
            $volK = $mProduct->medium_unit_val;
            $volKonv = $mProduct->small_unit_val;
            $prodName = $pl->product_name;
            $satuan = $pl->size;

            $selectSizeCode = DB::table('m_product_unit')
                ->where([
                    ['core_id_product', $productID],
                    ['product_size',$satuan]
                ])
                ->first();

            $sizeCode = $selectSizeCode->size_code;

            $mUnit = DB::table('m_product_unit')
                ->select('size_code','product_volume','idm_product_satuan')
                ->where('core_id_product',$productID)
                ->orderBy('size_code','desc')
                ->first();

            $sizeCodeDesc = $mUnit->size_code; 
            
            if ($sizeCodeDesc == '1') {
                $ls = $qtyInput;
            }
            elseif ($sizeCodeDesc == '2') {
                if ($satuan == "BESAR") {
                    $ls1 = $qtyInput * $volB;
                    $ls = (int)$ls1;
                }
                elseif ($satuan == "KECIL") {
                    $ls = $qtyInput;
                }
            }
            elseif ($sizeCodeDesc == '3') {
                if ($satuan == "BESAR") {
                    $ls1 = $qtyInput * $volKonv;
                    $ls = (int)$ls1;
                }
                elseif ($satuan == "KECIL") {
                    $ls1 = $qtyInput * $volK;
                    $ls = (int)$ls1;
                }
                elseif ($satuan == "KONV") {
                    $ls = $qtyInput;
                }
            }            
            $outInv = '0';
            $selectLastStock = DB::table('inv_stock')
                ->where([
                    ['product_id',$mUnit->idm_product_satuan],
                    ['location_id',$loc]
                ])
                ->first();

            $purchasingDate = $idDataReport->delivery_date;            
            $dateNow = date("Y-m-d");

            $inInv = $ls;
                $saldo = $inInv + $selectLastStock->stock;
                $volPrd = $selectSizeCode->product_volume;
                //Query insert into report
                DB::table('report_inv')
                    ->insert([
                        'date_input'=>$purchasingDate,
                        'number_code'=>$numberCode,
                        'product_id'=>$productID,
                        'product_name'=>$prodName,
                        'satuan'=>$satuan,
                        'satuan_code'=>$sizeCodeDesc,
                        'description'=>$description,
                        'inv_in'=>$inInv,
                        'inv_out'=>$outInv,
                        'saldo'=>$saldo,
                        'created_by'=>$createdBy,
                        'location'=>$loc,
                        'vol_prd'=>$volPrd,
                        'last_saldo'=>$pl->stock_awal,
                        'actual_input'=>$pl->qty,
                        'status_trx'=>'4',
                        'comp_id'=>$company
                    ]);
            //UPDATE STOCK;            
            $updateInv = $this->TempInventoryController->tambahStock($productID, $qtyInput, $satuan, $location);
        }

        $sumPembelian = DB::table('purchase_list_order')
            ->select(DB::raw('SUM(total_price) as sumPrice'), DB::raw('COUNT(product_id) as jumlahProduk'))
            ->where('purchase_number',$dataEdit)
            ->first();

        //update table purchase_order
        DB::table('purchase_order')
            ->where('purchase_number',$dataEdit)
            ->update([
                'status'=>'3',
                'sub_total'=>$sumPembelian->sumPrice,
                'total_satuan'=>$sumPembelian->jumlahProduk
                ]);
                
        DB::table('purchase_list_order')
            ->where('purchase_number',$dataEdit)
            ->update([
                'status'=>'3'
                ]);
        $updateBy = $idDataReport->created_by;
        $subTotal = (int)$idDataReport->sub_total - (int)$idDataReport->total_potongan;
        if ($idDataReport->payment_methode == '1' OR $idDataReport->payment_methode == '2') {
            $this->TempKeuanganController->kasBesarPembelian ($subTotal, $updateBy, $dataEdit);
        }
    }

    public function btnDelete ($dataDelete){
        DB::table('purchase_order')
            ->where('purchase_number',$dataDelete)
            ->update([
                'status'=>'0'
            ]);

        DB::table('purchase_list_order')
            ->where('purchase_number',$dataDelete)
            ->update([ 
                'status'=>'0'
            ]);
    }
    
    public function Bayar ($supplier, $fromDate, $endDate){
        $company = Auth::user()->company;
        $supKredit = DB::table('purchase_kredit as a');
        $supKredit = $supKredit->select('a.*','b.store_name');
        $supKredit = $supKredit->leftJoin('m_supplier as b', 'a.supplier_id','=','b.idm_supplier');
        if ($fromDate <> 0 AND $endDate <> 0 AND $supplier <> 0) {
            $supKredit = $supKredit->where([
                ['supplier_id',$supplier]
            ]);
        }
        elseif ($supplier == 0 AND $fromDate<>0 AND $endDate<>0) {
            $supKredit = $supKredit->whereBetween('dok_date',[$fromDate,$endDate]);
        }
        elseif ($supplier <> 0 AND $fromDate==0 AND $endDate==0) {
            $supKredit = $supKredit->where([
                ['supplier_id',$supplier]
            ]);
        }
        else {
            $supKredit = $supKredit->where([
                ['selisih','!=','0']
            ]);
        }
        $supKredit = $supKredit->where('comp_id',$company);
        $supKredit = $supKredit->get();
            
        return view ('Purchasing/PurchaseOrder/tableListBayar', compact('supKredit'));
    }
    
    public function payPost(Request $reqPost){
        $table = $reqPost->tablename;
        $column = $reqPost->column;
        $editval = str_replace(".","",$reqPost->editval);
        $id = $reqPost->id;
        $idKredit = $reqPost->idKredit;  
        
        $createdBy = Auth::user()->name;
        $dateNow = date("Y-m-d");
        $dateNo = date("mY");

        $payKredit = DB::table('purchase_kredit')
            ->where('idp_kredit',$id)
            ->first();
        $purchaseNumber = $payKredit->number_dok;

        $payNumber = DB::table('purchase_kredit_payment')
            ->where([
                ['payment_date',$dateNow]
            ])
            ->count();

        if ($payNumber == 0) {
            $no = 1;
            $numberTrx = "AP".$dateNo."-".sprintf("%07d", $no);
        }
        else {
            $no = $payNumber+1;
            $numberTrx = "AP".$dateNo."-".sprintf("%07d", $no);
        }

        if($editval <> '' OR $editval <> '0'){
            DB::table($table)
                ->where($idKredit,$id)
                ->update([
                    $column=>$editval
                ]);

            DB::table('purchase_kredit_payment')
                ->insert([
                    'nomor'=>$numberTrx,
                    'kredit_pay'=>$editval,
                    'created_at'=>now(),
                    'created_by'=>$createdBy,
                    'status'=>1,
                    'purchase_number'=>$purchaseNumber
                ]);
        }
    }
    
    public function modalMethod ($id){  
        $dateNow = date("Y-m-d");
        $dateNo = date("mY");
        $company = Auth::user()->company;

        $datPayment = DB::table('purchase_kredit as a')
            ->select('a.*','b.store_name')
            ->leftJoin('m_supplier as b','a.supplier_id','=','b.idm_supplier')
            ->where('idp_kredit',$id)
            ->first();
        
        $payNumber = DB::table('purchase_kredit_payment')
            ->where([
                ['payment_date',$dateNow],
                ['comp_id',$company]
            ])
            ->count();
        $compCode = DB::table('m_company')
            ->where('idm_company', $company)
            ->first();

        $compC = $compCode->company_code;

        if ($payNumber == 0) {
            $no = 1;
            $numberTrx = "AP-". $compC . $dateNo ."-". sprintf("%07d", $no);
        }
        else {
            $no = $payNumber+1;
            $numberTrx = "AP-". $compC . $dateNo ."-". sprintf("%07d", $no);
        }

        $purchaseNumber = $datPayment->number_dok;
            
        $tbPayment = DB::table('purchase_kredit_payment')
            ->where([
                ['purchase_number',$purchaseNumber]
                ])
            ->first();

        $sumberKas = DB::table('tr_store')
            ->select(DB::raw('SUM(t_pay) AS kasUmum'), 'created_by')
            ->where([
                ['tr_date',$dateNow],
                ['status','4'],
                ['comp_id',$company]
            ])
            ->groupBy('created_by')
            ->get();

        $accountBank = DB::table('m_company_payment')
            ->where('comp_id',$company)
            ->get();


        return view ('Purchasing/PurchaseOrder/modalBayar', compact('tbPayment','datPayment','id','numberTrx','sumberKas','accountBank'));
    }
    
    public function postModalPembayaran (Request $reqPostPayment){        
        $kreditId = $reqPostPayment->idKredit;        
        $apNumber = $reqPostPayment->apNumber;
        $purchaseNumber = $reqPostPayment->purchaseNumber;
        $nominalKredit = str_replace(".","",$reqPostPayment->nominalKredit);        
        $nominal = str_replace(".","",$reqPostPayment->nominal);
        $selisih = str_replace(".","",$reqPostPayment->selisih);
        $method = $reqPostPayment->method;
        $account = $reqPostPayment->account;
        $accountName = $reqPostPayment->accountName;
        $accountNumber = $reqPostPayment->accountNumber;
        $description = $reqPostPayment->description;
        $createdBy = Auth::user()->name;
        $payed = $reqPostPayment->nominalPayed;       

        if($selisih == '0'){
            $status = '4';
        }else{
            $status = '1';
        }       
        $nominalPayed = (int)$payed + (int)$nominal;
        DB::table('purchase_kredit')
            ->where('idp_kredit',$kreditId)
            ->update([
                'payed'=>$nominalPayed,
                'selisih'=>$selisih,
                'last_payed'=>$nominal,
                'update_kredit'=>now()
            ]);

        DB::table('purchase_kredit_payment')
            ->insert([
                'nomor'=>$apNumber,
                'kredit_pay'=>$nominal,
                'methode'=>$method,
                'from_account'=>$account,
                'account'=>$account,
                'number_account'=>$accountNumber,
                'created_at'=>now(),
                'created_by'=>$createdBy,
                'status'=>"1",
                'selisih'=>$selisih,
                'description'=>$description,
                'selisih'=>$selisih,
                'payment_date'=>now(),
                'purchase_number'=>$purchaseNumber                
            ]);
            
        DB::table('purchase_order')
            ->where('purchase_number',$purchaseNumber)
            ->update([
                'payment_status'=>$status    
            ]);

        $this->TempKeuanganController->kasBesarPembelian ($nominal, $createdBy, $purchaseNumber);
    }

    public function postSumberDana(Request $reqPostDana){
        $kasir = $reqPostDana->kasir;
        $apNumber = $reqPostDana->apNumber;
        $purchaseNumber = $reqPostDana->purchaseNumber;
        $pembayaran = str_replace(".", "", $reqPostDana->nominal);
        $dateNow = date("Y-m-d");
        
        $danakas = DB::table('tr_store')
            ->select(DB::raw('SUM(t_pay) AS kasUmum'), 'created_by')
            ->where([
                ['created_by',$kasir],
                ['status','4'],
                ['tr_date',$dateNow]
            ])
            ->groupBy('created_by')
            ->first();
        $danaTersedia = $danakas->kasUmum;
        $lastDana = DB::table('purchase_dana_payment')
            ->select(DB::raw('SUM(nominal) as nominal'), 'kasir')
            ->where([
                ['ap_number',$apNumber],
                ['purchase_number',$purchaseNumber],
                ['status','!=','0']
            ])
            ->first();

        if (!empty($lastDana)) {
            $danaPertama = (int)$pembayaran - (int)$lastDana->nominal;
        }
        else {
            $danaPertama = '0';
        }  
        $nominalKas = (int)$pembayaran - (int)$lastDana->nominal;   
        $saldoKas = (int)$danaTersedia - (int)$danaPertama;
        
        if ($lastDana->kasir <> $kasir AND $kasir <> '0') {
            DB::table('purchase_dana_payment')
                ->insert([
                    'kasir'=>$kasir,
                    'nominal'=>$nominalKas,
                    'status'=>'1',
                    'created_date'=>now(),
                    'trx_date'=>now(),
                    'ap_number'=>$apNumber,
                    'purchase_number'=>$purchaseNumber,
                    'saldo_kas'=>$saldoKas
                ]);
        }
    }

    public function getDisplaySumberDana($kasir, $apNumber, $purchaseNumber){
        //Cek ketersedian nama kasir di dalam dana 
        
        $tableDana = DB::table('purchase_dana_payment')
            ->where([
                ['ap_number',$apNumber],
                ['purchase_number',$purchaseNumber],
                ['status','1']
            ])
            ->get();

        return view('Purchasing/PurchaseOrder/modalBayarDisDana',compact('kasir','tableDana','apNumber','purchaseNumber'));
    }

    public function deleteDana($danaId){
        DB::table('purchase_dana_payment')
            ->where('id_dana',$danaId)
            ->update([
                'status'=>'0'
            ]);
    }

    public function modalDetailKredit($id){
        $numberDok = DB::table('purchase_kredit')
            ->select('number_dok')
            ->where('idp_kredit',$id)
            ->first();

        return view('Purchasing/PurchaseOrder/modalDetailKreditMain',compact('id','numberDok'));
    }
    
    public function lastPayment (){
        $tbPurchase = DB::table('view_purchase_order')
            ->where([
                ['payment_methode','3'],
                ['payment_status','4']
                ])
            ->get();
            
        $paymentKredit = DB::table('purchase_kredit_payment')
            ->select(DB::raw('SUM(kredit_pay) as payed', 'nomor','idp_pay'))
            ->groupBy('nomor')
            ->get();
            
        return view ('Purchasing/PurchaseOrder/tableListBayarHutang', compact('tbPurchase','paymentKredit'));
    }
    
    public function stockIden($gudang, $satuan, $product){
        $munit = DB::table('m_product_unit')
            ->select('idm_product_satuan')
            ->where([
                ['core_id_product',$product],
                ['product_size',$satuan]
                ])
            ->first();
            
        $stockGdg = DB::table('inv_stock')
            ->select('stock')
            ->where([
                ['product_id',$munit->idm_product_satuan],
                ['location_id',$gudang]
                ])
            ->first();
        if(!empty($stockGdg)){
            return response()->json([
                'stock' => $stockGdg->stock,
            ]);
        }
        else{
            return response()->json([
                'stock' => '0',
            ]);
        }
        
        return response()->json(['error' => 'Product not found'], 404);
    }
    
    public function deleteItem($idItem){
        DB::table('purchase_list_order')
            ->where('id_lo',$idItem)
            ->delete();
    }
    
    public function updateOnChange(Request $reqChange){
        $tableName = $reqChange->tablename;
        $column = $reqChange->column;
        $editval = $reqChange->editval;
        $id = $reqChange->id;
        $idChange = $reqChange->idChange;
        
        $lastInput = DB::table('purchase_list_order')
            ->where('id_lo',$id)
            ->first();
            
        if($column == "qty"){
            $b = $lastInput->stock_awal + $editval;
            $totHrg = $lastInput->unit_price * $editval;
            
            DB::table('purchase_list_order')
                ->where('id_lo',$id)
                ->update([
                    'qty'=>$editval,
                    'stock_akhir'=>$b,
                    'total_price'=>$totHrg
                ]);
            
        }
        elseif($column == "warehouse"){
            $loc = $editval;
            $prd = $lastInput->product_id;
            $size = $lastInput->size;
            $qty = $lastInput->qty;
            
            // cek stock di lokasi
            $stockLoc = DB::table('view_product_stock')
                ->where([
                    ['idm_data_product',$prd],
                    ['product_size',$size],
                    ['location_id',$loc]
                    ])
                ->first();

            // cek harga satuan 
            $dbHrg = DB::table('product_list_view')
                ->where([
                    ['core_id_product',$prd],
                    ['product_size',$size]
                    ])
                ->first();
                    
            $stock = $stockLoc->stock;
            $satuanHrg = $dbHrg->product_price_order;
            
            //hitung stock akhir 
            if ($stock <= '0') {
                $stockAkhir = $qty;
            }
            else {
                $stockAkhir = $qty + $stock;
            }
            
            //hitung harga
            $harga = $satuanHrg * $qty;
            
            // update data
            DB::table('purchase_list_order')
                ->where('id_lo',$id)
                ->update([
                    'qty'=>$qty,
                    'stock_awal'=>$stock,
                    'stock_akhir'=>$stockAkhir,
                    'unit_price'=>$satuanHrg,
                    'total_price'=>$harga,
                    'warehouse'=>$loc
                    ]);
            
            
        }
        elseif($column == "size"){
            $loc = $lastInput->warehouse;
            $prd = $lastInput->product_id;
            $size = $editval;
            $qty = $lastInput->qty;
            
            // cek stock di lokasi
            $stockLoc = DB::table('view_product_stock')
                ->where([
                    ['idm_data_product',$prd],
                    ['product_size',$size],
                    ['location_id',$loc]
                    ])
                ->first();
                
            // cek harga satuan 
            $dbHrg = DB::table('product_list_view')
                ->where([
                    ['core_id_product',$prd],
                    ['product_size',$size]
                    ])
                ->first();
                
            $stock = $stockLoc->stock;
            $satuanHrg = $dbHrg->product_price_order;
            $satuanInput = $dbHrg->product_satuan;
            
            //hitung stock akhir 
            $stockAkhir = $qty + $stock;
            
            //hitung harga
            $harga = $satuanHrg * $qty;
            
            // update data
            DB::table('purchase_list_order')
                ->where('id_lo',$id)
                ->update([
                    'size'=>$size,
                    'satuan'=>$satuanInput,
                    'qty'=>$qty,
                    'stock_awal'=>$stock,
                    'stock_akhir'=>$stockAkhir,
                    'unit_price'=>$satuanHrg,
                    'total_price'=>$harga
                    ]);
            
        }
    }
    
    public function getAutoPrice($prdID){
        
        $sizeProd = DB::table('m_product_unit')
            ->select('product_size','product_price_order')
            ->where([
                ['core_id_product',$prdID],
                ['size_code','1']
                ])
            ->first();
        $priceOrder = $sizeProd->product_price_order;
        return response()->json([
                'price' => $priceOrder,
                'discount' => '0'
            ]);

        // return view ('Cashier/cashierProductListHarga', compact('hargaSatuan'));
        return response()->json(['error' => 'Product not found'], 404);
    }

    public function postEditDocPenerimaan(Request $reqEditDoc){
        $updateBy = Auth::user()->name;
        DB::table('purchase_order')
            ->where('id_purchase',$reqEditDoc->purchaseID)
            ->update([
                'supplier_id'=>$reqEditDoc->supplier,
                'purchase_date'=>$reqEditDoc->tglTrx,
                'delivery_by'=>$reqEditDoc->deliveryBy,
                'delivery_date'=>$reqEditDoc->dateDelivery,
                'payment_methode'=>$reqEditDoc->methodPayment,
                'tempo'=>$reqEditDoc->dayKredit,
                'faktur_number'=>$reqEditDoc->noFaktur,
                'faktur_date'=>$reqEditDoc->tglFaktur,
                'ppn_type'=>$reqEditDoc->ppn,
                'updated_date'=>now(),
                'updated_by'=>$updateBy
            ]);
    }

    public function piutangSupplier (){
        return view ('Purchasing/PurchaseOrder/mainPiutangSupplier');
    }

    public function inputPembayaran (){
        $company = Auth::user()->company;
        $mSupplier = DB::table('m_supplier')
            ->where('comp_id',$company)
            ->get();

        return view('Purchasing/PurchaseOrder/pembayaran', compact('mSupplier'));
    }
    
    public function metodePembayaran ($supplier)
    {
        $mSupplier = DB::table('m_supplier')
            ->where('idm_supplier',$supplier)
            ->first();

        return view ('Purchasing/selectMetodePembayaran', compact('mSupplier'));
    }

    public function collapseDokumen ($dokNumber){
        $numberPurchase = DB::table('purchase_order as a')
            ->select('a.*','b.store_name')
            ->leftJoin('m_supplier as b','a.supplier_id','=','b.idm_supplier')
            ->where('purchase_number',$dokNumber)
            ->first();

        $supplier = DB::table('m_supplier')
            ->get();

        $mBankAccount = DB::table('m_company_payment')
            ->get();

        return view('Purchasing/newPurchaseOrderCollapse', compact('numberPurchase','supplier','mBankAccount'));
    }

    public function historyPembayaran (){
        $company = Auth::user()->company;
        $mSupplier = DB::table('m_supplier')
            ->where('comp_id',$company)
            ->get();

        return view('Purchasing/PurchaseOrder/historyPembayaran', compact('mSupplier'));
    }

    public function filteringHistory ($supplier, $fromDate, $endDate, $status){  
        $company = Auth::user()->company;

        $disHistory = DB::table('purchase_kredit_payment as a');
        $disHistory = $disHistory->leftJoin('view_purchase_order as b','a.purchase_number','=','b.purchase_number');
        if ($supplier <> 0 AND $fromDate <> 0 AND $endDate <> 0 AND $status <> 0) {
            $disHistory = $disHistory->where([
                ['b.supplier_id',$supplier],
                ['b.payment_status',$status]
            ]);
            $disHistory = $disHistory->whereBetween('a.payment_date',[$fromDate, $endDate]);
        }
        elseif ($supplier == 0 AND $fromDate <> 0 AND $endDate <> 0 AND $status <> 0) {
            $disHistory = $disHistory->where([
                ['b.payment_status',$status]
            ]);
            $disHistory = $disHistory->whereBetween('a.payment_date',[$fromDate, $endDate]);
        }
        elseif ($supplier == 0 AND $fromDate == 0 AND $endDate == 0 AND $status <> 0) {
            $disHistory = $disHistory->where([
                ['b.payment_status',$status]
            ]);
        }
        $disHistory = $disHistory->where('b.comp_id',$company);
        $disHistory = $disHistory->limit(100);
        $disHistory = $disHistory->orderBy('a.idp_pay','desc');
        $disHistory = $disHistory->get();

        return view('Purchasing/PurchaseOrder/historyPembayaranTable', compact('disHistory'));
        
    }

    public function detailPembayaran ($id){
        $pembayaran = DB::table('purchase_kredit_payment')
            ->where('idp_pay',$id)
            ->first();

        $noPembelian = $pembayaran->purchase_number;
        $purchaseOrder = DB::table('purchase_order')
            ->where('purchase_number',$noPembelian)
            ->first();

        $historyPm = DB::table('purchase_kredit_payment')
            ->where('purchase_number',$noPembelian)
            ->orderBy('idp_pay','asc')
            ->get();

        return view('Purchasing/PurchaseOrder/historyPembayaranDetail', compact('id','pembayaran','purchaseOrder','historyPm'));
    }

    public function cetakPembayaran ($id){
        $pembayaran = DB::table('purchase_kredit_payment')
            ->where('idp_pay',$id)
            ->first();

        $noPembelian = $pembayaran->purchase_number;

        $purchaseOrder = DB::table('view_purchase_order')
            ->where('purchase_number',$noPembelian)
            ->first();

        return view('Purchasing/PurchaseOrder/historyPembayaranCetak', compact('id','pembayaran','purchaseOrder'));
    }

    public function modalDetailKreditPembayaran($id, $noDok){
        $tbPembayaran = DB::table('purchase_kredit_payment')
            ->where('purchase_number',$noDok)
            ->get();
        return view('Purchasing/PurchaseOrder/modalDetailKreditPembayaran', compact('tbPembayaran','noDok'));                
    }

    public function potonganHarga($id){
        DB::table('purchase_point')
            ->where('supplier_id',$id)
            ->update([
                'status'=>'4',
                'action_by'=>'1'
            ]);
    }

    public function penggantianBarang($id){
        DB::table('purchase_point')
            ->where('supplier_id',$id)
            ->update([
                'status'=>'4',
                'action_by'=>'2'
            ]);
    }

    public function penggantianNomorInvoice($purchNumber, $orderNumber){
        $sumPembayaran = DB::table('purchase_point')
            ->select(DB::raw('SUM(nom_return) as NumRet'))
            ->where('purchase_number',$purchNumber)
            ->first();

        $total = $sumPembayaran->NumRet;

        DB::table('purchase_order')
            ->where('purchase_number',$orderNumber)
            ->update([
                'total_potongan'=>$total,
                'voucher'=>'1'
            ]);

        DB::table('purchase_point')
            ->where('purchase_number',$purchNumber)
            ->update([
                'status'=>'4',
                'action_by'=>'1'
            ]);

        DB::table('purchase_return')
            ->where('purchase_number',$purchNumber)
            ->update([
                'status'=>'4'
            ]);
    }

    public function printPurchase ($poNumber)
    {
        $purchaseOrder = DB::table('view_purchase_order as a')
            ->leftJoin('m_company_payment as b','a.bank_account','=','b.idm_payment')
            ->where('purchase_number',$poNumber)
            ->first();

        $purchaseListOrder = DB::table('view_purchase_lo')
            ->where([
                ['purchase_number',$poNumber],
                ['status','!=','0']
                ])
            ->get();

        $pdf = PDF::loadview('Purchasing/cetakPurchaseOrder', compact('purchaseOrder', 'purchaseListOrder'))->setPaper("A4", 'landscape');
        return $pdf->stream();  
    }
}
