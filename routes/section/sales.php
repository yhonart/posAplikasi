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
    Route::post('sales/mainProduct/newProduct/postNewProduct', [App\Http\Controllers\SalesAdminController::class, 'postNewProduct']);
    Route::get('sales/mainProduct/newProduct/newPrice/{id}', [App\Http\Controllers\SalesAdminController::class, 'newPrice']);
    Route::get('sales/mainProduct/newProduct/modalNewVarian/{id}', [App\Http\Controllers\SalesAdminController::class, 'modalNewVarian']);
    Route::get('sales/mainProduct/newProduct/modalNewVarianFixed/{id}', [App\Http\Controllers\SalesAdminController::class, 'modalNewVarianFixed']);
    Route::get('sales/mainProduct/newProduct/tableVarianPrice/{id}', [App\Http\Controllers\SalesAdminController::class, 'tableVarianPrice']);
    Route::post('sales/mainProduct/newProduct/postNewVarian', [App\Http\Controllers\SalesAdminController::class, 'postNewVarian']);
    Route::post('sales/mainProduct/newProduct/postNewVarianFixed', [App\Http\Controllers\SalesAdminController::class, 'postNewVarianFixed']);
    
    Route::get('sales/mainProduct/detailProduct/{dataID}', [App\Http\Controllers\SalesAdminController::class, 'detailProduct']);

    Route::get('sales/mainCustomer', [App\Http\Controllers\SalesAdminController::class, 'mainCustomer']);
    Route::get('sales/mainSalesOrder', [App\Http\Controllers\SalesAdminController::class, 'mainSalesOrder']);
    Route::get('sales/mainDeliveryReport', [App\Http\Controllers\SalesAdminController::class, 'mainDeliveryReport']);
    
    Route::get('sales/mainUser', [App\Http\Controllers\SalesAdminController::class, 'mainUser']);
    Route::get('sales/mainCategory', [App\Http\Controllers\SalesAdminController::class, 'mainCategory']);
    Route::get('sales/mainCategory/newCategory', [App\Http\Controllers\SalesAdminController::class, 'newCategory']);
    Route::get('sales/mainCategory/dataTableCategory', [App\Http\Controllers\SalesAdminController::class, 'dataTableCategory']);
    
    Route::get('sales/mainStock', [App\Http\Controllers\SalesAdminController::class, 'mainStock']);
    Route::get('sales/mainStock/dataResultInv/{prdVal}/{catVal}', [App\Http\Controllers\SalesAdminController::class, 'dataResultInv']);
    
    Route::get('sales/mainStockOpname', [App\Http\Controllers\SalesAdminController::class, 'mainStockOpname']);
    Route::get('sales/displayStockOpname', [App\Http\Controllers\SalesAdminController::class, 'displayStockOpname']);
    Route::post('sales/displayStockOpname/postDokumen', [App\Http\Controllers\SalesAdminController::class, 'postDokumen']);

    
?>