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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/getMenu', [App\Http\Controllers\HomeController::class, 'getMenu']);
Route::get('Stock', [App\Http\Controllers\StockListController::class, 'getMenu'])->name('Stock');
Route::get('MoU', [App\Http\Controllers\MoUController::class, 'mainIndex'])->name('MoU');
Route::get('Supplier', [App\Http\Controllers\SuplayerController::class, 'mainIndex'])->name('Supplier');
Route::get('Customers', [App\Http\Controllers\CustomersController::class, 'mainIndex'])->name('Customers');
Route::get('Personalia', [App\Http\Controllers\PersonaliaController::class, 'mainIndex'])->name('Personalia');
Route::get('TransProduct', [App\Http\Controllers\TransactionController::class, 'mainTransaction'])->name('TransProduct');
Route::get('Cashier', [App\Http\Controllers\CashierController::class, 'mainCashier'])->name('Cashier');
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
