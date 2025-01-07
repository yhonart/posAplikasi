<?php
use Illuminate\Support\Facades\Route;
Route::get('TransProduct/StockBarang', [App\Http\Controllers\TransactionController::class, 'StockBarang']);
Route::get('TransProduct/StockBarang/cariTransaksiProduk/{keyword}', [App\Http\Controllers\TransactionController::class, 'SearchProduct']);   
?>