<?php

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
Route::get('/', function () {
    if (Auth::check()) {
        $hakakses = Auth::user()->hakakses;
        $checkArea = Auth::user()->count_area;
        if($hakakses == '1'){
            return view('Dashboard/DashboardTransaksi');
        }
        elseif($hakakses == '2' OR $hakakses == '3'){
            return view('Cashier/maintenancePage', compact('checkArea'));
        }
    }
    else{
        return view('auth.login');
    }
});
Route::get('/forgot-password', function () {
    return view('auth.passwords.reset');
})->middleware('guest')->name('password.request');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/storeName', [App\Http\Controllers\HomeController::class, 'storeName']);
Route::get('/home/getMenu', [App\Http\Controllers\HomeController::class, 'getMenu']);
Route::get('home/mainMenu', [App\Http\Controllers\HomeController::class, 'mainMenu']);
Route::get('home/GetGlobaDelete/WithDeleteId/{dataId}/{dataTb}/{dataCol}', [App\Http\Controllers\HomeController::class, 'GlobalDelete']);
Route::post('home/GlobalLiveEditTable', [App\Http\Controllers\HomeController::class, 'GlobalEditTable']);

Route::get('Stock', [App\Http\Controllers\StockListController::class, 'getMenu'])->name('Stock');
Route::get('MoU', [App\Http\Controllers\MoUController::class, 'mainIndex'])->name('MoU');
Route::get('Supplier', [App\Http\Controllers\SuplayerController::class, 'mainIndex'])->name('Supplier');
Route::get('Customers', [App\Http\Controllers\CustomersController::class, 'mainIndex'])->name('Customers');
Route::get('Personalia', [App\Http\Controllers\PersonaliaController::class, 'mainIndex'])->name('Personalia');
Route::get('TransProduct', [App\Http\Controllers\TransactionController::class, 'mainTransaction'])->name('TransProduct');
Route::get('Cashier', [App\Http\Controllers\CashierController::class, 'mainCashier'])->name('Cashier');
Route::get('Delivery', [App\Http\Controllers\DeliveryController::class, 'mainDelivery'])->name('Delivery');
Route::post('Dashboard/loadDataTransaksi/postOnClick', [App\Http\Controllers\DashboardController::class, 'onClickDetail']);

Route::get('UnderMaintenance', [App\Http\Controllers\HomeController::class, 'UnderMaintenance'])->name('UnderMaintenance');

//Purchasing
Route::get('Purchasing', [App\Http\Controllers\PurchasingController::class, 'mainPurch'])->name('Purchasing');
Route::get('returnItem', [App\Http\Controllers\ReturnItemController::class, 'mainReturn'])->name('returnItem');

// Dashboard
Route::get('Dashboard', [App\Http\Controllers\DashboardController::class, 'mainDashboard'])->name('Dashboard');
Route::get('Dashboard/loadDataTransaksi/{fromDate}/{endDate}', [App\Http\Controllers\DashboardController::class, 'lodaDataTransaksi']);

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

//setup apl
include __DIR__.'/section/globalsetting.php';

