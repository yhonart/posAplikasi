<?php
// PRN Route
Route::get('Purchasing/purchRequest', [App\Http\Controllers\PurchasingController::class, 'mainPurchaseReq']);

// Purchase Input
Route::get('Purchasing/purchOrder', [App\Http\Controllers\PurchasingController::class, 'mainPurchaseOrder']);
Route::get('Purchasing//purchOrder/InputDataPO', [App\Http\Controllers\PurchasingController::class, 'mainPurchaseOrder']);

// Dashboar 
Route::get('Purchasing/dashboard', [App\Http\Controllers\PurchasingController::class, 'mainDashboard']);