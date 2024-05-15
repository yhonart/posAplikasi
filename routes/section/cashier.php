<?php
Route::get('Cashier/productList', [App\Http\Controllers\CashierController::class, 'productList']);
// Select Condition With Product Selected
Route::get('Cashier/productList/satuan/{prdID}', [App\Http\Controllers\CashierController::class, 'inputSatuan']);
Route::get('Cashier/productList/hargaSatuan/{idSatuan}/{prdID}', [App\Http\Controllers\CashierController::class, 'hargaSatuan']);
Route::get('Cashier/productList/listTableTransaksi', [App\Http\Controllers\CashierController::class, 'listTableTransaksi']);
Route::get('Cashier/productList/stockBarang/{idSatuan}/{prdID}', [App\Http\Controllers\CashierController::class, 'stoockBarang']);
Route::post('Cashier/productList/postProduct', [App\Http\Controllers\CashierController::class, 'postProductList']);

//Button rule
Route::get('Cashier/buttonAction', [App\Http\Controllers\CashierController::class, 'buttonAction']);
Route::get('Cashier/buttonAction/loadHelp', [App\Http\Controllers\CashierController::class, 'loadHelp']);
Route::post('Cashier/buttonAction/postVariableData', [App\Http\Controllers\CashierController::class, 'postNoBilling']);
Route::get('Cashier/buttonAction/manualSelectProduct', [App\Http\Controllers\CashierController::class, 'manualSelectProduct']);
Route::get('Cashier/buttonAction/manualSelectProduct/postProductSale', [App\Http\Controllers\CashierController::class, 'postProductSale']);
Route::get('Cashier/buttonAction/manualSelectProduct/select/{nmProduk}', [App\Http\Controllers\CashierController::class, 'selectProduk']);
Route::get('Cashier/buttonAction/updateToSave/{noBilling}', [App\Http\Controllers\CashierController::class, 'updateToSave']);
Route::post('Cashier/buttonAction/updateToPayment', [App\Http\Controllers\CashierController::class, 'updateToPayment']);
Route::get('Cashier/buttonAction/dataPenjualan', [App\Http\Controllers\CashierController::class, 'modalDataPenjualan']);
Route::get('Cashier/buttonAction/dataPenjualan/funcData/{dateIden}', [App\Http\Controllers\CashierController::class, 'funcDataPenjualan']);
Route::get('Cashier/buttonAction/dataPenjualan/selectData/{billingIden}', [App\Http\Controllers\CashierController::class, 'billingIden']);
Route::get('Cashier/buttonAction/dataPenjualan/deleteData/{data}', [App\Http\Controllers\CashierController::class, 'deleteData']);
Route::get('Cashier/buttonAction/dataStock', [App\Http\Controllers\CashierController::class, 'modalDataStock']);
Route::get('Cashier/buttonAction/dataStock/funcData/{point}/{keyword}', [App\Http\Controllers\CashierController::class, 'funcDataStock']);
Route::get('Cashier/buttonAction/dataPelunasan', [App\Http\Controllers\CashierController::class, 'modalDataPelunasan']);
Route::get('Cashier/buttonAction/dataPelunasan/funcData/{keyword}/{infoCode}', [App\Http\Controllers\CashierController::class, 'funcDataPelunasan']);
Route::post('Cashier/buttonAction/dataPelunasan/actionData', [App\Http\Controllers\CashierController::class, 'actionDataPinjaman']);
Route::get('Cashier/buttonAction/dataReturn', [App\Http\Controllers\CashierController::class, 'modalDataReturn']);