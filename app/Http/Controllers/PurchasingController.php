<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PurchasingController extends Controller
{
    protected $tempInv;
    protected $tempUser;  
    protected $TempInventoryController;
    protected $TempUsersController;

    public function __construct(TempInventoryController $tempInv, TempUsersController $tempUser)
    {
        $this->TempInventoryController = $tempInv;
        $this->TempUsersController = $tempUser;
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
        $monthNumber = date("dmy");
        $date = date('Y-m-d');
        
        
        $poNumber = DB::table('purchase_order')
            ->select('purchase_number')
            ->where([
                ['purchase_date',$date],
                ['created_by',$name],
                ['status','1']
                ])
            ->count();
            
        if($poNumber == '0'){
            $numberByDate = DB::table('purchase_order')
                ->select('purchase_number')
                ->where([
                        ['purchase_date',$date]
                    ])
                ->count();
                
                if($numberByDate=="0"){
                    $no = '1';
                    $nomorPembelian = "PB-".$monthNumber."-".sprintf("%07d",$no);
                }
                else{
                    $no = $numberByDate + 1;
                    $nomorPembelian = "PB-".$monthNumber."-".sprintf("%07d",$no);
                }
        }
        else{
            $numberExisting = DB::table('purchase_order')
                ->select('purchase_number')
                ->where([
                    ['purchase_date',$date],
                    ['created_by',$name],
                    ['status','1']
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
        $selectTrx = DB::table('view_purchase_order')
            ->select('purchase_number','store_name')
            ->where('faktur_date','$todayDate')
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
        
        $formActive = DB::table('purchase_order')
            ->where([
                ['status','1'],
                ['created_by',$userName],
                ['purchase_date',$date]
                ])
            ->count();
            
        $numberPurchase = DB::table('purchase_order')
            ->where('status','1')
            ->first();
            
        $supplier = DB::table('m_supplier')
            ->get();
        
        $Role = $this->TempUsersController->userRole();
        
        return view ('Purchasing/newPurchaseOrder', compact('checkArea','formActive','nomor','supplier','numberPurchase'));
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
                ['status','1']
                ])
            ->first();
            
        return view ('Purchasing/notivPoint', compact('disPoint','countPoint'));
    }
    
    public function cencelInput($idNo){
        $listDataPrd = DB::table('purchase_list_order')
            ->where('purchase_number',$idNo)
            ->delete();
            
        $listDataPrd = DB::table('purchase_order')
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
        
        $periode = date("mY");
        $createdBy = Auth::user()->name;
        
        if($supplier == '0'){
            $msg = array('warning' => 'Nama supplier belum ada !');
        }
        else{
            DB::table('purchase_order')
                ->insert([
                    'purchase_number'=>$noTrx,    
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
                    'status'=>'1'
                ]);
                
            DB::table('purchase_list_order')
                ->where('purchase_number',$noTrx)
                ->update([
                    'status'=>'2'
                    ]);
            $msg = array('success' => 'Dokumen telah berhasil dimasukkan ...');
        }
        return response()->json($msg);
    }
    
    public function tableInputBarang($dokNumber){
        $userCreated = Auth::user()->name;
        
        $prodName = DB::table('m_product')
            ->orderBy('product_name','asc')
            ->get();
            
        $warehouse = DB::table('m_site')
            ->get();
            
        $statusPurchase = DB::table('view_purchase_order')
            ->select('status','purchase_number', 'store_name')
            ->where([
                ['purchase_number',$dokNumber]
                // ['created_by',$userCreated]
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
        
        DB::table('purchase_order')
            ->where('purchase_number',$purchaseCode)
            ->update([
                'po_number'=>$noPO,   
                'total_satuan'=>$subTotalSatuan,   
                'sub_total'=>$subTotal,
                'status'=>'2'
            ]);
    }
    
    public function tablePenerimaan($status, $fromDate, $endDate){
        $approval = $this->userApproval();

        $listTablePem = DB::table('view_purchase_order');
        $listTablePem = $listTablePem->where('status',$status);
            if ($fromDate <> '0' AND $endDate <> '0') {
                $listTablePem = $listTablePem->whereBetween('purchase_date',[$fromDate,$endDate]);
            }
            $listTablePem = $listTablePem->orderBy('id_purchase','desc');
            $listTablePem = $listTablePem->get();
            
        return view ('Purchasing/tablePenerimaan', compact('listTablePem','approval','status','fromDate','endDate'));
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

            $inInv = $ls;
            $outInv = '0';


            $selectLastStock = DB::table('inv_stock')
                ->where([
                    ['product_id',$mUnit->idm_product_satuan],
                    ['location_id',$loc]
                ])
                ->first();

            $purchasingDate = $idDataReport->delivery_date;
            $dateNow = date("Y-m-d");

            if ($purchasingDate < $dateNow) {
                // Jika backdate input tanggal.
                $repotInv = DB::table('report_inv')
                    ->where('date_input','>',$purchasingDate)
                    ->get();

                foreach ($repotInv as $RI) {
                    $endSaldo = $RI->saldo;
                    $updateSaldo = $endSaldo + $inInv;
                    $idUpdate = $RI->idr_inv;

                    DB::table('report_inv')
                        ->where('idr_inv',$idUpdate)
                        ->update([
                            'saldo'=>$updateSaldo
                        ]);
                }
            }
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
                    'status_trx'=>'4'
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
    
    public function Bayar (){
        $tbPurchase = DB::table('view_purchase_order')
            ->where([
                ['payment_methode','3'],
                ['payment_status','1']
                ])
            ->get();

        $payed = DB::table('purchase_kredit_payment')
            ->select(DB::raw('SUM(kredit_pay) as kreditPayed'),'nomor','idp_pay')
            ->groupBy('nomor')
            ->get();
            
        return view ('Purchasing/PurchaseOrder/tableListBayar', compact('tbPurchase','payed'));
    }
    
    public function payPost(Request $reqPost){
        $table = $reqPost->tablename;
        $column = $reqPost->column;
        $editval = str_replace(".","",$reqPost->editval);
        $id = $reqPost->id;
        $idKredit = $reqPost->idKredit;
        
        $cekInput = DB::table('purchase_kredit_payment')
            ->where([
                ['nomor',$id],
                ['status','0']
                ])
            ->count();
            
        if($cekInput == '0' AND ($editval <> '' OR $editval <> '0')){
            DB::table($table)
                ->insert([
                    $column => $editval,
                    'nomor' => $id
                ]);
        }
    }
    
    public function modalMethod ($id){
        $datPayment = DB::table('purchase_order')
            ->where('purchase_number',$id)
            ->first();
            
        $tbPayment = DB::table('purchase_kredit_payment')
            ->where([
                ['nomor',$id],
                ['status','0']
                ])
            ->first();
            
        return view ('Purchasing/PurchaseOrder/modalBayar', compact('tbPayment','datPayment','id'));
    }
    
    public function postModalPembayaran (Request $reqPostPayment){
        $idPayment = $reqPostPayment->idPayment;
        $purchaseNumber = $reqPostPayment->purchaseNumber;
        $nominalKredit = str_replace(".","",$reqPostPayment->nominalKredit);
        $nominal = str_replace(".","",$reqPostPayment->nominal);
        $selisih = str_replace(".","",$reqPostPayment->selisih);
        $method = $reqPostPayment->method;
        $account = $reqPostPayment->account;
        $accountName = $reqPostPayment->accountName;
        $accountNumber = $reqPostPayment->accountNumber;
        
        if($selisih == '0'){
            $status = '4';
        }else{
            $status = '1';
        }
        DB::table('purchase_kredit_payment')
            ->where('idp_pay',$idPayment)
            ->update([
                'kredit_pay'=>$nominal,   
                'methode'=>$method,   
                'account'=>$account,   
                'number_account'=>$accountNumber,   
                'selisih'=>$selisih,   
                'status'=>$status,   
            ]);
            
        DB::table('purchase_order')
            ->where('purchase_number',$purchaseNumber)
            ->update([
                'payment_status'=>$status    
            ]);
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
        $mSupplier = DB::table('m_supplier')
            ->get();

        return view ('Purchasing/PurchaseOrder/mainPiutangSupplier', compact('mSupplier'));
    }
    
}
