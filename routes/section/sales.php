<?php
use Illuminate\Support\Facades\Route;
    Route::get('sales/daftarKunjungan', [App\Http\Controllers\SalesController::class, 'daftarKunjungan']);
    Route::get('sales/detailCustomer/{id}', [App\Http\Controllers\SalesController::class, 'detailCustomer']);
    Route::get('sales/formKunjungan', [App\Http\Controllers\SalesController::class, 'formKunjungan']);
    Route::post('sales/formKunjungan/postNewTransaksi', [App\Http\Controllers\SalesController::class, 'postNewTransaksi']);
    Route::get('sales/salesDasboard', [App\Http\Controllers\SalesController::class, 'salesDasboard']);
    
    // Admin 
    Route::get('sales/mainDashboard', [App\Http\Controllers\SalesAdminController::class, 'mainDashboard']);

    // Admin Master Produk
    Route::get('sales/mainProduct', [App\Http\Controllers\SalesAdminController::class, 'mainProduct']);
    Route::get('sales/mainProduct/newProduct', [App\Http\Controllers\SalesAdminController::class, 'newProduct']);

    Route::get('sales/mainCustomer', [App\Http\Controllers\SalesAdminController::class, 'mainCustomer']);
    Route::get('sales/mainSalesOrder', [App\Http\Controllers\SalesAdminController::class, 'mainSalesOrder']);
    Route::get('sales/mainDeliveryReport', [App\Http\Controllers\SalesAdminController::class, 'mainDeliveryReport']);
    
    Route::get('sales/mainUser', [App\Http\Controllers\SalesAdminController::class, 'mainUser']);
    Route::get('sales/mainCategory', [App\Http\Controllers\SalesAdminController::class, 'mainCategory']);
    Route::get('sales/mainCategory/newCategory', [App\Http\Controllers\SalesAdminController::class, 'newCategory']);
    Route::get('sales/mainCategory/dataTableCategory', [App\Http\Controllers\SalesAdminController::class, 'dataTableCategory']);
?>