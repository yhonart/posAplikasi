<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class CashierController extends Controller
{
    protected $tempInv;
    protected $tempKasBesar;
    protected $TempInventoryController;
    protected $TempKeuanganController;

    public function __construct(TempInventoryController $tempInv, TempKeuanganController $tempKasBesar)
    {
        $this->TempInventoryController = $tempInv;
        $this->TempKeuanganController = $tempKasBesar;
    }

    // CEK INFORMASI USER TERKAIT AREA KERJA YANG TERDAFTAR PADA SISTEMre
    public function checkuserInfo()
    {
        $userID = Auth::user()->id;
        $cekUserArea = DB::table('users_area AS a')
            ->select('a.area_id', 'b.site_code', 'b.site_name')
            ->leftJoin('m_site AS b', 'a.area_id', '=', 'b.idm_site')
            ->where('a.user_id', $userID)
            ->first();
        if (!empty($cekUserArea)) {
            # code...
            $userAreaID = $cekUserArea->area_id;
        } else {
            $userAreaID = 0;
        }
        return $userAreaID;
    }

    // Buat nomor transaksi baru.
    public function checkBillNumber()
    {
        $areaID = $this->checkuserInfo();
        $thisDate = date("dmy");
        $toDay = date("Y-m-d");
        $username = Auth::user()->name;
        $company = Auth::user()->company;

        $getCodeCompany = DB::table('m_company')
            ->select('company_code')
            ->where('idm_company',$company)
            ->first();

        $compCode = $getCodeCompany->company_code;
        //Cek apakah ada nomor transaksi dari proses F4
        $countReturn = DB::table('tr_store')
            ->where([
                ['store_id', $areaID],
                ['is_return', '1'],
                ['status', '0'],
                ['tr_date', $toDay],
                ['return_by',$username],
                ['comp_id',$company]
            ])
            ->count();
        
        // Jika tidak ada 
        if ($countReturn == '0') {
            # code...
            $countTrx = DB::table("tr_store")
                ->where([
                    ['store_id', $areaID],
                    ['tr_date', $toDay],
                    ['comp_id', $company]
                ])
                ->count();

            if ($countTrx == '0') {
                $no = "1";
                $pCode = "P". $compCode . $thisDate . "-" . sprintf("%07d", $no);
            } else {
                $no = $countTrx + 1;
                $pCode = "P". $compCode . $thisDate . "-" . sprintf("%07d", $no);
            }
        } else {
            $selectNumber = DB::table('tr_store')
            ->where([
                ['store_id', $areaID],
                ['is_return', '1'],
                ['status', '0'],
                ['tr_date', $toDay],
                ['return_by',$username]
            ])
            ->first();
            $pCode = $selectNumber->billing_number;
        }
        return $pCode;
    }

    // Cek nomor dengan kondisi setelah di return
    public function checkReturnActive()
    {
        $areaID = $this->checkuserInfo();
        $createdName = Auth::user()->name;
        $hakAkses = Auth::user()->hakakses;
        $dateTrx = date("Y-m-d");
        $countReturn = DB::table('tr_store')
            ->where([
                ['status', 1],
                ['store_id', $areaID],
                ['return_by', $createdName]
            ])
            ->count();

        return $countReturn;
    }

    // Cek nomor transaksi yang aktif
    public function checkTrxActive()
    {
        $areaID = $this->checkuserInfo();
        $createdName = Auth::user()->name;
        $hakAkses = Auth::user()->hakakses;
        $dateTrx = date("Y-m-d");

        if ($hakAkses == '1') {
            $countActiveDisplay = DB::table('tr_store')
                ->where([
                    ['status', 1],
                    ['store_id', $areaID],
                    ['tr_date', $dateTrx],
                    ['return_by',$createdName]
                ])
                ->count();
        } elseif ($hakAkses == '2') {
            $countActiveDisplay = DB::table('tr_store')
                ->where([
                    ['status', 1],
                    ['store_id', $areaID],
                    ['tr_date', $dateTrx],
                    ['created_by', $createdName]
                ])
                ->count();
        }
        return $countActiveDisplay;
    }

    public function getInfoNumber()
    {
        $username = Auth::user()->name;
        $area = $this->checkuserInfo();
        $hakAkses = Auth::user()->hakakses;
        $dateDB = date("Y-m-d");
        $company = Auth::user()->company;

        $countReturnNumber = DB::table('tr_store')
            ->where([
                ['status','1'],
                ['return_by',$username],
                ['comp_id',$company]
            ])
            ->count();
        if ($countReturnNumber == '0') {
            $billNumbering = DB::table("tr_store")
                ->where([
                    ['store_id', $area],
                    ['status', '1'],
                    ['created_by', $username],
                    ['comp_id',$company]
                ])
                ->first();
        }
        else {
            $billNumbering = DB::table("tr_store")
                ->where([
                    ['store_id', $area],
                    ['status', '1'],
                    ['return_by', $username],
                    ['comp_id',$company]
                ])
                ->first();
        }

        if (!empty($billNumbering)) {
            $nomorstruk = $billNumbering->billing_number;
        } else {
            $nomorstruk = "0";
        }
        
        return $nomorstruk;
    }    

    public function mainCashier()
    {
        $checkArea = $this->checkuserInfo();
        if (Auth::check()) {
            return view('Cashier/maintenancePage', compact('checkArea'));
        } else {
            return view('login');
        }
    }

    public function updateTotalBelanja($trxCode)
    {
        $billNumber = $this->getInfoNumber();

        $countBelanja = DB::table("tr_store_prod_list")
            ->where([
                ["from_payment_code", $trxCode],
                ['status', '1']
            ])
            ->count();

        $nominalBelanja = DB::table('tr_store_prod_list')
            ->select(DB::raw("SUM(t_price) as billing"))
            ->where([
                ['from_payment_code', $trxCode],
                ['status', '1']
            ])
            ->first();

        // if($countBelanja >= '1'){
        // }
        // else{
        //     $nominalBelanja = DB::table('tr_store')
        //         ->select("t_bill as billing")
        //         ->where("billing_number",$trxCode)
        //         ->first();
        // }

        return view('Cashier/cashierDisplayNominal', compact('countBelanja', 'nominalBelanja'));
    }

    public function productListBackup()
    {
        $billNumber = $this->getInfoNumber();
        $productUnit = DB::table('m_unit')
            ->get();

        $countProdList = DB::table('tr_store_prod_list')
            ->where('status', '1')
            ->count();

        $countBill = DB::table('tr_store')
            ->where('billing_number', $billNumber)
            ->count();
        $productList = DB::table('product_list_view')
            ->select(DB::raw("distinct(idm_data_product) as idm_data_product"), 'product_name')
            ->where('product_status', '1')
            ->orderBy('product_name', 'asc')
            ->get();

        return view('Cashier/cashierProductList', compact('productUnit', 'countProdList', 'productList', 'billNumber', 'countBill'));
    }

    public function productList()
    {
        $billNumber = $this->getInfoNumber(); 

        $viewBilling = DB::table('view_billing_action')
            ->select('customer_name')
            ->where('billing_number',$billNumber)
            ->first();

        return view('Cashier/cashierProductList', compact('billNumber','viewBilling'));
    }
    
    public function cariProduk($keyword, $billNumber)
    {
        $barcode = "";
        $username = Auth::user()->name;
        $company = Auth::user()->company;

        $getBarcode = DB::table('m_product_unit')
            ->where('set_barcode', $keyword)
            ->first();           
        // echo $billNumber." ".$barcode." ".$keyword;                
        //Get customer.
        if ($billNumber <> '0') {
            $cusTrx = DB::table('tr_store as a')
                ->select('a.member_id','b.customer_store','b.customer_type')
                ->leftJoin('m_customers as b', 'a.member_id','=','b.idm_customer')
                ->where('billing_number',$billNumber)
                ->first(); 
            $cosGroup = $cusTrx->customer_type;
            $memberID = $cusTrx->member_id;
            if (!empty($getBarcode)) { // Jika input data menggunakan barcode
                $barcode = $getBarcode->set_barcode;
                $productList = DB::table('view_product_stock');            
                $productList = $productList->where('set_barcode', $keyword);
                $productList = $productList->first();

                $product = $productList->idm_data_product;
                $unit = $productList->product_satuan;
                $satuan = $productList->product_size;
                $priceOrder = $productList->product_price_order;
                $stock = $productList->stock;
                $inputStock = $stock - 1;

                $getPrice = DB::table('m_product_price_sell')
                    ->where([
                        ['core_product_price',$product],
                        ['size_product',$satuan],
                        ['cos_group',$cosGroup]
                    ])
                    ->first();
                $priceSell = $getPrice->price_sell;

                $countItem = DB::table('tr_store_prod_list')
                    ->where([
                        ['from_payment_code', $billNumber],
                        ['product_code',$product],
                        ['unit',$unit],
                        ['status','>=','1']
                    ])
                    ->count();

                if ($countItem == '0') {
                    DB::table('tr_store_prod_list')
                        ->insert([
                            'from_payment_code'=>$billNumber,
                            'product_code'=>$product,
                            'qty'=>'1',
                            'unit'=>$unit,
                            'satuan'=>$satuan,
                            'unit_price'=>$priceSell,
                            'disc'=>'0',
                            't_price'=>$priceSell,
                            'm_price'=>$priceOrder,
                            'status'=>'1',
                            'created_by'=>$username,
                            'stock'=>$inputStock,
                            'date'=> now(),
                        ]);
                }
                else {
                    $selectTrxItem = DB::table('tr_store_prod_list')
                        ->where([
                            ['from_payment_code', $billNumber],
                            ['product_code',$product],
                            ['unit',$unit],
                            ['status','>=','1']
                        ])
                        ->first();

                    $lastQty = $selectTrxItem->qty;
                    $sumQty = $lastQty + 1;
                    $lastHargaSatuan = $selectTrxItem->unit_price;
                    $lastTotalHarga = $selectTrxItem->t_price;
                    $updateHarga = $lastTotalHarga + $lastHargaSatuan;

                    DB::table('tr_store_prod_list')
                        ->where([
                            ['from_payment_code', $billNumber],
                            ['product_code',$product],
                            ['unit',$unit],
                            ['status','>=','1']
                        ])
                        ->update([
                            'qty'=>$sumQty,
                            't_price'=>$updateHarga,
                            'stock'=>$inputStock,
                        ]);
                    
                }
                 // Insert into laporan
                $location = '3';
                $prodQty = '1';
                $description = "Penjualan ".$username;                
                $this->TempInventoryController->reportBarangKeluar($product, $satuan, $location, $prodQty, $description, $billNumber, $username);
                $this->penguranganStock($product, $location, $satuan, $prodQty);
                $msg = array('success' => 'Data Berhasil Dimasukkan.');

            } else { // jika input menggunakan text  
                $productList = DB::table('view_customer_product_sell');
                if ($keyword <> 0) {
                    $productList = $productList->where('product_name', 'LIKE', '%' . $keyword . '%');
                }
                $productList = $productList->where([
                    ['idm_customer',$memberID],
                    ['location_id','3'],
                    ['customer_type',$cosGroup],
                    ['comp_id',$company]
                ]);
                $productList = $productList->orderBy('product_name', 'ASC');
                $productList = $productList->get();
                
                return view('Cashier/cashierProductListKeyword', compact('productList','keyword','cosGroup','billNumber','memberID'));
            }
        }
        else {
            $msg = array('warningCustomer' => 'Masukkan Nama Pelanggan/Member Terlebih Dahulu, Tekan [F1]');
        }
        return response()->json($msg);
    }

    public function selectResponse ($selectID, $memberID){
        $getData = DB::table('view_customer_product_sell')
            ->where([
                ['idm_customer',$memberID],
                ['idinv_stock',$selectID]
            ])
            ->first();

        return response()->json([
            'price' => $getData->price_sell,
            'discount' => '0',
            'prdStock' => $getData->stock,
            'hrgModal' => $getData->product_price_order,
            'prodName' => $getData->product_name,
            'satuan' => $getData->product_satuan,
        ]);
    }

    public function inputItem (Request $postItem){
        //Ambil data produk
        $dataID = $postItem->stockID;
        $billNumber = $postItem->trxNumber; 
        $cusGroup = $postItem->cusGroup;
        $qtySubmit = $postItem->qty;

        $getCustomer = DB::table('view_billing_action')
            ->select('customer_name')
            ->where('billing_number',$billNumber)
            ->first();

        $customerName = $getCustomer->customer_name;

        $productListView = DB::table('view_product_stock')
            ->where('idinv_stock',$dataID)
            ->first();
            
        $product = $productListView->idm_data_product;
        $unit = $productListView->product_satuan;
        $satuan = $productListView->product_size;
        $priceOrder = $productListView->product_price_order;
        $stock = $productListView->stock;
        $username = Auth::user()->name;
        $inputStock = $stock - $qtySubmit;

        $getPrice = DB::table('m_product_price_sell')
            ->where([
                ['core_product_price',$product],
                ['size_product',$satuan],
                ['cos_group',$cusGroup]
            ])
            ->first();
        $priceSell = $getPrice->price_sell * $qtySubmit;
        //Cek ketersediaan item dengan barang yang sama
        $countItem = DB::table('tr_store_prod_list')
            ->where([
                ['from_payment_code', $billNumber],
                ['product_code',$product],
                ['unit',$unit],
                ['status','>=','1']
            ])
            ->count();

        if ($countItem == '0') {
            DB::table('tr_store_prod_list')
                ->insert([
                    'from_payment_code'=>$billNumber,
                    'product_code'=>$product,
                    'qty'=>$qtySubmit,
                    'unit'=>$unit,
                    'satuan'=>$satuan,
                    'unit_price'=>$getPrice->price_sell,
                    'disc'=>'0',
                    't_price'=>$priceSell,
                    'm_price'=>$priceOrder,
                    'status'=>'1',
                    'created_by'=>$username,
                    'stock'=>$inputStock,
                    'date'=> now(),
                ]);

            // Insert into laporan
            $location = '3';
            $prodQty = $qtySubmit;
            $description = "Penjualan ".$customerName;
            $this->TempInventoryController->reportBarangKeluar($product, $satuan, $location, $prodQty, $description, $billNumber, $username);
            $this->penguranganStock($product, $location, $satuan, $prodQty);            
            DB::table('tr_temp_prod')
            ->insert([
                'bill_number'=>$billNumber,
                'product_id'=>$product,
                'status'=>'1',
                'created_at'=>now(),
                'created_by'=>$username
            ]);
        }
    }

    public function inputSatuan($idPrd)
    {
        $satuan = DB::table('m_product_unit')
            ->select(DB::raw('DISTINCT(product_satuan)'), 'product_size', 'stock')
            ->where([
                ['core_id_product', $idPrd],
                ['product_volume', '!=', '0']
            ])
            ->orderBy('size_code', 'ASC')
            ->get();

        return view('Cashier/cashierProductListSatuan', compact('satuan'));
    }

    public function hargaSatuan($idSatuan, $idPrd)
    {
        // CEK CUSTOMER INFO 
        $countActive = $this->getInfoNumber();

        $memberInfo = DB::table('trans_mamber_view')
            ->where('billing_number', $countActive)
            ->first();

        $memberType = $memberInfo->customer_type;

        //CEK HARGA DI TABEL PENJUALAN
        $countSellByType = DB::table('m_product_price_sell')
            ->where([
                ['core_product_price', $idPrd],
                ['cos_group', $memberType],
                ['size_product', $idSatuan],
            ])
            ->count();

        if ($countSellByType >= '1') {
            $hargaSatuan = DB::table('m_product_price_sell');
            $hargaSatuan = $hargaSatuan->where([
                ['core_product_price', $idPrd],
                ['cos_group', $memberType],
                ['size_product', $idSatuan],
            ]);
            $hargaSatuan = $hargaSatuan->first();
            return response()->json([
                'price' => $hargaSatuan->price_sell,
                'discount' => '0'
            ]);
        } else {
            $hargaSatuan = DB::table('m_product_unit');
            $hargaSatuan = $hargaSatuan->where([
                ['core_id_product', $idPrd],
                ['product_size', $idSatuan]
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

    public function prdResponse($idPrd)
    {
        // CEK CUSTOMER INFO 
        $countActive = $this->getInfoNumber();

        $memberInfo = DB::table('trans_mamber_view')
            ->where('billing_number', $countActive)
            ->first();

        $memberType = $memberInfo->customer_type;

        //Cari size dan id produk dalam ukuran besar
        $sizeProd = DB::table('m_product_unit')
            ->select('product_size', 'idm_product_satuan')
            ->where([
                ['core_id_product', $idPrd],
                ['size_code', '1']
            ])
            ->first();
        $idSatuan = $sizeProd->product_size;

        //Cek jumlah harga yang sesuai dengan group di customer
        $countSellByType = DB::table('m_product_price_sell')
            ->where([
                ['core_product_price', $idPrd],
                ['cos_group', $memberType],
                ['size_product', $idSatuan],
            ])
            ->count();

        // CEK STOCK
        $dataStock = DB::table('inv_stock')
            ->where([
                ['product_id', $sizeProd->idm_product_satuan],
                ['location_id', '3']
            ])
            ->first();

        if ($countSellByType >= '1') {
            $hargaSatuan = DB::table('m_product_price_sell');
            $hargaSatuan = $hargaSatuan->where([
                ['core_product_price', $idPrd],
                ['cos_group', $memberType],
                ['size_product', $idSatuan],
            ]);

            $hargaModal = DB::table('m_product_unit')
                ->select('product_price_order')
                ->where([
                    ['core_id_product', $idPrd],
                    ['product_size', $idSatuan]
                ])
                ->first();

            $hargaSatuan = $hargaSatuan->first();
            return response()->json([
                'price' => $hargaSatuan->price_sell,
                'discount' => '0',
                'prdStock' => $dataStock->stock,
                'hrgModal' => $hargaModal->product_price_order
            ]);
        } else {
            $hargaSatuan = DB::table('m_product_unit');
            $hargaSatuan = $hargaSatuan->where([
                ['core_id_product', $idPrd],
                ['product_size', $idSatuan]
            ]);

            $hargaSatuan = $hargaSatuan->first();
            return response()->json([
                'price' => $hargaSatuan->product_price_sell,
                'discount' => '0',
                'prdStock' => $dataStock->stock,
                'hrgModal' => $hargaSatuan->product_price_order
            ]);
        }

        // return view ('Cashier/cashierProductListHarga', compact('hargaSatuan'));
        return response()->json(['error' => 'Product not found'], 404);
    }

    public function stoockBarang($idSatuan, $idPrd)
    {
        $productStock = DB::table('view_product_stock')
            ->where([
                ['idm_data_product', $idPrd],
                ['product_size', $idSatuan]
            ])
            ->first();

        if (!empty($productStock)) {
            return response()->json([
                'stock' => $productStock->stock
            ]);
        }
        return response()->json(['error' => 'Product not found'], 404);
    }

    public function postProductList(Request $reqPostProd)
    {
        $transNumber = $reqPostProd->transNumber;
        $createdBy = $reqPostProd->createdBy;
        $prodId = $reqPostProd->prodNameHidden;
        $prodQty = $reqPostProd->qty;
        $prodSatuan = $reqPostProd->satuan;
        $hargaSatuan = str_replace(".", "", $reqPostProd->hargaSatuan);
        $disc = str_replace(".", "", $reqPostProd->disc);
        $jumlah = str_replace(".", "", $reqPostProd->jumlah);
        $stock = $reqPostProd->stock;
        $intJumlah = (int)$jumlah;
        $mPrice = (int)$hargaSatuan - (int)$disc;

        // Cek ketersediaan nomor billing data store 
        $trStore = DB::table('trans_mamber_view')
            ->where('billing_number', $transNumber)
            ->first();

        $tBill = $trStore->t_bill + $intJumlah;
        $tItem = $trStore->t_item + 1;
        $memberType = $trStore->customer_type;
        $customerName = $trStore->customer_store;

        // CHECK SATUAN 
        $satuanSell = DB::table('m_product_unit')
            ->where([
                ['core_id_product', $prodId],
                ['product_size', $prodSatuan]
            ])
            ->first();

        $dataSatuan = $satuanSell->product_satuan;
        $idPrdUnit = $satuanSell->idm_product_satuan;
        $hrgModal = $satuanSell->product_price_order;

        // hitung jumlah produk yang ada list produk yang sama 
        $countProduct = DB::table('tr_store_prod_list')
            ->where([
                ['product_code', $prodId],
                ['from_payment_code', $transNumber],
                ['unit', $dataSatuan],
                ['status','1']                
            ])
            ->count();

        if ($countProduct == '0' and ($jumlah <> '0' or $jumlah <> '')) { //jika belum ada insert ke table

            DB::table('tr_store_prod_list')
                ->updateorInsert([
                    'from_payment_code' => $transNumber,
                    'product_code' => $prodId,
                    'qty' => $prodQty,
                    'unit' => $dataSatuan,
                    'satuan' => $prodSatuan,
                    'unit_price' => $hargaSatuan,
                    'm_price' => $mPrice,
                    'disc' => $disc,
                    't_price' => $jumlah,
                    'stock' => $stock,
                    'status' => '1',
                    'created_by' => $createdBy,
                    'capital_price' => $hrgModal,
                    'date' => now()
                ]);
        } else {
            $cekDataQty = DB::table('tr_store_prod_list')
                ->select('qty', 'unit', 'unit_price', 'disc', 't_price')
                ->where([
                    ['from_payment_code', $transNumber],
                    ['product_code', $prodId]
                ])
                ->first();
            $updateQty = $cekDataQty->qty + $prodQty;
            $updateTotalHarga = $cekDataQty->t_price + $jumlah;

            DB::table('tr_store_prod_list')
                ->where([
                    ['from_payment_code', $transNumber],
                    ['product_code', $prodId]
                ])
                ->update([
                    'qty' => $updateQty,
                    'unit' => $dataSatuan,
                    'satuan' => $prodSatuan,
                    'unit_price' => $hargaSatuan,
                    'm_price' => $mPrice,
                    'disc' => $disc,
                    't_price' => $updateTotalHarga,
                    'status' => '1',
                    'is_delete'=> '0'
                ]);
        }
        
        // Update total billing & total item
        DB::table('tr_store')
            ->where('billing_number', $transNumber)
            ->update([
                't_bill' => $tBill,
                't_item' => $tItem,
            ]);

        // Insert into laporan
        $location = '3';
        $description = "Penjualan ".$customerName;

        $this->TempInventoryController->reportBarangKeluar($prodId, $prodSatuan, $location, $prodQty, $description, $transNumber, $createdBy);        

        // Start Update Stock        
        $dataStock = DB::table('view_product_stock')
            ->where([
                ['idm_data_product', $prodId],
                ['location_id', '3']
            ])
            ->get();

        // Cek volume by kode size 2
        $codeSatu = DB::table('view_product_stock')
            ->where([
                ['idm_data_product', $prodId],
                ['location_id', '3'],
                ['size_code', '1'],
            ])
            ->first();

        $codeDua = DB::table('view_product_stock')
            ->where([
                ['idm_data_product', $prodId],
                ['location_id', '3'],
                ['size_code', '2'],
            ])
            ->first();

        $codeTiga = DB::table('view_product_stock')
            ->where([
                ['idm_data_product', $prodId],
                ['location_id', '3'],
                ['size_code', '3'],
            ])
            ->first();

        $stock1 = $codeSatu->stock;
        $vol1 = $codeSatu->product_volume;

        if (!empty($codeDua)) {
            $stock2 = $codeDua->stock;
            $vol2 = $codeDua->product_volume;
        }
        else {
            $stock2 = $stock1;
            $vol2 = $vol1;            
        }

        if (!empty($codeTiga)) {
            $stock3 = $codeTiga->stock;
            $vol3 = $codeTiga->product_volume;
        }
        else {
            $stock2 = $stock2;
            $vol2 = $vol2;            
        }

        foreach ($dataStock as $ds) {
            if ($prodSatuan == "BESAR") { // Jika yang dimasukkan adalah satuan Besar
                if ($ds->size_code == '1') { // Jika kode dalam list 1
                    $a = $ds->stock - $prodQty;
                } elseif ($ds->size_code == '2') {
                    $a1 = $prodQty * $vol1;
                    $a = $ds->stock - $a1;
                } elseif ($ds->size_code == '3') {
                    $a1 = $ds->product_volume * $prodQty;
                    $a = $ds->stock - $a1;
                }
            } elseif ($prodSatuan == "KECIL") { // Jika yang idmasukkan adalah satuan kecil
                if ($ds->size_code == '1') { // Jika kode dalam list 1
                    $a1 = $stock1 * $vol1;
                    $a2 = $a1 - $prodQty;
                    $a3 = $a2 / $codeSatu->product_volume;
                    $a = (int)$a3;  
                } elseif ($ds->size_code == '2') {
                    $a1 = $ds->stock - $prodQty;
                    $a = (int)$a1;
                } elseif ($ds->size_code == '3') {
                    $a1 = $prodQty * $vol2;
                    $a2 = $stock3 - $a1;
                    $a = (int)$a2;
                }
            } elseif ($prodSatuan == "KONV") {
                $ab = $stock3 - $prodQty;

                if ($ds->size_code == '1') { // Jika kode dalam list 1
                    $a1 = $ab / $vol3;
                    $a = (int)$a1;
                } elseif ($ds->size_code == '2') {
                    $a1 = $ab / $vol2;
                    $a = (int)$a1;
                } elseif ($ds->size_code == '3') {
                    $a = $ds->stock - $prodQty;
                }
            }

            DB::table('inv_stock')
                ->where('idinv_stock', $ds->idinv_stock)
                ->update([
                    'location_id' => '3',
                    'stock' => $a,
                    'stock_out' => $prodQty,
                    'saldo' => $a
                ]);
        }
        //update status temp insert prd 
        DB::table('tr_temp_prod')
            ->where([
                ['bill_number', $transNumber],
                ['product_id', $prodId]
            ])
            ->update([
                'status' => '2'
            ]);
    }    

    public function listTableTransaksi($billNumber)
    {
        $listTrProduct = DB::table('trans_product_list_view')            
            ->where([
                ['status', '1'],
                ['from_payment_code', $billNumber]
            ])
            ->orderBy('list_id', 'asc')
            ->get();

        $stock = DB::table('view_product_stock')
            ->select('stock', 'core_id_product', 'product_satuan')
            ->where('location_id', '3')
            ->get();

        $listSatuanPrd = DB::table('m_product_unit')
            ->select('core_id_product', 'product_satuan', 'product_size')
            ->get();

        $listSatuan = DB::table('m_product_unit')
            ->get();

        return view('Cashier/cashierProductListTable', compact('listTrProduct', 'listSatuanPrd', 'listSatuan', 'stock'));
    }

    public function listTableInputPrd()
    {
        $billNumber = $this->getInfoNumber();
        return view('Cashier/cashierProductListEmpty', compact('billNumber'));
    }

    public function buttonAction()
    {        
        $areaID = $this->checkuserInfo();
        $pCode = $this->checkBillNumber();
        $countDisplay = $this->checkTrxActive();
        $countReturn = $this->checkReturnActive();
        $billNumber = $this->getInfoNumber();
        $createdName = Auth::user()->name;
        $hakAkses = Auth::user()->hakakses;
        $company = Auth::user()->company;

        if ($hakAkses == '1' and $countReturn >= '1') {
            $checkActiveBtn = '1';
        } else {
            $checkActiveBtn = $countDisplay;
        }
        //cek ketersediaan nomor transaksi berdasarkan status 1 dan user creator
        $countActiveBill = DB::table('tr_store')
            ->where([
                ['status','1'],
                ['created_by',$createdName]
            ])
            ->count(); 

        $countRerun = DB::table('tr_store')
            ->where([
                ['status','1'],
                ['return_by',$createdName]
            ])
            ->count();
        
        $members = DB::table('m_customers')
            ->where([
                ['customer_status', '1'],
                ['comp_id',$company]
                ])
            ->orWhere('customer_status', '2')
            ->get();

        $delivery = DB::table('m_delivery')
            ->where('status', '1')
            ->get();
        
        if ($countRerun == '0') {
            $trPaymentInfo = DB::table('view_billing_action')
                ->where([
                    ['status', 1],
                    ['billing_number', $billNumber],
                    ['created_by', $createdName]
                ])
                ->orderBy('tr_store_id', 'desc')
                ->first();
        }
        else {
            $trPaymentInfo = DB::table('view_billing_action')
                ->where([
                    ['status', 1],
                    ['billing_number', $billNumber],
                    ['return_by', $createdName]
                ])
                ->orderBy('tr_store_id', 'desc')
                ->first();
        }

        if (!empty($trPaymentInfo)) {
            $customerID = $trPaymentInfo->member_id;
        } else {
            $customerID = '0';
        }

        $customerType = DB::table('m_customers as a')
            ->select('a.customer_type', 'b.group_name','a.kredit_limit')
            ->leftJoin('m_cos_group as b', 'a.customer_type', '=', 'b.idm_cos_group')
            ->where('a.idm_customer', $customerID)
            ->first();

        $trPoint = DB::table('tr_member_point')
            ->select(DB::raw('SUM(point) as point'))
            ->where([
                ['core_member_id', $customerID],
                ['status', '1']
            ])
            ->first();

        $totalPayment = DB::table('tr_store_prod_list')
            ->select(DB::raw('SUM(t_price) as totalBilling'), DB::raw('COUNT(list_id) as countList'))
            ->where([
                ['from_payment_code', $billNumber],
                ['status', '1']
            ])
            ->first();

        $nomKredit = DB::table('tr_kredit')
            ->select(DB::raw('SUM(nom_kredit) as nom_kredit'))
            ->where('from_member_id',$customerID)
            ->first();

        if ($countActiveBill >= '1' OR $countRerun >= '1') {
            return view('Cashier/cashierButtonListNotEmpty', compact('pCode', 'members', 'delivery', 'countDisplay', 'trPaymentInfo', 'totalPayment', 'areaID', 'customerType', 'trPoint','nomKredit'));
        } else {
            return view('Cashier/cashierButtonListEmpty', compact('pCode', 'members', 'delivery', 'countDisplay', 'trPaymentInfo', 'totalPayment', 'areaID'));
        }
    }
    public function loadHelp()
    {
        return view('Cashier/cashierHelp');
    }
    public function postNoBilling(Request $reqPostBill)
    {
        $areaID = $this->checkuserInfo();
        
        $createdBy = Auth::user()->name;
        $company = Auth::user()->company;

        $t_Bill = "0";
        $pelanggan = $reqPostBill->pelanggan;
        $t_Pay = "0";
        $t_Difference = "0";
        $t_Item = "0";
        $deliveryBy = $reqPostBill->pengiriman;
        $ppn = $reqPostBill->ppn;
        $t_PayReturn = $t_Pay - $t_Bill;

        $dateTrx = $reqPostBill->dateTrx;
        $dateNow = date("Y-m-d");

        // cek apakah tanggal yang di masukkan sama dengan tanggal hari ini 
        if ($dateTrx <> $dateNow) {
            // Buat transaksi baru dengan tanggal yang sesuai yang dipilih
            $getNumber = DB::table('tr_store')
                ->where('tr_date',$dateTrx)
                ->count();
            $date = date("d", strtotime($dateTrx));
            $month = date("m", strtotime($dateTrx));
            $year = date("y", strtotime($dateTrx));
            $thisDate = $date."".$month."".$year;
            $no = $getNumber + 1;
            $no_Struck = "P" . $thisDate . "-" . sprintf("%07d", $no);
        }
        else {
            $no_Struck = $this->checkBillNumber();
        }

        // Cek nomor transaksi yang sedang aktif berdasarkan nomor transaksi yang terpilih
        $cekStruck = DB::table('tr_store')
            ->where([
                ['billing_number', $no_Struck],
                ['status', '1']
            ])
            ->count();

        if ($cekStruck == '0') {
            // Cek kembali apakah ada no transaksi yang sama dengan status return 1
            $isReturn = DB::table('tr_store')
                ->where([
                    ['billing_number', $no_Struck],
                    ['is_return', '1']
                ])
                ->count();

            if ($isReturn == '0') {
                DB::table('tr_store')
                    ->insert([
                        'store_id' => $areaID,
                        'billing_number' => $no_Struck,
                        'member_id' => $pelanggan,
                        't_bill' => $t_Bill,
                        't_pay' => $t_Pay,
                        't_difference' => $t_Difference,
                        't_pay_return' => $t_PayReturn,
                        't_item' => $t_Item,
                        'tr_delivery' => $deliveryBy,
                        'ppn' => $ppn,
                        'status' => '1',
                        'created_date' => now(),
                        'tr_date' => $dateTrx,
                        'created_by' => $createdBy,
                        'comp_id' => $company
                    ]);
            } else {
                DB::table('tr_store')
                    ->where([
                        ['billing_number', $no_Struck],
                        ['is_return', '1']
                    ])
                    ->update([
                        'store_id' => $areaID,
                        'billing_number' => $no_Struck,
                        'member_id' => $pelanggan,
                        't_bill' => $t_Bill,
                        't_pay' => $t_Pay,
                        't_difference' => $t_Difference,
                        't_pay_return' => $t_PayReturn,
                        't_item' => $t_Item,
                        'tr_delivery' => $deliveryBy,
                        'ppn' => $ppn,
                        'status' => '1',
                        'created_date' => now(),
                        'tr_date' => $dateTrx,
                        'is_delete' => '0',
                        'is_return' => '0',
                        'comp_id' => $company
                    ]);
            }
        }
    }

    public function postUpdateCustomer(Request $reqPostUpdateCus)
    {
        $trxCode = $reqPostUpdateCus->trxCode;
        $idPelanggan = $reqPostUpdateCus->idPelanggan;

        DB::table('tr_store')
            ->where('billing_number', $trxCode)
            ->update([
                'member_id' => $idPelanggan
            ]);

        DB::table('tr_payment_record')
            ->where('trx_code', $trxCode)
            ->update([
                'member_id' => $idPelanggan
            ]);

        DB::table('tr_kredit_record')
            ->where('trx_code', $trxCode)
            ->update([
                'member_id' => $idPelanggan
            ]);

        DB::table('tr_kredit')
            ->where('from_payment_code', $trxCode)
            ->update([
                'from_member_id' => $idPelanggan
            ]);
    }

    public function manualSelectProduct()
    {
        $areaID = $this->checkuserInfo();
        $billNumber = $this->getInfoNumber();
        $dbProductList = DB::table('m_product')
            ->select('idm_data_product', 'product_code', 'product_name', 'stock')
            ->get();

        return view('Cashier/cashierProductListModal', compact('areaID', 'billNumber', 'dbProductList'));
    }

    public function postProductSale(Request $reqPostProdSale)
    {
        $createdBy = $reqPostProdSale->userName;
        $billNumber = $reqPostProdSale->billNumber;
        $area = $reqPostProdSale->areaGudang;

        return view('Cashier/cashierProductListModalSelect', compact('productList'));
    }

    public function updateToSave($noBilling)
    {
        $sumBelanja = DB::table('tr_store_prod_list')
            ->select(DB::raw('SUM(t_price) as totalBelanja'))
            ->where([
                ['from_payment_code', $noBilling],
                ['status', '1']
            ])
            ->first();

        $countBelanja = DB::table('tr_store_prod_list')
            ->where([
                ['from_payment_code', $noBilling],
                ['status', '1']
            ])
            ->count();

        $totalBelanja = $sumBelanja->totalBelanja;
        DB::table('tr_store')
            ->where('billing_number', $noBilling)
            ->update([
                't_bill' => $totalBelanja,
                'status' => '2',
                't_item' => $countBelanja
            ]);

        DB::table('tr_store_prod_list')
            ->where([
                ['from_payment_code', $noBilling],
                ['is_delete','0']
                ])
            ->update([
                'status' => '2'
            ]);

        DB::table('report_inv')
            ->where('number_code', $noBilling)
            ->update([
                'status_trx' => '2'
            ]);

        $trDay = date("N");
        $trDate = date("d");
        $trMonth = date("m");
        $trYear = date("y");

        $cekNumber = DB::table("tr_numbering")
            ->where([
                ['tr_date', $trDate],
                ['tr_month', $trMonth],
                ['tr_year', $trYear]
            ])
            ->count();

        $areaID = $this->checkuserInfo();

        if ($cekNumber == 0) {
            $no = 1;
            DB::table("tr_numbering")
                ->insert([
                    'tr_days' => $trDay,
                    'tr_date' => $trDate,
                    'tr_month' => $trMonth,
                    'tr_year' => $trYear,
                    'tr_number' => $no,
                    'core_id_site' => $areaID
                ]);
        } else {
            $selectNumber = DB::table("tr_numbering")
                ->where([
                    ['tr_date', $trDate],
                    ['tr_month', $trMonth],
                    ['tr_year', $trYear]
                ])
                ->first();

            $no = $selectNumber->tr_number + 1;

            DB::table("tr_numbering")
                ->where([
                    ['tr_date', $trDate],
                    ['tr_month', $trMonth],
                    ['tr_year', $trYear]
                ])
                ->update([
                    'tr_number' => $no
                ]);
        }
        return back();
    }


    public function modalDataPenjualan()
    {
        $area = $this->checkuserInfo();
        $method = DB::table('m_payment_method')
            ->get();
        $mydate = date("Y-m-d");

        $cekClosing = DB::table('tr_payment_record')
            ->where([
                ['date_trx', $mydate],
                ['status', '5']
            ])
            ->count();

        $pelanggan = DB::table('m_customers')
            ->where('customer_status','1')
            ->get();

        return view('Cashier/cashierModalDataPenjualan', compact('method', 'cekClosing', 'area','pelanggan'));
    }

    public function funcDataPenjualan($fromdate, $enddate, $keyword, $method, $customers)
    {
        $fields = ['a.billing_number', 'a.customer_name'];
        $createdBy = Auth::user()->name;
        $userID = Auth::user()->id;
        $hakakses = Auth::user()->hakakses;
        $company = Auth::user()->company;
        $area = $this->checkuserInfo();

        // echo $fromdate."=".$enddate."=".$keyword."=".$method;
        // echo $hakakses;
        // cek role :

        $selectRole = DB::table('users_role')
            ->where('user_id',$userID)
            ->first();
        $userRole = $selectRole->role_code;

        $listDataSelling = DB::table('view_billing_action as a');
        $listDataSelling = $listDataSelling->select('a.*', 'b.method_name', 'a.trx_method');
        $listDataSelling = $listDataSelling->leftJoin('m_payment_method as b', 'a.trx_method', '=', 'b.idm_payment_method');
        $listDataSelling = $listDataSelling->whereBetween('a.tr_date', [$fromdate, $enddate]);
        if ($keyword <> '0') {
            // $listDataSelling = $listDataSelling->where('a.customer_name', 'like','%'.$keyword.'%');
            $listDataSelling = $listDataSelling->where(function ($query) use ($keyword, $fields) {
                for ($i = 0; $i < count($fields); $i++) {
                    $query->orwhere($fields[$i], 'like',  '%' . $keyword . '%');
                }
            });
        }        
        if ($userRole >= '2' OR $hakakses == '2') {
            $listDataSelling = $listDataSelling->where('a.created_by', $createdBy);
        }
        if ($customers <> '0') {
            $listDataSelling = $listDataSelling->where('a.member_id', $customers);
        }
        $listDataSelling = $listDataSelling->where([
            ['a.status', '!=', '1'],
            ['a.status', '!=', '2'],
            ['a.comp_id',$company]
        ]);
        $listDataSelling = $listDataSelling->orderBy('a.billing_number', 'asc');
        $listDataSelling = $listDataSelling->get();

        return view('Cashier/cashierModalDataPenjualanList', compact('listDataSelling', 'area'));
    }

    public function billingIden($billingIden, $trxType)
    {
        // CHECK DATA SEBELUMNYA ADA YANG AKTIF ATAU TIDAK 
        $userAction = Auth::user()->name;
        $countAc = DB::table('tr_store')
            ->where('status', '1')
            ->count();

        if ($countAc >= 1) {
            DB::table('tr_store')
                ->where('status', '1')
                ->update([
                    'status' => '2',
                ]);

            DB::table('tr_store_prod_list')
                ->where('status', '1')
                ->update([
                    'status' => '2',
                ]);
        }

        DB::table('tr_store')
            ->where('billing_number', $billingIden)
            ->update([
                'status' => '1',
                'is_return' => '0',
                'return_by' => $userAction
            ]);

        DB::table('tr_store_prod_list')
            ->where([
                ['from_payment_code', $billingIden],
                ['is_delete','!=','1']
                ])
            ->update([
                'status' => '1',
            ]);

        DB::table('tr_return_record')
            ->insert([
                'trx_code' => $billingIden,
                'last_payment' => '0',
                'new_payment' => '0',
                'return_date' => now(),
                'update_by' => $userAction,
                'last_status_trx' => '2',
            ]);

        
    }

    public function modalDataStock()
    {
        $userID = Auth::user()->id;
        return view('Cashier/cashierModalDataStock', compact('userID'));
    }

    public function funcDataStock($point, $keyword)
    {
        //echo $point."-".$keyword;

        $headerSize = DB::table('m_product_unit')
            ->select('product_size')
            ->groupBy('product_size')
            ->get();

        $productList = DB::table('m_product')
            ->get();

        $productUnitList = DB::table('m_product_unit')
            ->get();

        return view('Cashier/cashierModalDataStockList', compact('headerSize', 'productList', 'productUnitList'));
    }

    public function deleteData($data)
    {

        // Ambil data dari transaksi barang sesuai dengan ID;
        $listData = DB::table('tr_store_prod_list')
            ->select('from_payment_code', 'product_code', 'qty', 'unit', 't_price','satuan')
            ->where('list_id', $data)
            ->first();

        $deleteBy = Auth::user()->name;

        $prodID = $listData->product_code;
        $qty = $listData->qty;
        $unit = $listData->unit; //Dus, Pack, Bungkus, etc...
        $satuan = $listData->satuan; //Besar, Kecil, Konv
        $docNumber = $listData->from_payment_code;

        // cari stok terakhir pada table view stok inventori
        $prodUnit = DB::table('view_product_stock')
            ->select('product_size', 'saldo', 'stock_out', 'stock')
            ->where([
                ['core_id_product', $prodID],
                ['product_size', $satuan],
                ['location_id','3']
            ])
            ->first();

        $sumQty = $prodUnit->stock + $qty; //penjumlahan qty dengan stok terakhir pada table stok
        $stockOut = $prodUnit->stock_out - $qty; //pengurangan qty yang keluar

        //Query get prd list view dan stok berdasarkan produk id 
        $productUnit = DB::table('view_product_stock')
            ->where([
                ['core_id_product', $prodID],
                ['product_volume','!=','0'],
                ['product_satuan','!=',''],
                ['location_id','3']
            ])
            ->get();

        $volKonversi = DB::table('product_list_view') //mengambil data konversi
            ->where('core_id_product', $prodID)
            ->orderBy('size_code', 'desc')
            ->first();

        $vol = $volKonversi->product_volume;

        $valKecil = DB::table('m_product_unit')
            ->select('product_volume')
            ->where([
                ['core_id_product', $prodID],
                ['size_code', '2']
            ])
            ->first();

        if (!empty($valKecil)) {
            $volkodedua = $valKecil->product_volume;
        } else {
            $volkodedua = $vol;
        }

        $mProduct = DB::table('m_product')
            ->where('idm_data_product',$prodID)
            ->first();

        $volB = $mProduct->large_unit_val;
        $volK = $mProduct->medium_unit_val;
        $volKONV = $mProduct->small_unit_val;

        foreach ($productUnit as $p) {
            $sizeCode = $p->size_code;
            $prodZise = $p->product_size;
            $vol2 = $p->product_volume;

            // Jika size code 1
            if ($satuan == "BESAR") {
                if ($sizeCode == '1') {
                    $c = $sumQty;
                }
                elseif ($sizeCode == '2') {
                    $c1 = $sumQty * $volB;
                    $c = (int)$c1;
                }
                elseif ($sizeCode == '3') {
                    $c1 = $sumQty * $volKONV;
                    $c = (int)$c1;
                }
            }
            elseif ($satuan == "KECIL") {
                
                if ($sizeCode == '1') {
                    $c1 = $sumQty / $volB;
                    $c = (int)$c1;
                }
                elseif ($sizeCode == '2') {
                    $c = $sumQty;
                }
                elseif ($sizeCode == '3') {
                    $c1 = $sumQty * $volK;
                    $c = (int)$c1;
                }
            }
            elseif ($satuan == "KONV") {
                
                if ($sizeCode == '1') {
                    $c1 = $sumQty / $volKONV;
                    $c = (int)$c1;
                }
                elseif ($sizeCode == '2') {
                    $c1 = $sumQty / $volK;
                    $c = (int)$c1;
                }
                elseif ($sizeCode == '3') {
                    $c = $sumQty;
                }
            }
            
            DB::table('inv_stock')
                ->where([
                    ['idinv_stock', $p->idinv_stock]
                ])
                ->update([
                    'stock' => $c,
                    'stock_out' => $stockOut,
                    'saldo' => $c
                ]);
        }

        // Delete item store.
        DB::table('tr_store_prod_list')
            ->where('list_id', $data)
            ->update([
                'status' => '0',
                'is_delete' => '1',
                'delete_by' => $deleteBy,
                'delete_date' => now()
            ]);

        //Update log transaksi menjadi 0
        DB::table('report_inv')
            ->where([
                ['number_code',$docNumber],
                ['product_id',$prodID],
                ['satuan',$satuan]
            ])
            ->update([
                'status_trx'=>'0'
            ]);
    }

    public function updateToPayment(Request $reqUpdatePay)
    {
        $created = Auth::user()->name;
        $noBill = $reqUpdatePay->noBill;
        $ppn = $reqUpdatePay->ppn;
        $ppnNominal = str_replace(".", "", $reqUpdatePay->ppnNominal);
        $tBayar = str_replace(".", "", $reqUpdatePay->tBayar);
        $tBill = $reqUpdatePay->tBill;
        $treturn = $tBayar - $tBill;

        if ($tBayar >= $tBill) {
            DB::table('tr_store')
                ->where('billing_number', $noBill)
                ->update([
                    't_pay' => $tBayar,
                    't_pay_return' => $treturn,
                    'status' => '5',
                    'ppn' => $ppn,
                    'ppn_nominal' => $ppnNominal,
                    'tr_date' => now()
                ]);

            DB::table('tr_store_prod_list')
                ->where('from_payment_code', $noBill)
                ->update([
                    'status' => '5',
                    'date' => now()
                ]);
        }
    }

    public function modalDataPelunasan()
    {
        $company = Auth::user()->company;
        $dbMCustomer = DB::table('m_customers')
            ->where('comp_id',$company)
            ->get();

        return view('Cashier/cashierModalDataPelunasan', compact('dbMCustomer'));
    }

    public function funcDataPelunasan($keyword, $fromDate, $endDate, $valAction)
    {
        // echo $keyword."/".$fromDate."/".$endDate;
        $fields = ['from_payment_code', 'customer_store'];
        $periode = date("ym");
        $company = Auth::user()->company;

        $countDataPinjaman = DB::table('view_customer_kredit')
            ->where('from_member_id', $keyword)
            ->count();

        $nomorBukti = DB::table('tr_pembayaran_kredit')
            ->where([
                ['periode', $periode],
                ['status', '2']
            ])
            ->first();

        if (!empty($nomorBukti)) {
            $numbering = $nomorBukti->numbering + 1;
        } else {
            $numbering = '1';
        }

        $dataPinjaman = DB::table('view_customer_kredit');
        if ($keyword <> '0') {
            $dataPinjaman = $dataPinjaman->where('from_member_id', $keyword);
        } elseif ($fromDate <> '0' and $endDate <> '0') {
            $dataPinjaman = $dataPinjaman->whereBetween('created_at', [$fromDate, $endDate]);
        }
        $dataPinjaman = $dataPinjaman->where('comp_id',$company);
        $dataPinjaman = $dataPinjaman->get();

        $datPinjaman = $dataPinjaman;
        $accountCode = DB::table('account_code')
            ->where('account_type','3')
            ->get();
        $accountPenjualan = DB::table('account_code')
            ->where('account_type','1')
            ->first();

        $customerName = DB::table('m_customers')
            ->where('idm_customer', $keyword)
            ->first();

        $totalHutang = DB::table('view_customer_kredit')
            ->select(DB::raw('SUM(nom_kredit) as kredit'))
            ->where('from_member_id', $keyword)
            ->first();

        $listStruk = DB::table('tr_pembayaran_kredit')
            ->select(DB::raw('DISTINCT(payment_number)'))
            ->where('member_id', $keyword)
            ->get();

        $getLastRecord = DB::table('tr_kredit_record')
            ->where('status','1')
            ->get();
            
        if ($valAction == '1') {
            $sumPayed = DB::table('tr_kredit_record')
                ->select(DB::raw('SUM(total_payment) as sumpayed'))
                ->where([
                    ['member_id',$keyword],
                    ['status','1']
                ])
                ->first();
            return view('Cashier/cashierModalDataPelunasanList', compact('getLastRecord','dataPinjaman', 'keyword', 'fromDate', 'endDate', 'accountCode', 'periode', 'numbering', 'customerName', 'totalHutang', 'listStruk', 'countDataPinjaman','accountPenjualan','sumPayed'));
        }
        elseif ($valAction == '3') {
            $listPembayaranCustomer = DB::table('tr_pembayaran_kredit as a')
                ->leftJoin('m_customers as b','a.member_id','=','b.idm_customer')
                ->where('member_id', $keyword)
                ->orderBy('idtr_payment','desc')
                ->get();

            return view("HutangCustomers/loanHistory", compact('listPembayaranCustomer'));
        } else {
            return view('Cashier/cashierModalDataPelunasanSummary', compact('datPinjaman'));
        }
    }

    public function listDataPinjaman()
    {
        $company = Auth::user()->company;
        $datPinjaman = DB::table('view_customer_kredit')
            ->where('comp_id',$company)
            ->get();

        return view('Cashier/cashierModalDataPelunasanSummary', compact('datPinjaman'));
    }

    public function printPelunasan($voucher)
    {

        $listVoucher = DB::table('view_print_voucher')
            ->select(DB::raw('SUM(debit) as debit'), DB::raw('SUM(kredit) as kredit'), 'payment_number', 'no_kredit', 'created_by', 'verifikator', 'pembukuan', 'customer_store', 'account_name', 'account_code', 'created_at')
            ->where('payment_number', $voucher)
            ->first();

        $namaToko = DB::table('m_company')
            ->first();

        $pdf = PDF::loadview('Cashier/cashierPrintPelunasan', compact('listVoucher', 'namaToko'))->setPaper("A4", 'landscape');
        return $pdf->stream();
    }

    public function postPelunasan(Request $reqPostPelunasan)
    {
        $userCretor = Auth::user()->name;
        $periode = $reqPostPelunasan->periode;
        $idPelanggan = $reqPostPelunasan->idPelanggan;
        $numbering = $reqPostPelunasan->numbering;
        $tglBukti = $reqPostPelunasan->tglBukti;
        $pelanggan = $reqPostPelunasan->pelanggan;
        $keterangan = $reqPostPelunasan->keterangan;
        $kodeAkun = $reqPostPelunasan->kodeAkun;
        $nominalKredit = str_replace(".", "", $reqPostPelunasan->nominalKredit);
        $nominalBayar = str_replace(".", "", $reqPostPelunasan->nominalBayar);
        $nomorBukti = $reqPostPelunasan->nomorBukti;
        $accountCode = $reqPostPelunasan->accountCode;

        DB::table('tr_pembayaran_kredit')
            ->insert([
                'payment_number'=>$nomorBukti,
                'periode'=>$periode,
                'numbering'=>$numbering,
                'date_payment'=>$tglBukti,
                'member_id'=>$idPelanggan,
                'no_perkiraan'=>$kodeAkun,
                'no_kredit'=>$accountCode,
                'debit'=>$nominalBayar,
                'kredit'=>$nominalBayar,
                'created_by'=>$userCretor,
                'created_at'=>now(),
                'status'=>'2',
                'total_kredit'=>$nominalKredit
            ]);

        DB::table('tr_kredit')
            ->where([
                ['status','1'],
                ['from_member_id',$idPelanggan]
            ])
            ->update([
                'status'=>'2'
            ]);       

        DB::table('tr_kredit_record')
            ->where([
                ['member_id',$idPelanggan],
                ['status','1']
            ])
            ->update([
                'status'=>'2'
            ]);

        $tb_pelanggan = DB::table('m_customers')
            ->where('idm_customer',$idPelanggan)
            ->first();

        //Cek transaksi kredit sesuai idpelanggan  
        $description = "Pembayaran Hutang Pelanggan ". $tb_pelanggan->customer_store . " # " . $nomorBukti;
        DB::table('lap_kas_besar')
            ->insert([
                'description'=>$description,
                'create_by'=>$userCretor,
                'trx_date'=>now(),
                'debit'=>$nominalBayar,
                'kredit'=>'0',
                'saldo'=>$nominalBayar,
                'created_date'=>now(),
                'trx_number'=>$nomorBukti,
                'trx_code'=>'1',
            ]);
        
    }

    public function actionDataPinjaman(Request $reqAction)
    {

        $tableDB = $reqAction->tablename;
        $kolomDB = $reqAction->column;
        $rowID = $reqAction->id;
        $kreditID = $reqAction->idKredit;
        $codeTrx = $reqAction->codeTrx;
        $idPelanggan = $reqAction->keyWord;
        $numbering = $reqAction->numbering;
        $editVal = str_replace(".", "", $reqAction->editval);
        $periode = date("ym");

        // cek kredit 
        $cekValKredit = DB::table('tr_kredit')
            ->where($kreditID, $rowID)
            ->first();

        $nomKredit = $cekValKredit->nom_kredit;
        $nomPayed = $cekValKredit->nom_payed;
        $updateKredit = $nomKredit - $editVal;
        $updatePayed = $nomPayed + $editVal;
        
        // NOTED :
        // $codeTrx = 1 (Edit nominal bayar);
        // $codeTrx = 2 (Edit keterangan);
        
        if ($codeTrx == '1') {
            DB::table('tr_kredit_record')
                ->insert([
                    'trx_code' => $cekValKredit->from_payment_code,
                    'date_trx' => now(),
                    'member_id' => $cekValKredit->from_member_id,
                    'total_struk' => $cekValKredit->nominal,
                    'total_payment' => $editVal,
                    'status'=>'1'
                ]);
        }

        // update table tr_kredit
        DB::table($tableDB)
            ->where([
                [$kreditID, $rowID],
                ['status','2']
                ])
            ->update([
                'nom_payed' => $updatePayed,
                'nom_kredit' => $updateKredit,
                'status' => '1'
            ]); 
    }

    public function actionUpdateRecord(Request $reqRecord)
    {
        $tableDB = $reqRecord->tablename;
        $column = $reqRecord->column;
        $editable = str_replace(".", "", $reqRecord->editval);
        $id = $reqRecord->id;
        $idKredit = $reqRecord->idKredit;

        DB::table($tableDB)
            ->where($idKredit, $id)
            ->update([
                $column => $editable,
            ]); 
    }
    public function modalDataReturn()
    {
        return view('Cashier/cashierModalDataReturn');
    }

    public function searchDataReturn($keyword, $fromDate, $endDate)
    {
        $fields = ['a.billing_number', 'a.customer_name'];
        $dateNow = date('Y-m-d');
        $userID = Auth::user()->id;
        $createdBy = Auth::user()->name;
        $hakakses = Auth::user()->hakakses;
        $company = Auth::user()->company;

        $listDataNumber = DB::table('view_billing_action as a');
        $listDataNumber = $listDataNumber->select('a.*', 'b.method_name', 'trx_method');
        $listDataNumber = $listDataNumber->leftJoin('m_payment_method as b', 'a.trx_method', '=', 'b.idm_payment_method');
        $listDataNumber = $listDataNumber->whereBetween('a.tr_date', [$fromDate, $endDate]);
        if ($keyword <> '0') {
            $listDataNumber = $listDataNumber->where(function ($query) use ($keyword, $fields) {
                for ($i = 0; $i < count($fields); $i++) {
                    $query->orwhere($fields[$i], 'like',  '%' . $keyword . '%');
                }
            });
        }
        if ($hakakses == '2') {
            $listDataNumber = $listDataNumber->where('a.created_by', $createdBy);
        }
        $listDataNumber = $listDataNumber->where([
            ['a.status', '!=', '1'],
            ['a.status', '!=', '2'],
            ['a.status', '!=', '0'],
            ['a.comp_id',$company]
        ]);
        $listDataNumber = $listDataNumber->orderBy('a.billing_number', 'asc');
        $listDataNumber = $listDataNumber->get();

        return view('Cashier/cashierModalDataReturnList', compact('listDataNumber', 'keyword', 'fromDate', 'endDate'));
    }

    public function sumDataInfo($trxID)
    {
        $sumProdList = DB::table('tr_store_prod_list')
            ->select(DB::raw('SUM(t_price) as tPrice'))
            ->where('from_payment_code', $trxID)
            ->first();

        $tBillLama = DB::table('tr_store')
            ->select('t_bill')
            ->where('billing_number', $trxID)
            ->first();

        $dataTransaksi = DB::table('trans_product_list_view')
            ->where('from_payment_code', $trxID)
            ->get();

        $unitList = DB::table('m_product_unit')
            ->get();

        return view('Cashier/cashierModalDataReturnListTrxSumInfo', compact('sumProdList', 'tBillLama', 'dataTransaksi', 'unitList', 'trxID'));
    }

    public function updateDataBelanja(Request $reqEditBelanja)
    {
        $tableName = $reqEditBelanja->tableName;
        $colName = $reqEditBelanja->column;
        $editVal = $reqEditBelanja->editVal;
        $idVal = $reqEditBelanja->id;
        $colId = $reqEditBelanja->colId;

        // cek harga satuan pada list produk belanja sebelumnya
        $queryHrg = DB::table('tr_store_prod_list')
            ->select('unit_price')
            ->where($colId, $idVal)
            ->first();

        $hrgSatuan = $queryHrg->unit_price;
        $totalEdit = $editVal * $hrgSatuan; // hitung total harga

        DB::table($tableName)
            ->where($colId, $idVal)
            ->update([
                $colName => $editVal
            ]);

        return back();
    }

    public function searchProdByKeyword($keyword)
    {
        //get the q parameter from URL
        $barcode = "";
        $getBarcode = DB::table('m_product_unit')
            ->where('set_barcode', $keyword)
            ->first();
        if (!empty($getBarcode)) {
            $barcode = $getBarcode->set_barcode;
            $productList = DB::table('m_product as a');
            $productList = $productList->select('a.idm_data_product', 'a.product_name', 'b.core_id_product');
            $productList = $productList->leftJoin('b.m_product_unit', 'a.idm_data_product', '=', 'b.core_id_product');
            $productList = $productList->where('b.set_barcode', $keyword);
            $productList = $productList->get();
        } else {
            $productList = DB::table('m_product');
            if ($keyword <> 0) {
                $productList = $productList->where('product_name', 'LIKE', '%' . $keyword . '%');
            }
            $productList = $productList->orderBy('product_name', 'ASC');
            // $productList = $productList->limit(10);
            $productList = $productList->get();
        }

        return view('Cashier/cashierProductListByKeyword', compact('productList', 'keyword'));
    }

    public function modalPembayaran($noBill, $tBayar, $tBill)
    {
        $dataBilling = DB::table('view_billing_action')
            ->where('billing_number', $noBill)
            ->first();
        //echo $memberID;
        $cekTotalBayar = "";
        $memberID = $dataBilling->member_id;

        $cekKredit = DB::table('tr_kredit')
            ->select(DB::raw('SUM(nom_kredit) as kredit'))
            ->where([
                ['from_member_id', $memberID],
                ['status', '1']
            ])
            ->first();
        $pointMember = DB::table('tr_member_point')
            ->select(DB::raw('SUM(point) as point'))
            ->where([
                ['core_member_id', $memberID],
                ['status', '1']
            ])
            ->first();

        $countKredit = DB::table('tr_kredit')
            ->select('nominal')
            ->where([
                ['from_member_id', $memberID],
                ['status', '1']
            ])
            ->count();

        $paymentMethod = DB::table('m_payment_method')
            ->where([
                ['status', '1']
                ])
            ->get();

        $pengiriman = DB::table('m_delivery')
            ->where('status', '1')
            ->get();

        $totalBayar = DB::table('tr_store_prod_list')
            ->select(DB::raw('SUM(t_price) as totalBilling'), DB::raw('COUNT(list_id) as countList'))
            ->where([
                ['from_payment_code', $noBill],
                ['status', '1']
            ])
            ->first();

        $bankAccount = DB::table("m_company_payment")
            ->get();

        $cekRecord = DB::table("tr_payment_record")
            ->where('trx_code', $noBill)
            ->count();

        $cekPayMethod = DB::table("tr_payment_method as a")
            ->select('a.method_name as idMethod', 'b.method_name as methodName', 'a.nominal as nominal')
            ->leftJoin('m_payment_method as b', 'a.method_name', '=', 'b.idm_payment_method')
            ->where('a.core_id_trx', $noBill)
            ->get();

        if ($cekRecord >= '1') {
            $cekTotalBayar = DB::table("tr_payment_record")
                ->where('trx_code', $noBill)
                ->first();
        }

        return view('Cashier/cashierModalPembayaran', compact('dataBilling', 'noBill', 'paymentMethod', 'tBayar', 'tBill', 'pengiriman', 'totalBayar', 'cekKredit', 'countKredit', 'bankAccount', 'cekRecord', 'cekTotalBayar', 'cekPayMethod', 'pointMember'));
    }

    public function postEditItem(Request $editItem)
    {
        $tableName = $editItem->tablename;
        $column = $editItem->column;
        $editVal = $editItem->editval;
        $id = $editItem->id;
        $tableId = $editItem->priceId;
        $lastStock = $editItem->lastStock;

        $prdItem = DB::table('trans_product_list_view')
            ->where('list_id', $id)
            ->first();

        $billingCode = $prdItem->from_payment_code;
        $productID = $prdItem->product_code;
        $satuan = $prdItem->unit;
        $lastQty = $prdItem->qty;

        $productView = DB::table('view_product_stock')
            ->select('product_size')
            ->where([
                ['core_id_product', $productID],
                ['product_satuan', $satuan]
            ])
            ->first();

        $prodSatuan = $productView->product_size;
        
        if ($column == "qty") {
            $hrgSatuan = $prdItem->m_price;
            $totalBelanja = $hrgSatuan * $editVal;
            $lastQty = $prdItem->qty;
            $locationID = '3';

            //update history qty terlebih dahulu.
            DB::table('tr_store_prod_list')
                ->where('list_id', $id)
                ->update([
                    'qty_history' => $lastQty
                ]);

            // UPDATE STOCK
            $dataStock = DB::table('view_product_stock')
                ->where([
                    ['idm_data_product', $productID],
                    ['location_id', '3']
                ])
                ->get();

            // Cek volume by kode size 1
            $codeSatu = DB::table('view_product_stock')
                ->where([
                    ['idm_data_product', $productID],
                    ['location_id', '3'],
                    ['size_code', '1'],
                ])
                ->first();

            // Cek volume by kode size 2
            $codeDua = DB::table('view_product_stock')
                ->where([
                    ['idm_data_product', $productID],
                    ['location_id', '3'],
                    ['size_code', '2'],
                ])
                ->first();

            $codeTiga = DB::table('view_product_stock')
                ->where([
                    ['idm_data_product', $productID],
                    ['location_id', '3'],
                    ['size_code', '3'],
                ])
                ->first();

            if (!empty($codeTiga)) {
                $volTiga = $codeTiga->product_volume;
                $stokTiga = $codeTiga->stock;
            } else {
                $volTiga = $codeSatu->product_volume;
                $stokTiga = $codeSatu->stock;
            }

            if (!empty($codeDua)) {
                $volDua = $codeDua->product_volume;
                $stokDua = $codeDua->stock;
            } else {
                $volDua = $volTiga;
                $stokDua = $stokTiga;
            }

            if ($lastQty < $editVal) { // Jika qty sebelumnya lebih kecil dari qty yang di jumlah qty sekarang (Menambah jumlah qty)
                // Akan dilakukan pengurangan pada stock.
                $qty = $editVal - $lastQty;
                $upStock = $lastStock - $qty;
                $this->TempInventoryController->editReportItemKasir($billingCode, $productID, $prodSatuan, $qty, $locationID, $lastQty, $editVal);              

                foreach ($dataStock as $ds) {
                    if ($prodSatuan == "BESAR") { // Jika yang dimasukkan adalah satuan Besar
                        if ($ds->size_code == '1') { // Jika kode dalam list 1
                            $a = $ds->stock - $qty;
                        } elseif ($ds->size_code == '2') {
                            $a1 = $ds->product_volume * $qty; //contoh 1 x 10 = 10
                            $a = $ds->stock - $a1;
                        } elseif ($ds->size_code == '3') {
                            $a1 = $ds->product_volume * $qty;
                            $a = $ds->stock - $a1;
                        }
                    } elseif ($prodSatuan == "KECIL") { // Jika yang idmasukkan adalah satuan kecil
                        if ($ds->size_code == '1') { // Jika kode dalam list 1
                            $a1 = $stokDua - $qty;
                            $a2 = $a1 / $ds->product_volume;
                            $a = (int)$a2;
                        } elseif ($ds->size_code == '2') {
                            $a1 = $ds->stock - $qty;
                            $a = (int)$a1;
                        } elseif ($ds->size_code == '3') {
                            $a1 = $volDua * $qty;
                            $a2 = $ds->stock - $a1;
                            $a = (int)$a2;
                        }
                    } elseif ($prodSatuan == "KONV") {
                        $ab = $stokTiga - $qty;

                        if ($ds->size_code == '1') { // Jika kode dalam list 1
                            $a1 = $ab / $volTiga;
                            $a = (int)$a1;
                        } elseif ($ds->size_code == '2') {
                            $a1 = $ab / $volDua;
                            $a = (int)$a1;
                        } elseif ($ds->size_code == '3') {
                            $a = $ab;
                        }
                    }

                    DB::table('inv_stock')
                        ->where('idinv_stock', $ds->idinv_stock)
                        ->update([
                            'location_id' => '3',
                            'stock' => $a
                        ]);
                }
            } elseif ($lastQty > $editVal) {
                // Akan dilakukan penambahan pada stock.
                $qty = $lastQty - $editVal;
                $upStock = $lastStock + $qty;
                
                $this->TempInventoryController->editReportItemKasir($billingCode, $productID, $prodSatuan, $qty, $locationID, $lastQty, $editVal);
                
                foreach ($dataStock as $ds) {
                    if ($prodSatuan == "BESAR") { // Jika yang dimasukkan adalah satuan Besar
                        if ($ds->size_code == '1') { // Jika kode dalam list 1
                            $a = $ds->stock + $qty;
                        } elseif ($ds->size_code == '2') {
                            $a1 = $ds->product_volume * $qty; //contoh 1 x 10 = 10
                            $a = $ds->stock + $a1;
                        } elseif ($ds->size_code == '3') {
                            $a1 = $ds->product_volume * $qty;
                            $a = $ds->stock + $a1;
                        }
                    } elseif ($prodSatuan == "KECIL") { // Jika yang idmasukkan adalah satuan kecil
                        if ($ds->size_code == '1') { // Jika kode dalam list 1
                            $a1 = $stokDua + $qty;
                            $a2 = $a1 / $ds->product_volume;
                            $a = (int)$a2;
                        } elseif ($ds->size_code == '2') {
                            $a1 = $ds->stock + $qty;
                            $a = (int)$a1;
                        } elseif ($ds->size_code == '3') {
                            $a1 = $volDua * $qty;
                            $a2 = $ds->stock + $a1;
                            $a = (int)$a2;
                        }
                    } elseif ($prodSatuan == "KONV") {
                        $ab = $stokTiga + $qty;

                        if ($ds->size_code == '1') { // Jika kode dalam list 1
                            $a1 = $ab / $volTiga;
                            $a = (int)$a1;
                        } elseif ($ds->size_code == '2') {
                            $a1 = $ab / $volDua;
                            $a = (int)$a1;
                        } elseif ($ds->size_code == '3') {
                            $a = $ab;
                        }
                    }

                    DB::table('inv_stock')
                        ->where('idinv_stock', $ds->idinv_stock)
                        ->update([
                            'location_id' => '3',
                            'stock' => $a
                        ]);
                }
            } else {
                $qty = $lastQty;
                $a = $qty;
                $upStock = $lastStock;

                $this->TempInventoryController->editReportItemKasir($billingCode, $productID, $prodSatuan, $qty, $locationID, $lastQty, $editVal);
            }            

            DB::table($tableName)
                ->where('list_id', $id)
                ->update([
                    'qty' => $editVal,
                    't_price' => $totalBelanja,
                    'stock' => $upStock
                ]);

        } elseif ($column == "unit") {
            //cek type member
            $typeMember = DB::table('trans_mamber_view')
                ->select('customer_type')
                ->where('billing_number', $billingCode)
                ->first();
            $cusType = $typeMember->customer_type;

            //cek harga jual berdasarkan type member
            $priceSell = DB::table('m_product_price_sell')
                ->where([
                    ['cos_group', $cusType],
                    ['size_product', $editVal],
                    ['core_product_price', $productID]
                ])
                ->first();
            // ambil nama unit 
            $unitName = DB::table('m_product_unit')
                ->select('product_satuan', 'product_price_sell')
                ->where([
                    ['core_id_product', $productID],
                    ['product_size', $editVal]
                ])
                ->first();
            //echo $unitName->product_price_sell;
        } elseif ($column == "disc") {
            $hrgPerUnit = $prdItem->unit_price;
            $hrgPerTotal = $prdItem->t_price;
            $qty = $prdItem->qty;

            $hrgAfterDisc = $hrgPerUnit - $editVal;
            $totalHrg = $hrgAfterDisc * $qty;

            DB::table($tableName)
                ->where('list_id', $id)
                ->update([
                    'm_price' => $hrgAfterDisc,
                    'disc' => $editVal,
                    't_price' => $totalHrg
                ]);
        }
    }

    public function postEditItemUnit(Request $postEditUnit)
    {
        $tableName = $postEditUnit->tablename;
        $column = $postEditUnit->column;
        $editVal = $postEditUnit->editval;
        $id = $postEditUnit->id;
        $tableId = $postEditUnit->priceId;
        $prdID = $postEditUnit->prdID;
        $prdQty = $postEditUnit->prdQty;

        //cek informasi unit
        $productInfo = DB::table('m_product_unit')
            ->where([
                ['core_id_product', $prdID],
                ['product_size', $editVal]
            ])
            ->first();

        $hargaSatuan = $productInfo->product_price_sell;
        $unit = $productInfo->product_satuan;
        $jumlahHrg = $hargaSatuan * $prdQty;

        DB::table($tableName)
            ->where($tableId, $id)
            ->update([
                $column => $unit,
                'unit_price' => $hargaSatuan,
                't_price' => $jumlahHrg,
            ]);
    }

    public function postDataMethodPembayaran(Request $reqMethod)
    {
        $methodName = $reqMethod->methodName;
        $postNominal = str_replace(".", "", $reqMethod->postNominal);
        $cardName = $reqMethod->cardName;
        $cardNumber = $reqMethod->cardNumber;
        $bankAccount = $reqMethod->bankAccount;
        $billNumber = $reqMethod->billNumber;
        $totalBelanja = str_replace(".", "", $reqMethod->totalBelanja);

        $countPayment = DB::table('tr_payment_method')
            ->where('core_id_trx', $billNumber)
            ->count();

        $paymentMethod = DB::table('m_payment_method')
            ->where('idm_payment_method',$methodName)
            ->first();
        
        if ($countPayment == '0') {
            DB::table('tr_store')
                ->where('billing_number', $billNumber)
                ->update([
                    'payment1'=>$paymentMethod->method_name,
                ]);
        }
        else {
            DB::table('tr_store')
                ->where('billing_number', $billNumber)
                ->update([
                    'payment2'=>$paymentMethod->method_name,
                ]);
        }

        $ceknominalinput = DB::table('tr_payment_method')
            ->select(DB::raw('SUM(nominal) as nominal'))
            ->where('core_id_trx', $billNumber)
            ->first();

        if ($ceknominalinput->nominal < $totalBelanja) {
            DB::table('tr_payment_method')
                ->insert([
                    'core_id_trx' => $billNumber,
                    'method_name' => $methodName,
                    'bank_transfer' => $bankAccount,
                    'card_cus_account' => $cardName,
                    'card_cus_number' => $cardNumber,
                    'nominal' => $postNominal,
                    'status' => '1',
                ]);
        }
        $checkDateTrx = DB::table('tr_store')
            ->select('tr_date')
            ->where('billing_number',$billNumber)
            ->first();
        $dateTrx = $checkDateTrx->tr_date;
        if ($paymentMethod->category <> "KREDIT" ) {
            $updateBy = Auth::user()->name;
            $this->TempKeuanganController->kasBesarPenjualan($postNominal, $updateBy, $dateTrx);
        }

    }

    public function changeTwoPayment(Request $reqChangePayment)
    {
        $tableName = $reqChangePayment->tableName;
        $column = $reqChangePayment->column;
        $editVal = $reqChangePayment->editVal;
        $id = $reqChangePayment->id;
        $tableId = $reqChangePayment->tableId;
        $method = $reqChangePayment->method;


        DB::table($tableName)
            ->where($tableId,$id)
            ->update([
                $column => $editVal
            ]);

        $methodChange = DB::table($tableName)
            ->select('core_id_trx')
            ->where($tableId,$id)
            ->first();

        $numberTrx = $methodChange->core_id_trx;

        $checkDateTrx = DB::table('tr_store')
            ->select('tr_date')
            ->where('billing_number',$numberTrx)
            ->first();

        $dateTrx = $checkDateTrx->tr_date;
        
        if ($method <> '8') {
            $updateBy = Auth::user()->name;
            $postNominal = $editVal;
            $this->TempKeuanganController->kasBesarPenjualan($postNominal, $updateBy, $dateTrx);
        }
    }

    public function loadDataMethod($noBill)
    {
        $tableMethod = DB::table('tr_payment_method as a')
            ->select('a.nominal as nominal', 'b.method_name as mName', 'a.method_name as mID', 'idtr_method')
            ->leftJoin('m_payment_method as b', 'a.method_name', '=', 'b.idm_payment_method')
            ->where('a.core_id_trx', $noBill)
            ->get();

        $paymentMethod2 = DB::table('m_payment_method')
            ->where('status', '1')
            ->get();

        return view('Cashier/cashierModalPembayaranDiv', compact('tableMethod', 'paymentMethod2'));
    }

    //Function submit pembayaran.
    public function postDataPembayaran(Request $dataPembayaran)
    {
        $noBill = $dataPembayaran->billPembayaran;
        $tBelanja = str_replace(".", "", $dataPembayaran->tBelanja);
        $kredit = str_replace(".", "", $dataPembayaran->kredit);
        $tplusKredit = str_replace(".", "", $dataPembayaran->tPlusKredit);
        $nomSelisih = str_replace(".", "", $dataPembayaran->nomSelisih);
        $fieldBayar = str_replace(".", "", $dataPembayaran->tPembayaran);
        $cusName = $dataPembayaran->cusName;
        $absSelisih = abs($nomSelisih);
        $record = $dataPembayaran->record;
        $updateBy = Auth::user()->name;
        $checkBoxPoint = $dataPembayaran->pointBelanja;
        $lunasiHutang = $dataPembayaran->lunasiHutang;
        $memberID = $dataPembayaran->memberID;
        $nilaiPoint = '0';
        $kreditPlusBelanja = $kredit + $tBelanja;
        $checkList = $dataPembayaran->radioMethod;
        $getPembayaran = explode("|", $dataPembayaran->metodePembayaran1);
        $methodPembayaran = $getPembayaran[0];
        $namePembayaran = $getPembayaran[1];
        $getBankAccount = explode("|", $dataPembayaran->bankAccount1);
        $bankAccount = $getBankAccount[0];
        $bankAccountName = $getBankAccount[1];
        $accountCusNumber = $dataPembayaran->cardNumber1;
        $accountCusName = $dataPembayaran->cardName1;

        $description = "";
        $transaction = "";
        $status1 = "";
        $status2 = "";

        if (isset($checkBoxPoint)) {
            $tPembayaran = $fieldBayar + $checkBoxPoint;
            DB::table('tr_member_point')
                ->where([
                    ['status', '1'],
                    ['core_member_id', $memberID]
                ])
                ->update([
                    'status' => '2'
                ]);
            //update tr_store
            DB::table('tr_store')
                ->where('billing_number', $noBill)
                ->update([
                    'point' => $checkBoxPoint
                ]);
        } else {
            $tPembayaran = $fieldBayar;
        }

        if (isset($lunasiHutang)) {
            //Cek ketersediaan hutang by customer
            $cekHutang = DB::table('tr_kredit')
                ->where([
                    ['from_member_id',$memberID],
                    ['nom_kredit','!=','0']
                ])
                ->get();

            $noPerkiraan = DB::table('account_code')
                    ->where('account_type','1')
                    ->first();

            foreach ($cekHutang as $ch) {
                $nomKredit = $ch->nom_kredit;
                $idTrKredit = $ch->idtr_kredit;
                $noTrx = $ch->from_payment_code;
                $totKredit = $ch->nominal;
                $datePeriode = date("Ym");

                DB::table('tr_kredit')
                    ->where([
                        ['idtr_kredit',$idTrKredit],
                        ['nom_kredit','!=','0']
                    ])
                    ->update([
                        'nom_kredit'=>'0',
                        'nom_payed'=>$nomKredit
                    ]);

                DB::table('tr_kredit_record')
                    ->insert([
                        'trx_code'=>$noTrx,
                        'date_trx'=>now(),
                        'member_id'=>$memberID,
                        'total_struk'=>$nomKredit,
                        'total_payment'=>$nomKredit,
                        'status'=>'2'
                    ]);

                DB::table('tr_pembayaran_kredit')
                    ->insert([
                        'payment_number'=>$noTrx,
                        'periode'=>$datePeriode,
                        'date_payment'=>now(),
                        'member_id'=>$memberID,
                        'no_perkiraan'=>'1',
                        'no_kredit'=>$noPerkiraan->account_code,
                        'debit'=>$nomKredit,
                        'kredit'=>$nomKredit,
                        'created_by'=>$updateBy,
                        'status'=>'2',
                        'total_kredit'=>$totKredit
                    ]);
            }
            $tPembayaran = $fieldBayar-$kredit;
        }
        else {
            $tPembayaran = $fieldBayar;
        }

        $pengiriman = $dataPembayaran->pengiriman;
        $ppn2 = $dataPembayaran->ppn2;
        $nominalPPN2 = str_replace(".", "", $dataPembayaran->nominalPPN2);
        $tKredit = $tBelanja - $tPembayaran;

        //cek nilai pembayaran sebelumnya
        $trxLastBayar = DB::table('tr_store')
            ->select('t_pay','tr_date')
            ->where('billing_number', $noBill)
            ->first();
        $trDate = $trxLastBayar->tr_date;
        // Jika dilakukan return pembayaran 
        if ($trxLastBayar->t_pay > $tPembayaran) {
            $nilaiPoint = $trxLastBayar->t_pay - $tPembayaran;
            DB::table('tr_member_point')
                ->insert([
                    'core_member_id' => $memberID,
                    'point' => $nilaiPoint,
                    'status' => '1'
                ]);
        }

        if ($tPembayaran == '') {
            $tPembayaran = '0';
        }
        // foreach($metodePembayaran as $m =>$keyMethod){
        //     $cekPaymentMethod = DB::table('m_payment_method')
        //         ->where('idm_payment_method',$keyMethod)
        //         ->get();
        //     $nameMethod = $cekPaymentMethod->category;
        // }
        echo $tPembayaran .">=". $kreditPlusBelanja; 

        //Cek count pembayaran
        $countMethod = DB::table('tr_payment_method')
            ->where('core_id_trx', $noBill)
            ->count();

        //Transaksi TUNAI
        if ($tPembayaran >= $tBelanja) {
            $status = "4";
            $mBayar = $methodPembayaran; 
            
            if ($countMethod == '0') {
                DB::table('tr_store')
                ->where('billing_number', $noBill)
                ->update([
                    'payment1'=>$namePembayaran,
                    'description'=>$bankAccountName,
                    'transaction'=>"Sale",                    
                ]);
            }                   
        } 
        //Transaksi return/edit transaksi setelah pembayaran
        elseif ($record >= '1') {
            $lastPayment = $dataPembayaran->lastBayar;
            $status = "4";
            $mBayar = '8';
            $returnBy = "Return By ".$updateBy;
            DB::table('tr_return_record')
                ->insert([
                    'trx_code' => $noBill,
                    'last_payment' => $lastPayment,
                    'new_payment' => $tBelanja,
                    'return_date' => now(),
                    'update_by' => $updateBy
                ]);

            if ($countMethod == '0') {
                DB::table('tr_store')
                ->where('billing_number', $noBill)
                ->update([
                    'payment1'=>$namePembayaran,
                    'description'=>$bankAccountName,
                    'transaction'=>"Sale",
                    'status1'=>$returnBy,
                    'status2'=>$returnBy,
                ]);
            }           
        } 
        //Transaksi Hutang dan tidak ada riwayat input yang sama 
        elseif ($tPembayaran < $tBelanja and $record == '0') {
            //Cek data pinjaman member
            $status = "3";
            $mBayar = '8';
            $kreditDesc = "Kredit 7 hari";
            $returnBy = "";
            $countKredit = DB::table('tr_kredit')
                ->where([
                    ['from_member_id', $memberID]
                ])
                ->count();
                
            $kreditPlus = $kredit + $absSelisih;
            DB::table('tr_kredit')
                ->insert([
                    'from_payment_code' => $noBill,
                    'from_member_id' => $memberID,
                    'nominal' => $tBelanja,
                    'nom_payed' => $tPembayaran,
                    'nom_kredit' => $absSelisih,
                    'nom_last_kredit' => $kredit,
                    'status' => '1',
                    'created_at' => now()
                ]);

            if ($countMethod == '0') {
                DB::table('tr_store')
                ->where('billing_number', $noBill)
                ->update([
                    'payment1'=>$namePembayaran,
                    'description'=>$kreditDesc,
                    'transaction'=>"Sale",
                    'status1'=>$returnBy,
                    'status2'=>$returnBy,
                ]);
            }
        } else {
            $status = "2";
        }

        DB::table('tr_store')
            ->where('billing_number', $noBill)
            ->update([
                't_bill' => $tBelanja,
                't_pay' => $tPembayaran,
                'tr_delivery' => $pengiriman,
                'ppn' => $ppn2,
                'ppn_nominal' => $nominalPPN2,
                'status' => $status,
                'updated_date' => now(),
                'is_delete' => '0',
                'is_return' => '0'
            ]);

        DB::table('tr_store_prod_list')
            ->where([
                ['from_payment_code', $noBill],
                ['is_delete', '!=', '1']
            ])
            ->update([
                'status' => $status,
                'updated_date' => now()
            ]);

        // //INSERT RECORD TRANSAKSI
        if ($tPembayaran >= $tBelanja) {
            $paymentRec = $tBelanja;
        } elseif ($tPembayaran <= $tBelanja) {
            $paymentRec = $tPembayaran;
        } else {
            $paymentRec = '0';
        }

        if ($record == '0') {
            DB::table('tr_payment_record')
                ->insert([
                    'trx_code' => $noBill,
                    'date_trx' => $trxLastBayar->tr_date,
                    'member_id' => $memberID,
                    'total_struk' => $tBelanja,
                    'total_payment' => $paymentRec,
                    'trx_method' => $mBayar,
                    'status' => '4'
                ]);
        } else {
            DB::table('tr_payment_record')
                ->where('trx_code', $noBill)
                ->update([
                    'date_trx' => $trxLastBayar->tr_date,
                    'member_id' => $memberID,
                    'total_struk' => $tBelanja,
                    'total_payment' => $paymentRec,
                    'trx_method' => $mBayar,
                    'status' => '4'
                ]);
        }

        //PAYMENT METHOD
        if (!isset($checkList)) {
            if ($countMethod == '0') {
                DB::table('tr_payment_method')
                    ->insert([
                        'core_id_trx' => $noBill,
                        'method_name' => $mBayar,
                        'bank_transfer' => $bankAccount,
                        'nominal' => $tBelanja,
                        'status' => '1',
                        'card_cus_account' => $accountCusName,
                        'card_cus_number' => $accountCusNumber
                    ]);
            } else {
                DB::table('tr_payment_method')
                    ->where('core_id_trx', $noBill)
                    ->update([
                        'method_name' => $mBayar,
                        'bank_transfer' => $bankAccount,
                        'nominal' => $tBelanja,
                        'status' => '1',
                        'card_cus_account' => $accountCusName,
                        'card_cus_number' => $accountCusNumber
                    ]);
            }
        }   
        
        DB::table('report_inv')
            ->where([
                ['number_code',$noBill],
                ['status_trx','2']
            ])
            ->update([
                'status_trx'=>'4'
            ]);
        
        if ($record >= '1' OR $tPembayaran >= $tBelanja) {
            $this->TempKeuanganController->kasBesarPenjualan($tBelanja, $updateBy, $trDate); 
        }
    }

    public function printTemplateCashier($noBill, $typeCetak)
    {
        // CASH => 4;
        // LOAN => 3;
        // SIMPAN => 2;
        // echo "Member : ".$noBillPrint;

        $createdBy = Auth::user()->name;
        $hakakses = Auth::user()->hakakses;


        $trStore = DB::table('view_billing_action')
            ->where('billing_number', $noBill)
            ->first();

        $dateRecord = $trStore->created_date;

        $trStoreList = DB::table('trans_product_list_view')
            ->where([
                ['from_payment_code', $noBill],
                ['is_delete', '0']
            ])
            ->get();

        $companyName = DB::table('m_company')
            ->first();

        $status = $trStore->status;
        $memberID = $trStore->member_id;

        $sumpaymentRecord = DB::table('tr_store_prod_list')
            ->select(DB::raw('SUM(t_price) as nominal'))
            ->where([
                ['from_payment_code', $noBill],
                ['is_delete', '0']
            ])
            ->first();

        $paymentRecord = DB::table('tr_payment_method as a')
            ->select('b.method_name as methodName', 'a.nominal as nominal', 'c.bank_name as namaBank', 'c.account_number as norek', 'a.method_name as codeMethod')
            ->leftJoin('m_payment_method as b', 'a.method_name', '=', 'b.idm_payment_method')
            ->leftJoin('m_company_payment as c', 'a.bank_transfer', '=', 'c.idm_payment')
            ->where([
                ['a.core_id_trx', $noBill],
                ['a.status', '1']
            ])
            ->get();

        $countBilling = DB::table('tr_kredit')
            ->where([
                ['nom_last_kredit', '!=', '0'],
                ['from_member_id', $memberID]
            ])
            ->count();

        $totalPayment = DB::table('tr_store_prod_list')
            ->select(DB::raw('SUM(t_price) as totalBilling'), DB::raw('COUNT(list_id) as countList'), DB::raw('SUM(disc) as sumDisc'))
            ->where([
                ['from_payment_code', $noBill],
                ['is_delete', '0']
            ])
            ->first();

        $remainKredit = DB::table('tr_kredit')
            ->select(DB::raw('SUM(nom_kredit) as kredit'))
            ->where([
                ['from_payment_code', '!=', $noBill],
                ['status', '1'],
                ['from_member_id', $memberID],
                ['created_date', '<', $dateRecord]
            ])
            ->first();

        $cekBon = DB::table('tr_kredit')
            ->select(DB::raw('SUM(nom_kredit) as kredit'))
            ->where([
                ['from_member_id', $memberID],
                ['status', '1']
            ])
            ->first();

        $point = DB::table('tr_member_point')
            ->select(DB::raw('SUM(point) as point'))
            ->where([
                ['core_member_id', $memberID],
                ['status', '1']
            ])
            ->first();

        if ($status == '4' and $typeCetak == '1') {
            return view('Cashier/cashierPrintOutPembayaran', compact('noBill', 'trStore', 'trStoreList', 'companyName', 'totalPayment', 'paymentRecord', 'cekBon', 'countBilling', 'remainKredit', 'point', 'sumpaymentRecord'));
        } elseif ($typeCetak == '2') {
            return view('Cashier/cashierPrintOutLoan', compact('noBill', 'trStore', 'trStoreList', 'companyName', 'totalPayment', 'paymentRecord', 'cekBon', 'countBilling', 'remainKredit', 'point', 'sumpaymentRecord'));
        } elseif ($status == '3') {
            return view('Cashier/cashierPrintOutKredit', compact('noBill', 'trStore', 'trStoreList', 'companyName', 'totalPayment', 'paymentRecord', 'cekBon', 'countBilling', 'remainKredit', 'point', 'sumpaymentRecord'));
        }
    }

    public function deleteAllTrx($noBill)
    {
        $deleteUser = Auth::user()->name;
        $nom_payed = 0;
        //Check data apakah user melakukan return dari F10
        $countStatus = DB::table('tr_return_record')
            ->where([
                ['trx_code', $noBill]
            ])
            ->count();

        $countFromHold = DB::table('tr_store')
            ->select('is_return')
            ->where('billing_number', $noBill)
            ->first();

        //UPDATE STOCK
        $prdList = DB::table('tr_store_prod_list')
            ->where([
                ['from_payment_code', $noBill],
            ])
            ->get();

        //Jika dilakukan return dari F10 atau nilai is_return dari tr_store = 1
        //Update status transaksi menjadi statu sebelumnya
        $trxList = DB::table('tr_store_prod_list')
            ->select(DB::raw('SUM(t_price) as total'))
            ->where([
                ['from_payment_code', $noBill],
                ['status', '!=', '0']
            ])
            ->first();

        $statusReturn = DB::table('tr_return_record')
            ->where([
                ['trx_code', $noBill]
            ])
            ->first();
            
        // if ($countFromHold->is_return == '1') {
        //     $lastStatus = '2';
        // } else {
        // }
        
        if ($countStatus >= '1') {
            // Hitung nominal transaksi 
            $lastStatus = $statusReturn->last_status_trx;
            if (!empty($statusReturn)) {
                //Jika is_return pada tabel tr_store sama dengan 1 maka kembalikan ke hold
                foreach ($prdList as $prdL) {
                    $totalPrice = $prdL->unit_price * $prdL->qty_history;
                    DB::table('tr_store_prod_list')
                        ->where([
                            ['from_payment_code', $noBill],
                            ['list_id', $prdL->list_id],
                            ['qty_history', '!=', null]
                        ])
                        ->update([
                            'qty' => $prdL->qty_history,
                            't_price' => $totalPrice
                        ]);
                }

                DB::table('tr_store')
                    ->where('billing_number', $noBill)
                    ->update(
                        [
                            'status' => $lastStatus,
                            't_bill' => $trxList->total,
                            'is_return' => '0'
                        ]
                    );

                DB::table('tr_store_prod_list')
                    ->where([
                        ['from_payment_code', $noBill],
                        ['is_delete','0']
                    ])
                    ->update([
                        'status' => $lastStatus,
                    ]);

                DB::table('tr_payment_record')
                    ->where('trx_code', $noBill)
                    ->update([
                        'total_struk' => $trxList->total,
                        'total_payment' => $trxList->total
                    ]);

                DB::table('tr_payment_method')
                    ->where('core_id_trx', $noBill)
                    ->update([
                        'nominal' => $trxList->total
                    ]);
                $trxKredit = DB::table('tr_kredit')
                    ->where('from_payment_code',$noBill)
                    ->first();
                if (!empty($trxKredit)) {
                    $nom_payed = $trxKredit->nom_payed;
                }
                $updateKredit = $trxList->total - $nom_payed;

                DB::table('tr_kredit')
                    ->where('from_payment_code',$noBill)
                    ->update([
                        'nominal'=>$trxList->total,
                        'nom_kredit'=>$updateKredit
                    ]);
            }
        } 
        else 
        {  // Mengubah status transaksi menjadi 0 /hapus
            foreach ($prdList as $pest) {
                $prodID = $pest->product_code;
                $unit = $pest->unit;
                $satuan1 = $pest->satuan;
                $qty = $pest->qty;

                // Cari kode unit pada m_product_unit
                $prodUnit = DB::table('view_product_stock');
                $prodUnit = $prodUnit->select('product_size', 'saldo', 'stock_out', 'stock');
                if ($satuan1 == NULL) {
                    $prodUnit = $prodUnit->where([
                        ['core_id_product', $prodID],
                        ['product_size', $unit]
                    ]);
                } else {
                    $prodUnit = $prodUnit->where([
                        ['core_id_product', $prodID],
                        ['product_satuan', $unit]
                    ]);
                }
                $prodUnit = $prodUnit->first();

                if ($satuan1 == NULL) {
                    $satuan = $prodUnit->product_size;
                } else {
                    $satuan = $satuan1;
                }

                $sumQty = $prodUnit->stock + $qty;
                $stockOut = $prodUnit->stock_out - $qty;

                //UPDATE STOCK
                $productUnit = DB::table('product_list_view as a')
                    ->select('a.*', 'b.location_id', 'b.stock', 'b.idinv_stock')
                    ->leftJoin('inv_stock as b', 'a.idm_product_satuan', 'b.product_id')
                    ->where([
                        ['a.core_id_product', $prodID],
                        ['a.product_volume', '!=', '0'],
                        ['a.product_satuan', '!=', ''],
                        ['b.location_id', '3']
                    ])
                    ->get();

                $volKonversi = DB::table('product_list_view') //mengambil data konversi
                    ->where('core_id_product', $prodID)
                    ->orderBy('size_code', 'desc')
                    ->first();

                $vol = $volKonversi->product_volume;

                $valKecil = DB::table('m_product_unit')
                    ->select('product_volume')
                    ->where([
                        ['core_id_product', $prodID],
                        ['size_code', '2']
                    ])
                    ->first();

                if (!empty($valKecil)) {
                    $volkodedua = $valKecil->product_volume;
                } else {
                    $volkodedua = $vol;
                }

                foreach ($productUnit as $p) {
                    $sizeCode = $p->size_code;
                    $prodZise = $p->product_size;
                    $vol2 = $p->product_volume;
                    // IF untuk memasukkan data stock besar

                    if ($sizeCode == '1') {
                        if ($satuan == "BESAR") {
                            $c = $sumQty;
                        } elseif ($satuan == "KECIL") {
                            $c1 = $qty / $volkodedua;
                            $c = $p->stock + (int)$c1;
                        } elseif ($satuan == "KONV") {
                            $c1 = $qty / $vol2;
                            $c = $p->stock + (int)$c1;
                        }
                    } elseif ($sizeCode == '2') {
                        if ($satuan == "BESAR") {
                            $c1 = $qty * $vol2;
                            $c = $p->stock + (int)$c1;
                        } elseif ($satuan == "KECIL") {
                            $c = $sumQty;
                        } elseif ($satuan == "KONV") {
                            $c1 = $qty / $vol2;
                            $c = $p->stock + (int)$c1;
                        }
                    } elseif ($sizeCode == '3') {
                        if ($satuan == "BESAR") {
                            $c1 = $qty * $vol2;
                            $c = $p->stock + (int)$c1;
                        } elseif ($satuan == "KECIL") {
                            $c1 = $qty * $volkodedua;
                            $c = $p->stock + (int)$c1;
                        } elseif ($satuan == "KONV") {
                            $c = $sumQty;
                        }
                    }
                    DB::table('inv_stock')
                        ->where([
                            ['idinv_stock', $p->idinv_stock]
                        ])
                        ->update([
                            'stock' => $c,
                            'stock_out' => $stockOut,
                            'saldo' => $c
                        ]);
                }                
            }

            DB::table('tr_store')
                ->where('billing_number', $noBill)
                ->update(
                    [
                        'status' => '0',
                        'is_return' => '1',
                        't_bill' => '0',
                        't_item' => '0',
                        'return_by' => $deleteUser
                    ]
                );
            DB::table('tr_store_prod_list')
                ->where('from_payment_code', $noBill)
                ->update([
                    'status' => '0',
                    'is_delete'=> '1'
                ]);

            DB::table('tr_payment_method')
                ->where('core_id_trx', $noBill)
                ->update([
                    'status' => '0'
                ]);

            DB::table('tr_payment_record')
                ->where('trx_code', $noBill)
                ->update([
                    'status' => '0'
                ]);
            $description = "Transaksi dibatalkan oleh : ".$deleteUser;
            $this->TempInventoryController->cencelPenjualan ($noBill, $description);
        }
    }

    public function tampilDataSimpan($fromDate, $endDate)
    {
        $today = date("Y-m-d");
        $hakakses = Auth::user()->hakakses;
        $persName = Auth::user()->name;
        $company = Auth::user()->company;

        $dataSaved = DB::table('view_trx_store');
        if ($hakakses == '1') {
            $dataSaved = $dataSaved->where([
                ["status", '2'],
                ['comp_id',$company]
            ]);
        }
        else {
            $dataSaved = $dataSaved->where([
                ["status", '2'],
                ['created_by',$persName],
                ['comp_id',$company]
            ]);
        }
        $dataSaved = $dataSaved->whereBetween("tr_date", [$fromDate, $endDate]);
        $dataSaved = $dataSaved->limit(20);
        $dataSaved = $dataSaved->get();

        return view('Cashier/cashierModalLoadDataSavedList', compact('dataSaved', 'fromDate', 'endDate'));
    }

    public function deleteHoldData($noBill)
    {
        //Update stock di inventory
        //select item transaksi
        $persName = Auth::user()->name;
        $listItem = DB::table('tr_store_prod_list')
            ->where('from_payment_code', $noBill)
            ->get();

        foreach ($listItem as $lt) {
            //Select product where idproduct
            $productID = $lt->product_code;
            $qty = $lt->qty;
            $satuan = $lt->satuan;
            $location = '3';

            $this->TempInventoryController->tambahStock($productID, $qty, $satuan, $location);
        }

        DB::table('tr_store')
            ->where('billing_number', $noBill)
            ->update([
                'status' => '0',
                'is_return' => '1',
                'return_by' => $persName
            ]);

        DB::table('tr_store_prod_list')
            ->where('from_payment_code', $noBill)
            ->delete();
    }
    public function loadDataSaved()
    {
        return view('Cashier/cashierModalLoadDataSaved');
    }

    public function postDataClosing(Request $reqPostClosing)
    {
        $fromdate = $reqPostClosing->fromdate;
        $enddate = $reqPostClosing->enddate;

        // DB::table('tr_payment_record')
        //     ->whereBetween('date_trx',[$fromdate, $enddate])
        //     ->update([
        //         'date_closing'=>now(),
        //         'status'=>'5'
        //     ]);

    }

    public function trxReportClosing($fromDate, $endDate)
    {
        $createdBy = Auth::user()->name;
        $hakakses = Auth::user()->hakakses;
        $userID = Auth::user()->id;

        $companyName = DB::table('m_company')
            ->first();

        $mSetKas = DB::table('m_set_kas')
            ->where('personal_id', $userID)
            ->where('status', '1')
            ->first();

        $trxTunai = DB::table('trx_record_view');
        $trxTunai = $trxTunai->select(DB::raw('SUM(total_payment) as total_payment'));
        if ($hakakses == '2') {
            $trxTunai = $trxTunai->where('created_by', $createdBy);
        }
        $trxTunai = $trxTunai->where([
            ['trx_method', '1'],
            ['status','4']
        ]);
        $trxTunai = $trxTunai->whereBetween('date_trx', [$fromDate, $endDate]);
        $trxTunai = $trxTunai->first();

        $trxKredit = DB::table('trx_record_view');
        $trxKredit = $trxKredit->select(DB::raw('SUM(total_struk) as total_struk'));
        if ($hakakses == '2') {
            $trxKredit = $trxKredit->where('created_by', $createdBy);
        }
        $trxKredit = $trxKredit->where('trx_method', '8');
        $trxKredit = $trxKredit->whereBetween('date_trx', [$fromDate, $endDate]);
        $trxKredit = $trxKredit->first();

        $trxPbHutang = DB::table('trx_kredit_record_view');
        $trxPbHutang = $trxPbHutang->select(DB::raw('SUM(total_payment) as total_payment'));
        if ($hakakses == '2') {
            $trxPbHutang = $trxPbHutang->where('created_by', $createdBy);
        }
        $trxPbHutang = $trxPbHutang->whereBetween('date_trx', [$fromDate, $endDate]);
        $trxPbHutang = $trxPbHutang->first();

        $trxDisc = DB::table('tr_store_prod_list');
        $trxDisc = $trxDisc->select(DB::raw('SUM(disc) as disc'));
        if ($hakakses == '2') {
            $trxDisc = $trxDisc->where('created_by', $createdBy);
        }
        $trxDisc = $trxDisc->whereBetween('date', [$fromDate, $endDate]);
        $trxDisc = $trxDisc->first();

        $bankTransaction = DB::table('view_trx_method as a');
        $bankTransaction = $bankTransaction->select(DB::raw('SUM(a.nominal) as totalTransfer'), 'a.bank_code', 'a.bank_name');
        $bankTransaction = $bankTransaction->leftJoin('m_company_payment as b', 'a.bank_transfer', '=', 'b.idm_payment');
        $bankTransaction = $bankTransaction->whereBetween('a.date_trx', [$fromDate, $endDate]);
        if ($hakakses == '2') {
            $bankTransaction = $bankTransaction->where('a.created_by', $createdBy);
        }
        $bankTransaction = $bankTransaction->where('a.method_name', '4');
        // $bankTransaction = $bankTransaction->groupBy('a.bank_code');
        $bankTransaction = $bankTransaction->get();

        $creditRecord = DB::table('trx_kredit_record_view');
        $creditRecord = $creditRecord->select(DB::raw('SUM(total_payment) as total_payment'));
        if ($hakakses == '2') {
            $creditRecord = $creditRecord->where('created_by', $createdBy);
        }
        $creditRecord = $creditRecord->whereBetween('date_trx', [$fromDate, $endDate]);
        $creditRecord = $creditRecord->first();


        return view('Cashier/cashierPrintOutClosing', compact('companyName', 'mSetKas', 'trxTunai', 'trxPbHutang', 'trxDisc', 'trxKredit', 'bankTransaction', 'creditRecord'));
    }

    public function cashierReportDetailPdf($fromDate, $endDate)
    {
        $createdBy = Auth::user()->name;
        $hakakses = Auth::user()->hakakses;
        $company = Auth::user()->company;

        $tableReport = DB::table("trx_record_view as a");
        $tableReport = $tableReport->leftJoin("tr_kredit as b", 'a.trx_code', '=', 'b.from_payment_code');
        if ($hakakses == '2') {
            $tableReport = $tableReport->where('created_by', $createdBy);
        }
        $tableReport = $tableReport->whereBetween('a.date_trx', [$fromDate, $endDate]);
        $tableReport = $tableReport->get();

        $trStore = DB::table("tr_store_prod_list")
            ->select('t_price', 'from_payment_code')
            ->whereBetween('date', [$fromDate, $endDate])
            ->get();

        $bankTransaction = DB::table('view_trx_method as a');
        $bankTransaction = $bankTransaction->select(DB::raw('SUM(a.nominal) as totalTransfer'), 'a.bank_code', 'a.bank_name');
        $bankTransaction = $bankTransaction->leftJoin('m_company_payment as b', 'a.bank_transfer', '=', 'b.idm_payment');
        $bankTransaction = $bankTransaction->whereBetween('a.date_trx', [$fromDate, $endDate]);
        if ($hakakses == '2') {
            $bankTransaction = $bankTransaction->where('a.created_by', $createdBy);
        }
        $bankTransaction = $bankTransaction->where('a.method_name', '4');
        $bankTransaction = $bankTransaction->groupBy('a.bank_code');
        $bankTransaction = $bankTransaction->get();

        $creditRecord = DB::table('trx_kredit_record_view');
        if ($hakakses == '2') {
            $creditRecord = $creditRecord->where('created_by', $createdBy);
        }
        $creditRecord = $creditRecord->whereBetween('date_trx', [$fromDate, $endDate]);
        $creditRecord = $creditRecord->get();

        $trxRecord = DB::table('view_billing_action');
        $trxRecord = $trxRecord->select('billing_number','tr_date','customer_name','t_bill','created_by');
        if ($hakakses == '2') {
            $trxRecord = $trxRecord->where('created_by', $createdBy);
        }
        $trxRecord = $trxRecord->where('status','>=','3');
        $trxRecord = $trxRecord->whereBetween('tr_date', [$fromDate, $endDate]);
        $trxRecord = $trxRecord->get();

        $tableMthodPayment = DB::table('view_trx_method');
        $tableMthodPayment = $tableMthodPayment->whereBetween('date_trx', [$fromDate, $endDate]);

        if ($hakakses == '2') {
            $tableMthodPayment = $tableMthodPayment->where('created_by', $createdBy);
        }
        $tableMthodPayment = $tableMthodPayment->where('status_by_store', '>=', '3');
        $tableMthodPayment = $tableMthodPayment->orderBy('core_id_trx', 'ASC');
        $tableMthodPayment = $tableMthodPayment->get();

        $grndTotalPembelian = DB::table('tr_store');
        $grndTotalPembelian = $grndTotalPembelian->select(DB::raw('SUM(t_bill) as grandTotalBelanja'));
        $grndTotalPembelian = $grndTotalPembelian->where('status', '<>', '0');
        $grndTotalPembelian = $grndTotalPembelian->whereBetween('tr_date', [$fromDate, $endDate]);
        if ($hakakses == '2') {
            $grndTotalPembelian = $grndTotalPembelian->where('created_by', $createdBy);
        }
        $grndTotalPembelian = $grndTotalPembelian->first();

        $pengeluaranKasir = DB::table('purchase_dana_payment as a');
        $pengeluaranKasir = $pengeluaranKasir->select('a.*','c.store_name');        
        $pengeluaranKasir = $pengeluaranKasir->leftJoin('view_purchase_order as c','a.purchase_number','=','c.purchase_number');
        if ($hakakses == '2') {
            $pengeluaranKasir = $pengeluaranKasir->where('a.kasir',$createdBy);
        }
        $pengeluaranKasir = $pengeluaranKasir->whereBetween('a.trx_date', [$fromDate, $endDate]);
        $pengeluaranKasir = $pengeluaranKasir->where('a.status','1');
        $pengeluaranKasir = $pengeluaranKasir->get();


        $pdf = PDF::loadview('Report/cashierDetailReport', compact('trxRecord','fromDate', 'endDate', 'tableReport', 'trStore', 'bankTransaction', 'creditRecord', 'tableMthodPayment', 'hakakses', 'grndTotalPembelian','pengeluaranKasir'))->setPaper("A4", 'portrait');
        return $pdf->stream();
    }

    public function cashierReportRecapPdf($fromDate, $endDate, $customer)
    {        
        $tableReport = DB::table("trx_record_view as a");
        $tableReport = $tableReport->select(DB::raw('SUM(total_struk) as total_struk'), DB::raw('SUM(total_payment) as total_payment'));
        $tableReport = $tableReport->leftJoin("tr_kredit as b", 'a.trx_code', '=', 'b.from_payment_code');
        $tableReport = $tableReport->where([
                ['a.status','!=','0']
        ]);
        if ($customer <> '0') {
            $tableReport = $tableReport->where([
                    ['a.member_id',$customer]
            ]);
        }
        $tableReport = $tableReport->whereBetween('a.date_trx', [$fromDate, $endDate]);
        $tableReport = $tableReport->first();

        $tableReportTunai = DB::table("trx_record_view as a");
        $tableReportTunai = $tableReportTunai->select(DB::raw('SUM(total_struk) as total_struk'), DB::raw('SUM(total_payment) as total_payment'));
        $tableReportTunai = $tableReportTunai->leftJoin("tr_kredit as b", 'a.trx_code', '=', 'b.from_payment_code');
        $tableReportTunai = $tableReportTunai->where([
                ['a.status','!=','0']
        ]);
        if ($customer <> '0') {
            $tableReportTunai = $tableReportTunai->where([
                ['a.status','!=','0']
            ]);
        }
        $tableReportTunai = $tableReportTunai->whereBetween('a.date_trx', [$fromDate, $endDate]);
        $tableReportTunai = $tableReportTunai->where('a.trx_method', '1');
        $tableReportTunai = $tableReportTunai->first();

        $trStore = DB::table("tr_store_prod_list")
            ->select('t_price', 'from_payment_code')
            ->whereBetween('date', [$fromDate, $endDate])
            ->get();

        $bankTransaction = DB::table('trx_record_view');
        $bankTransaction = $bankTransaction->select(DB::raw('SUM(total_payment) as totalTransfer'), 'bank_code', 'bank_name');
        $bankTransaction = $bankTransaction->whereBetween('date_trx', [$fromDate, $endDate]);
        $bankTransaction = $bankTransaction->where([
                ['status','!=','0'],
                ['trx_method', '4']
        ]);
        if ($customer <> '0') {
            $bankTransaction = $bankTransaction->where([
                ['member_id',$customer],
        ]);
        }
        $bankTransaction = $bankTransaction->first();

        $creditRecord = DB::table('trx_kredit_record_view');
        $creditRecord = $creditRecord->select(DB::raw('SUM(total_payment) as totalBon'));
        if ($customer <> '0') {
            $creditRecord = $creditRecord->where('member_id',$customer);
        }
        $creditRecord = $creditRecord->whereBetween('date_trx', [$fromDate, $endDate]);
        $creditRecord = $creditRecord->first();   
        
        $customerIden = DB::table('m_customers')
            ->where('idm_customer',$customer)
            ->first();

        $pdf = PDF::loadview('Report/cashierRecapReport', compact('fromDate', 'endDate', 'tableReport', 'trStore', 'bankTransaction', 'creditRecord', 'tableReportTunai','customer','customerIden'))->setPaper("A4", 'portrait');
        return $pdf->stream();
    }

    public function trxReportRecapExcel($fromDate, $endDate)
    {
        $prdTrx = DB::table('trans_product_list_view as a')
            ->leftJoin('view_billing_action as c', 'a.from_payment_code', '=', 'c.billing_number')
            ->where([
                ['a.status', '>=', '3'],
                ['c.status','>=','3']
                ])
            ->whereBetween('c.tr_date', [$fromDate, $endDate])
            ->get();

        $tempTPrice = DB::table('trans_product_list_view as a')
            ->select(DB::raw('SUM(a.t_price) as sumTPrice'), 'c.billing_number')
            ->leftJoin('view_billing_action as c', 'a.from_payment_code', '=', 'c.billing_number')
            ->where('a.status', '>=', '3')
            ->groupBy('a.from_payment_code')
            ->whereBetween('a.date', [$fromDate, $endDate])
            ->get();

        $cosGroup = DB::table('m_cos_group')
            ->where('group_status','1')
            ->get();

        $paymentMethod = DB::table('tr_payment_method as a')
            ->select('a.core_id_trx','b.method_name','a.nominal','b.idm_payment_method')
            ->leftJoin('m_payment_method as b','a.method_name','=','b.idm_payment_method')
            ->where('a.status','1')
            ->get();
        
        $countPerTrx = DB::table('tr_payment_method as a')
            ->select('a.core_id_trx', DB::raw('count(a.core_id_trx) as countTrx'))            
            ->where('a.method_name','!=','8')
            ->groupBy('a.core_id_trx')
            ->get();

        $Supplier = DB::table('supplier_item')
            ->get();        

        return view('Report/cashierRecapExcel', compact('prdTrx', 'tempTPrice','cosGroup','paymentMethod','countPerTrx','Supplier'));
    }

    public function clickListProduk($dataTrx, $trxType)
    {
        // CHECK DATA SEBELUMNYA ADA YANG AKTIF ATAU TIDAK 
        $countAc = DB::table('tr_store')
            ->where('status', '1')
            ->count();

        if ($countAc >= '1') {
            DB::table('tr_store')
                ->where('status', '1')
                ->update([
                    'status' => '2',
                ]);

            DB::table('tr_store_prod_list')
                ->where('status', '1')
                ->update([
                    'status' => '2',
                ]);
        }

        DB::table('tr_store')
            ->where('billing_number', $dataTrx)
            ->update([
                'status' => '1',
            ]);

        DB::table('tr_store_prod_list')
            ->where('from_payment_code', $dataTrx)
            ->update([
                'status' => '1',
            ]);
    }

    public function unlockReturn(Request $reqUnlock)
    {
        $datBilling = $reqUnlock->dataId;
        $datAction = $reqUnlock->dataAction;
        $userName = $reqUnlock->userName;
        $password = $reqUnlock->passInput;
        $actionBy = Auth::user()->name;
        $countActiveDisplay = $this->checkTrxActive();

        // $countAkun = DB::table('admin_token as a')
        //     ->leftJoin('users as b', 'b.id', '=', 'a.user_id')
        //     ->where([
        //         ['b.username', $userName],
        //         ['a.user_token', $password],
        //         ['b.hakakses', '1']
        //     ])
        //     ->count();

        // $adminCheck = DB::table('admin_token as a')
        //     ->leftJoin('users as b', 'b.id', '=', 'a.user_id')
        //     ->where([
        //         ['b.username', $userName],
        //         ['a.user_token', $password],
        //         ['b.hakakses', '1']
        //     ])
        //     ->get();

        //User Password
        $checkUser = DB::table('users')
            ->where('username',$userName)
            ->first(); 

        if (!empty($checkUser)) {
            $adminPass = $checkUser->password;
            $passCheck = Hash::check($password, $adminPass);
            if ($passCheck == true) {
                $cekStatusTrx = DB::table('tr_store')
                    ->where([
                        ['billing_number', $datBilling]
                    ])
                    ->first();
    
                // INSERT DATA RETURN
                DB::table('tr_return_record')
                    ->insert([
                        'trx_code' => $datBilling,
                        'last_payment' => $cekStatusTrx->t_pay,
                        'new_payment' => $cekStatusTrx->t_pay,
                        'return_date' => now(),
                        'update_by' => $actionBy,
                        'last_status_trx' => $cekStatusTrx->status,
                    ]);
                if ($datAction == '1') { // DELETE TRANSAKSI
                    //UPDATE STOCK
                    // $trPrdList = DB::table('tr_store')
                    //     ->where('billing_number', $datBilling)
                    //     ->get();
                    // foreach ($trPrdList as $keyPrd) {
    
                    // }
                    $dataTransaksi = DB::table('tr_store_prod_list')
                        ->where('from_payment_code', $datBilling)
                        ->get();
    
                    $paymentMethod = DB::table('trx_record_view')
                        ->select('method_name', 'bank_name', 'bank_code')
                        ->where('trx_code', $datBilling)
                        ->first();
    
                    foreach ($dataTransaksi as $iDelete) {
                        DB::table('tr_delete_record')
                            ->insert([
                                'trx_code' => $iDelete->from_payment_code,
                                'prod_code' => $iDelete->product_code,
                                'qty' => $iDelete->qty,
                                'unit' => $iDelete->unit,
                                'unit_price' => $iDelete->unit_price,
                                'disc' => $iDelete->disc,
                                't_price' => $iDelete->t_price,
                                'deleted_by' => $actionBy,
                                'payment_method' => $paymentMethod->method_name,
                                'bank_name' => $paymentMethod->bank_name,
                                'bank_card' => $paymentMethod->bank_code,
                            ]);
                        $productID = $iDelete->product_code;
                        $qty = $iDelete->qty;
                        $satuan = $iDelete->satuan;
                        $location = '3';
    
                        $this->TempInventoryController->tambahStock($productID, $qty, $satuan, $location);
                    }
    
                    DB::table('tr_store')
                        ->where('billing_number', $datBilling)
                        ->update([
                            'is_delete' => '1',
                            'status' => '0'
                        ]);
    
                    DB::table('tr_store_prod_list')
                        ->where('from_payment_code', $datBilling)
                        ->update([
                            'status' => '0',
                        ]);
    
                    DB::table('tr_payment_record')
                        ->where('trx_code', $datBilling)
                        ->update([
                            'status' => '0'
                        ]);
    
                    DB::table('tr_payment_method')
                        ->where('core_id_trx', $datBilling)
                        ->update([
                            'status' => '0'
                        ]);
    
                    DB::table('tr_kredit')
                        ->where('from_payment_code', $datBilling)
                        ->update([
                            'status' => '0'
                        ]);
                    
                    DB::table('report_inv')
                        ->where('number_code',$datBilling)
                        ->delete();
                        
                } elseif ($datAction == '2') {
                    $countAc = DB::table('tr_store')
                        ->where([
                            ['status', '1'],
                            ['created_by', $actionBy]
                        ])
                        ->count();
    
                    if ($countAc >= '1') {
                        //Jika ada data yang masih aktif di display user maka akan di update ke data hold
                        DB::table('tr_store')
                            ->where('status', '1')
                            ->update([
                                'status' => '2',
                            ]);
    
                        DB::table('tr_store_prod_list')
                            ->where('status', '1')
                            ->update([
                                'status' => '2',
                            ]);
                    }
    
                    //Rubah status menjadi 1
                    DB::table('tr_store')
                        ->where('billing_number', $datBilling)
                        ->update([
                            'status' => '1',
                            'return_by' => $actionBy
                        ]);
    
                    DB::table('tr_store_prod_list')
                        ->where([
                            ['from_payment_code', $datBilling],
                            ['is_delete','!=','1']
                            ])
                        ->update([
                            'status' => '1',
                        ]);
    
                    DB::table('tr_payment_record')
                        ->where('trx_code', $datBilling)
                        ->update([
                            'status' => "0"
                        ]);
                }
                // NOTE :: Jika $datAction == 1 melakukan penghapusan transaksi
                // jika $datAction == 2 menampilkan item pada display transaksi kasir. 
    
                $msg = array('success' => 'Nice, anda adalah administrator');
            }
            elseif ($countActiveDisplay >= '1') {
                $msg = array('warning' => 'Mohon lakukan HOLD pada transaksi yang sedang ada pada tampilan kasir saat ini !');
            }
            else {
                $msg = array('warning' => 'Username dan Password yang anda masukkan salah, silahkan periksa kembali !');
            }
        }
        else {
            $msg = array('warning' => 'Username yang anda masukkan salah, silahkan periksa kembali !');
        }
        
        // if ($countAkun == '0') {
        //     $msg = array('warning' => 'Anda bukan admin editor, silahkan hubungi administrator');
        // } elseif ($countActiveDisplay >= '1') {
        //     $msg = array('warning' => 'Mohon hold terlebih dahulu transaksi yang sedang aktif');
        // } else {
        //     $cekStatusTrx = DB::table('tr_store')
        //         ->where([
        //             ['billing_number', $datBilling]
        //         ])
        //         ->first();

        //     // INSERT DATA RETURN
        //     DB::table('tr_return_record')
        //         ->insert([
        //             'trx_code' => $datBilling,
        //             'last_payment' => $cekStatusTrx->t_pay,
        //             'new_payment' => $cekStatusTrx->t_pay,
        //             'return_date' => now(),
        //             'update_by' => $actionBy,
        //             'last_status_trx' => $cekStatusTrx->status,
        //         ]);

        //     foreach ($adminCheck as $aC) {
        //         if ($password == $aC->user_token) {
        //             if ($datAction == '1') { // DELETE TRANSAKSI
        //                 //UPDATE STOCK
        //                 $trPrdList = DB::table('tr_store')
        //                     ->where('billing_number', $datBilling)
        //                     ->get();

        //                 // foreach ($trPrdList as $keyPrd) {

        //                 // }
        //                 $dataTransaksi = DB::table('tr_store_prod_list')
        //                     ->where('from_payment_code', $datBilling)
        //                     ->get();

        //                 $paymentMethod = DB::table('trx_record_view')
        //                     ->select('method_name', 'bank_name', 'bank_code')
        //                     ->where('trx_code', $datBilling)
        //                     ->first();

        //                 foreach ($dataTransaksi as $iDelete) {
        //                     DB::table('tr_delete_record')
        //                         ->insert([
        //                             'trx_code' => $iDelete->from_payment_code,
        //                             'prod_code' => $iDelete->product_code,
        //                             'qty' => $iDelete->qty,
        //                             'unit' => $iDelete->unit,
        //                             'unit_price' => $iDelete->unit_price,
        //                             'disc' => $iDelete->disc,
        //                             't_price' => $iDelete->t_price,
        //                             'deleted_by' => $actionBy,
        //                             'payment_method' => $paymentMethod->method_name,
        //                             'bank_name' => $paymentMethod->bank_name,
        //                             'bank_card' => $paymentMethod->bank_code,
        //                         ]);
        //                     $productID = $iDelete->product_code;
        //                     $qty = $iDelete->qty;
        //                     $satuan = $iDelete->satuan;
        //                     $location = '3';

        //                     $this->TempInventoryController->tambahStock($productID, $qty, $satuan, $location);
        //                 }

        //                 DB::table('tr_store')
        //                     ->where('billing_number', $datBilling)
        //                     ->update([
        //                         'is_delete' => '1',
        //                         'status' => '0'
        //                     ]);

        //                 DB::table('tr_store_prod_list')
        //                     ->where('from_payment_code', $datBilling)
        //                     ->update([
        //                         'status' => '0',
        //                     ]);

        //                 DB::table('tr_payment_record')
        //                     ->where('trx_code', $datBilling)
        //                     ->update([
        //                         'status' => '0'
        //                     ]);

        //                 DB::table('tr_payment_method')
        //                     ->where('core_id_trx', $datBilling)
        //                     ->update([
        //                         'status' => '0'
        //                     ]);

        //                 DB::table('tr_kredit')
        //                     ->where('from_payment_code', $datBilling)
        //                     ->update([
        //                         'status' => '0'
        //                     ]);
                        
        //                 DB::table('report_inv')
        //                     ->where('number_code',$datBilling)
        //                     ->delete();
                            
        //             } elseif ($datAction == '2') {
        //                 $countAc = DB::table('tr_store')
        //                     ->where([
        //                         ['status', '1'],
        //                         ['created_by', $actionBy]
        //                     ])
        //                     ->count();

        //                 if ($countAc >= '1') {
        //                     //Jika ada data yang masih aktif di display user maka akan di update ke data hold
        //                     DB::table('tr_store')
        //                         ->where('status', '1')
        //                         ->update([
        //                             'status' => '2',
        //                         ]);

        //                     DB::table('tr_store_prod_list')
        //                         ->where('status', '1')
        //                         ->update([
        //                             'status' => '2',
        //                         ]);
        //                 }

        //                 //Rubah status menjadi 1
        //                 DB::table('tr_store')
        //                     ->where('billing_number', $datBilling)
        //                     ->update([
        //                         'status' => '1',
        //                         'return_by' => $actionBy
        //                     ]);

        //                 DB::table('tr_store_prod_list')
        //                     ->where([
        //                         ['from_payment_code', $datBilling],
        //                         ['is_delete','!=','1']
        //                         ])
        //                     ->update([
        //                         'status' => '1',
        //                     ]);

        //                 DB::table('tr_payment_record')
        //                     ->where('trx_code', $datBilling)
        //                     ->update([
        //                         'status' => "0"
        //                     ]);
        //             }
        //             // Jika 1 lakukan delete data, jika 2 lakukan show data

        //             $msg = array('success' => 'SUCCESS!');
        //         } else {
        //             $msg = array('warning' => 'ERROR!,password salah.');
        //         }
        //     }
        // }
        return response()->json($msg);
    }

    public function modalDelete($idTrx)
    {
        return view('Cashier/cashierModalDeleteData', compact('idTrx'));
    }

    public function postDaleteData(Request $reqIdTrx)
    {
        $idTrx = $reqIdTrx->idTrx;
        $actionBy = Auth::user()->name;
        DB::table('tr_store')
            ->where('billing_number', $idTrx)
            ->update([
                't_bill' => '0',
                't_item' => '0',
                'status' => '0',
                'updated_by' => $actionBy,
                'is_delete' => '1'
            ]);

        DB::table('tr_store_prod_list')
            ->where('from_payment_code', $idTrx)
            ->update([
                'status' => '0'
            ]);
    }

    public function changeDate(Request $reqChangeDate)
    {
        $tableName = $reqChangeDate->tablename;
        $column = $reqChangeDate->column;
        $editval = $reqChangeDate->editval;
        $id = $reqChangeDate->id;
        $dataId = $reqChangeDate->dataId;
        $numberTrx = $reqChangeDate->billNumber;
        $userEdited = Auth::user()->name;
        
        $countNumber = DB::table('tr_store')
            ->where('tr_date',$editval)
            ->count();

        $thisDate = date("dmy", strtotime($editval));
        if ($countNumber == 0) {
            $no = "1";
            $pCode = "P" . $thisDate . "-" . sprintf("%07d", $no);
        }
        else {
            $no = $countNumber + 1;
            $pCode = "P" . $thisDate . "-" . sprintf("%07d", $no);
        }

        $selectInfoData = DB::table('tr_store')
            ->where($dataId, $id)
            ->first();

        $billNumber = $selectInfoData->billing_number;

        //Change tr_kredit
        DB::table('tr_kredit')
            ->where('from_payment_code',$billNumber)
            ->update([
                'from_payment_code'=>$pCode,
                'created_at'=>$editval
            ]);

        //Change tr_kredit_record
        DB::table('tr_kredit_record')
            ->where('trx_code',$billNumber)
            ->update([
                'trx_code'=>$pCode,
                'date_trx'=>$editval
            ]);

        //Change tr_payment_method
        DB::table('tr_payment_method')
            ->where('core_id_trx',$billNumber)
            ->update([
                'core_id_trx'=>$pCode,                
            ]);

        //Change tr_payment_record
        DB::table('tr_payment_record')
            ->where('trx_code',$billNumber)
            ->update([
                'trx_code'=>$pCode
            ]);

        //Change tr_store_prod_list
        DB::table('tr_store_prod_list')
            ->where('from_payment_code',$billNumber)
            ->update([
                'from_payment_code'=>$pCode,
                'date'=>$editval
            ]);
        
        //Change laporan inventory
        DB::table('report_inv')
            ->where('number_code',$billNumber)
            ->update([
                'number_code'=>$pCode,
                'date_input'=>$editval
            ]);
        
            
            DB::table('tr_store')
            ->where($dataId, $id)
            ->update([
                $column => $editval,
                'billing_number'=>$pCode,
                'updated_date'=>now()
            ]);

            DB::table('tr_store')
                ->insert([
                    'store_id'=>'3',
                    'billing_number'=>$numberTrx,
                    'tr_date'=>now(),
                    'status'=>'0',
                    'return_by'=>$userEdited,
                    'created_by'=>$userEdited,
                    'created_date'=>now(),
                    'is_return'=>'1'
                ]);
            

    }

    // add temporer trx
    public function addTmpTrx($prdID, $billNumber)
    {
        $actionBy = Auth::user()->name;
        DB::table("tr_temp_prod")
            ->insert([
                'bill_number' => $billNumber,
                'product_id' => $prdID,
                'status' => '1',
                'created_at' => now(),
                'created_by' => $actionBy
            ]);
    }

    // function update stock 
    public function penguranganStock($productID, $location, $prodSatuan, $prodQty){
        // Start Update Stock        
        $dataStock = DB::table('view_product_stock')
            ->where([
                ['idm_data_product', $productID],
                ['location_id', '3']
            ])
            ->get();

        // Cek volume by kode size 2
        $codeSatu = DB::table('view_product_stock')
            ->where([
                ['idm_data_product', $productID],
                ['location_id', '3'],
                ['size_code', '1'],
            ])
            ->first();

        $codeDua = DB::table('view_product_stock')
            ->where([
                ['idm_data_product', $productID],
                ['location_id', '3'],
                ['size_code', '2'],
            ])
            ->first();

        $codeTiga = DB::table('view_product_stock')
            ->where([
                ['idm_data_product', $productID],
                ['location_id', '3'],
                ['size_code', '3'],
            ])
            ->first();

        $stock1 = $codeSatu->stock;
        $vol1 = $codeSatu->product_volume;

        if (!empty($codeDua)) {
            $stock2 = $codeDua->stock;
            $vol2 = $codeDua->product_volume;
        }
        else {
            $stock2 = $stock1;
            $vol2 = $vol1;            
        }

        if (!empty($codeTiga)) {
            $stock3 = $codeTiga->stock;
            $vol3 = $codeTiga->product_volume;
        }
        else {
            $stock2 = $stock2;
            $vol2 = $vol2;            
        }

        foreach ($dataStock as $ds) {
            if ($prodSatuan == "BESAR") { // Jika yang dimasukkan adalah satuan Besar
                if ($ds->size_code == '1') { // Jika kode dalam list 1
                    $a = $ds->stock - $prodQty;
                } elseif ($ds->size_code == '2') {
                    $a1 = $prodQty * $vol1;
                    $a = $ds->stock - $a1;
                } elseif ($ds->size_code == '3') {
                    $a1 = $ds->product_volume * $prodQty;
                    $a = $ds->stock - $a1;
                }
            } elseif ($prodSatuan == "KECIL") { // Jika yang idmasukkan adalah satuan kecil
                if ($ds->size_code == '1') { // Jika kode dalam list 1
                    $a1 = $stock1 * $vol1;
                    $a2 = $a1 - $prodQty;
                    $a3 = $a2 / $codeSatu->product_volume;
                    $a = (int)$a3;  
                } elseif ($ds->size_code == '2') {
                    $a1 = $ds->stock - $prodQty;
                    $a = (int)$a1;
                } elseif ($ds->size_code == '3') {
                    $a1 = $prodQty * $vol2;
                    $a2 = $stock3 - $a1;
                    $a = (int)$a2;
                }
            } elseif ($prodSatuan == "KONV") {
                $ab = $stock3 - $prodQty;

                if ($ds->size_code == '1') { // Jika kode dalam list 1
                    $a1 = $ab / $vol3;
                    $a = (int)$a1;
                } elseif ($ds->size_code == '2') {
                    $a1 = $ab / $vol2;
                    $a = (int)$a1;
                } elseif ($ds->size_code == '3') {
                    $a = $ds->stock - $prodQty;
                }
            }

            DB::table('inv_stock')
                ->where('idinv_stock', $ds->idinv_stock)
                ->update([
                    'location_id' => '3',
                    'stock' => $a,
                    'stock_out' => $prodQty,
                    'saldo' => $a
                ]);            
        }
        
    }
}
