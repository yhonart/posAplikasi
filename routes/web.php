<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(); 
Route::get('/forgot-password', function () {
    return view('auth.passwords.reset');
})
->middleware('guest')->name('password.request');

// Route::group(['middleware' => ['auth', 'check_ajax']], function () {
// });
Route::get('/', function () {
    if (Auth::check()) {
        $hakakses = Auth::user()->hakakses;
        $checkArea = Auth::user()->count_area;
        $checkGroup = 1;
        $module = "AM3";
        if($hakakses == '1' OR $hakakses == '99'){            
            return view('Dashboard/mainAdminDashboard');
        }
        elseif($hakakses == '2'){
            return view('Cashier/maintenancePage', compact('checkArea','checkGroup','module'));
        }
        elseif ($hakakses == '3') {
            return view('Sales/mainSales', compact('checkArea'));
        }
        elseif ($hakakses == '4') { //Admin Sales
            return view('Sales/adminSales', compact('checkArea'));
        }
        elseif ($hakakses == '5') { //Kurir
            return view('Sales/Kurir', compact('checkArea'));
        }
    }
    else {
        return view('auth.login');
    }
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');    
Route::get('/home/dashPenjualan', [App\Http\Controllers\HomeController::class, 'dashPenjualan']);    
Route::get('/home/storeName', [App\Http\Controllers\HomeController::class, 'storeName']);
Route::get('/home/changeCloseData', [App\Http\Controllers\HomeController::class, 'changeCloseData']);
Route::get('/home/getMenu', [App\Http\Controllers\HomeController::class, 'getMenu']);
Route::get('home/mainMenu', [App\Http\Controllers\HomeController::class, 'mainMenu']);
Route::get('home/GetGlobaDelete/WithDeleteId/{dataId}/{dataTb}/{dataCol}', [App\Http\Controllers\HomeController::class, 'GlobalDelete']);
Route::post('home/GlobalLiveEditTable', [App\Http\Controllers\HomeController::class, 'GlobalEditTable']);
Route::get('/home/searchingMenu/{keyword}', [App\Http\Controllers\HomeController::class, 'searchingMenu']);
Route::get('home/displayPembelian', [App\Http\Controllers\DashboardController::class, 'displayPembelian']);
Route::get('home/displayPembelian/hutangPembelian', [App\Http\Controllers\DashboardController::class, 'hutangPembelian']);

Route::get('Stock', [App\Http\Controllers\StockListController::class, 'getMenu'])->name('Stock');
Route::get('MoU', [App\Http\Controllers\MoUController::class, 'mainIndex'])->name('MoU');
Route::get('Supplier', [App\Http\Controllers\SuplayerController::class, 'mainIndex'])->name('Supplier');
Route::get('Customers', [App\Http\Controllers\CustomersController::class, 'mainIndex'])->name('Customers');
Route::get('Personalia', [App\Http\Controllers\PersonaliaController::class, 'mainIndex'])->name('Personalia');
Route::get('TransProduct', [App\Http\Controllers\TransactionController::class, 'mainTransaction'])->name('TransProduct');
Route::get('Cashier', [App\Http\Controllers\CashierController::class, 'mainCashier'])->name('Cashier');
Route::get('Delivery', [App\Http\Controllers\DeliveryController::class, 'mainDelivery'])->name('Delivery');
Route::post('Dashboard/loadDataTransaksi/postOnClick', [App\Http\Controllers\DashboardController::class, 'onClickDetail']);
Route::post('Dashboard/loadDataTransaksi/postChangesStatus', [App\Http\Controllers\DashboardController::class, 'postChangesStatus']);
Route::get('Dashboard/loadDataTransaksi/getTrxByKasir/{kasir}/{fromDate}/{endDate}', [App\Http\Controllers\DashboardController::class, 'getTrxByKasir']);

Route::get('Dashboard/manualInsertKasBesar', [App\Http\Controllers\HomeController::class, 'manualInsertKasBesar']);

Route::get('UnderMaintenance', [App\Http\Controllers\HomeController::class, 'UnderMaintenance'])->name('UnderMaintenance');

//Purchasing
Route::get('Purchasing', [App\Http\Controllers\PurchasingController::class, 'mainPurch'])->name('Purchasing');
Route::get('returnItem', [App\Http\Controllers\ReturnItemController::class, 'mainReturn'])->name('returnItem');

// Dashboard
Route::get('Dashboard', [App\Http\Controllers\DashboardController::class, 'mainDashboard'])->name('Dashboard');
Route::get('Dashboard/loadDataTransaksi/{fromDate}/{endDate}', [App\Http\Controllers\DashboardController::class, 'lodaDataTransaksi']);
Route::get('Dashboard/modalLogTrx/{noBill}', [App\Http\Controllers\DashboardController::class, 'modalLogTrx']);

Route::get('Dashboard/garphPembelian/{year}/{quartal}', [App\Http\Controllers\DashboardController::class, 'garphPembelian']);
Route::get('Dashboard/displayOnTable/tablePenjualan/{fromDate}/{endDate}', [App\Http\Controllers\DashboardController::class, 'tablePenjualan']);
Route::get('Dashboard/displayOnTable/tableHutang/{fromDate}/{endDate}', [App\Http\Controllers\DashboardController::class, 'tableHutang']);
Route::get('Dashboard/displayOnTable/tablePembelian/{fromDate}/{endDate}', [App\Http\Controllers\DashboardController::class, 'tablePembelian']);

// Inventory
Route::get('remainingStock', [App\Http\Controllers\RemainingController::class, 'remainingStock'])->name('remainingStock');

// Stock Opname
Route::get('stockOpname', [App\Http\Controllers\StockopnameController::class, 'stockOpname'])->name('stockOpname');

// Koreksi Barang
Route::get('koreksiBarang', [App\Http\Controllers\CorrectPrdController::class, 'koreksiBarang'])->name('koreksiBarang');

// Mutasi
Route::get('mutasi', [App\Http\Controllers\MutasibarangController::class, 'mutasi'])->name('mutasi');

// Accounting
Route::get('Accounting', [App\Http\Controllers\AccountingController::class, 'getMenu'])->name('Accounting');
Route::get('piutangPelanggan', [App\Http\Controllers\AccountingController::class, 'piutangPelanggan'])->name('piutangPelanggan');

// Store
Route::get('Store', [App\Http\Controllers\StoreController::class, 'mainStore'])->name('Store');

// Laporan
Route::get('lapInv', [App\Http\Controllers\LapInventoryController::class, 'mainlapInv'])->name('lapInv');

//global setting
Route::get('glob_setting', [App\Http\Controllers\GlobSettingController::class, 'mainSetting'])->name('glob_setting');

Route::get('lapLabaRugi', [App\Http\Controllers\LapLabaRugiController::class, 'mainPage'])->name('lapLabaRugi');

Route::get('generateData', [App\Http\Controllers\GlobSettingController::class, 'generateData'])->name('generateData');
Route::get('generateHarga', [App\Http\Controllers\GlobSettingController::class, 'generateHarga'])->name('generateHarga');
Route::get('piutangSupplier', [App\Http\Controllers\PurchasingController::class, 'piutangSupplier'])->name('piutangSupplier');

Route::get('log_system', [App\Http\Controllers\logSystemController::class, 'logSystem'])->name('log_system');

Route::get('trxJualBeli', [App\Http\Controllers\trxJualBeliController::class, 'mainTrx'])->name('trxJualBeli');
Route::get('trxKasUmum', [App\Http\Controllers\TrxKasUmumController::class, 'mainTrx'])->name('trxKasUmum');

Route::get('adminPiutangPelanggan', [App\Http\Controllers\LoanMaintenanceController::class, 'mainAdmin'])->name('adminPiutangPelanggan');
Route::get('adminPiutangPelanggan/modalEditLimit/{id}', [App\Http\Controllers\LoanMaintenanceController::class, 'modalEditLimit']);
Route::post('adminPiutangPelanggan/postLimitCustomer', [App\Http\Controllers\LoanMaintenanceController::class, 'postLimitCustomer']);

Route::get('kasKategori', [App\Http\Controllers\MasterDataKategoriKasController::class, 'mainCatgoryController'])->name('kasKategori');

Route::get('kasKecil', [App\Http\Controllers\TrxKasKecilController::class, 'kasKecil'])->name('kasKecil');
Route::get('kasBesar', [App\Http\Controllers\TrxKasBesarController::class, 'kasBesar'])->name('kasBesar');
Route::get('trxReumbers', [App\Http\Controllers\TrxReumbersController::class, 'trxReumbers'])->name('trxReumbers');

// Sales
Route::get('sales', [App\Http\Controllers\SalesController::class, 'main'])->name('sales');

// Set Lokasi 
Route::get('setLokasi', [App\Http\Controllers\setLokasiController::class, 'main'])->name('setLokasi');

//Z_Additional POS 
Route::get('Cashier/StockBarang', [App\Http\Controllers\TransactionController::class, 'StockBarang']);
Route::get('Cashier/AdditionalProductList', [App\Http\Controllers\ZAdditionalPosController::class, 'AdditionalProductList']);
Route::get('Cashier/AdditionalcariProduk/{keyword}/{trxNumber}', [App\Http\Controllers\ZAdditionalPosController::class, 'cariProduk']);
//Custome Aplication

include __DIR__.'/section/accounting.php';
include __DIR__.'/section/asset.php';
include __DIR__.'/section/cp_setup.php';
include __DIR__.'/section/hris.php';
include __DIR__.'/section/ms.php';
include __DIR__.'/section/pm.php';
include __DIR__.'/section/warehouse.php';
include __DIR__.'/section/stock.php';
include __DIR__.'/section/purchase.php';
include __DIR__.'/section/cashier.php';
include __DIR__.'/section/mou.php';
include __DIR__.'/section/supplier.php';
include __DIR__.'/section/customer.php';
include __DIR__.'/section/personalia.php';
include __DIR__.'/section/transaction.php';
include __DIR__.'/section/delivery.php';
// Inventory
include __DIR__.'/section/remaining.php';
include __DIR__.'/section/stockopname.php';
include __DIR__.'/section/koreksibarang.php';
include __DIR__.'/section/mutasi.php';
include __DIR__.'/section/store.php';
include __DIR__.'/section/ReturnItem.php';
include __DIR__.'/section/LapInventory.php';
include __DIR__.'/section/LapLabaRugi.php';

//setup apl
include __DIR__.'/section/globalsetting.php';

//transaksi edit jual beli
include __DIR__.'/section/trxJualBeli.php';

//transaksi edit jual beli
include __DIR__.'/section/trxKasUmum.php';

// Master Data Kategori Kas
include __DIR__.'/section/kasKategori.php';

include __DIR__.'/section/piutang.php';

include __DIR__.'/section/kasKecil.php';
include __DIR__.'/section/trxKasBesar.php';
include __DIR__.'/section/reumbers.php';

include __DIR__.'/section/sales.php';

include __DIR__.'/section/setLokasi.php';
?>