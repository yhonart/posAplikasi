<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class ZAdditionalPosController extends Controller
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
    
    public function checkuserInfo()
    {
        $userID = Auth::user()->id;
        $cekUserArea = DB::table('view_user_work_area')
            ->select('area_id')
            ->where('id', $userID)
            ->first();

        if (!empty($cekUserArea)) {
            $userAreaID = $cekUserArea->area_id;
        } else {
            $userAreaID = 0;
        }

        return $userAreaID;
    }
    
    public function getInfoNumber()
    {
        $username = Auth::user()->name;
        $area = $this->checkuserInfo();
        $hakAkses = Auth::user()->hakakses;
        $dateDB = date("Y-m-d");
        $dateBill = date("dmy");
        $company = Auth::user()->company;
        $getCompanyCode = DB::table('m_company')
            ->select('company_code')
            ->where('idm_company', $company)
            ->first();
        $companyCode = $getCompanyCode->company_code;
        //Cek apakah ada nomor transaksi yang di return
        $countBill = DB::table('tr_store')
            ->where([
                ['status','1'],
                ['comp_id',$company],
                ['created_by',$username],
                ['tr_date', $dateDB]
            ])
            ->count();

        if ($countBill == '0') { // Jika Tidak Ada
            $countOfBill = DB::table('tr_store')
                ->where([
                    ['comp_id',$company],
                    ['tr_date', $dateDB],
                    ['created_by',$username]
                ])
                ->count();
            $newBillNumber = $countOfBill + 1;
            $newBillNumber = "TR" . $companyCode . $dateBill . str_pad($newBillNumber, 3, '0', STR_PAD_LEFT);
        }
        else {
            $getBillNumber = DB::table('tr_store')
                ->select('billing_number')
                ->where([
                    ['status','1'],
                    ['comp_id',$company],
                    ['tr_date', $dateDB],
                    ['created_by',$username]
                ])
                ->orderBy('billing_number', 'DESC')
                ->first();
            $newBillNumber = $getBillNumber->billing_number;
        }

        return $newBillNumber;
    }   

    public function AdditionalProductList()
    {
        $billNumber = $this->getInfoNumber();
        return view('Cashier/z_additional_product_list', compact('billNumber'));
    }

    public function cariProduk($keyword, $trxNumber){
        // echo $keyword." ".$trxNumber;
        $barcode = "";
        $username = Auth::user()->name;
        $company = Auth::user()->company;
        $cosGroup = 1;

        $getBarcode = DB::table('m_product_unit')
            ->where('set_barcode', $keyword)
            ->first();  

        if (!empty($getBarcode)) {
            $barcode = $getBarcode->set_barcode;
            $productList = DB::table('view_product_stock');            
            $productList = $productList->where([
                ['set_barcode', $keyword],
                ['comp_id',$company]
            ]);
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
                    ['from_payment_code', $trxNumber],
                    ['product_code',$product],
                    ['unit',$unit],
                    ['status','>=','1']
                ])
                ->count();

            if ($countItem == '0') {
                DB::table('tr_store_prod_list')
                    ->insert([
                        'from_payment_code'=>$trxNumber,
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
                        ['from_payment_code', $trxNumber],
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
                        ['from_payment_code', $trxNumber],
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
            $location = $this->checkuserInfo();
            $prodQty = '1';
            $description = "Penjualan ".$username;                
            $this->TempInventoryController->reportBarangKeluar($product, $satuan, $location, $prodQty, $description, $trxNumber, $username);
            $this->penguranganStock($product, $location, $satuan, $prodQty);
        }
        else {
            # code...
        }
    }
}
