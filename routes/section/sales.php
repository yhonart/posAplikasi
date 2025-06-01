<?php
use Illuminate\Support\Facades\Route;
    Route::get('sales/daftarKunjungan', [App\Http\Controllers\SalesController::class, 'daftarKunjungan']);
    Route::get('sales/formKunjungan', [App\Http\Controllers\SalesController::class, 'formKunjungan']);
    Route::post('sales/formKunjungan/postNewTransaksi', [App\Http\Controllers\SalesController::class, 'postNewTransaksi']);
    Route::get('sales/salesDasboard', [App\Http\Controllers\SalesController::class, 'salesDasboard']);
?>