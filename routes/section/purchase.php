<?php
// PRN Route
Route::get('Purchasing/dataPurchasing', [App\Http\Controllers\PurchasingController::class, 'dataPurchasing']);

// Purchase Input Penerimaan Barang
Route::get('Purchasing/addPurchasing', [App\Http\Controllers\PurchasingController::class, 'addPurchasing']);
Route::post('Purchasing/addPurchasing/postPenerimaan', [App\Http\Controllers\PurchasingController::class, 'postPenerimaan']);
Route::get('Purchasing/tableInputBarang/formInput/{dokNumber}', [App\Http\Controllers\PurchasingController::class, 'tableInputBarang']);
Route::get('Purchasing/tableInputBarang/hargaSatuan/{satuanUnit}/{prdID}', [App\Http\Controllers\PurchasingController::class, 'hargaSatuan']);
Route::post('Purchasing/tableInputBarang/postBarang', [App\Http\Controllers\PurchasingController::class, 'postBarang']);
Route::get('Purchasing/tableInputBarang/loadBarang/{numberPO}', [App\Http\Controllers\PurchasingController::class, 'loadBarang']);
Route::get('Purchasing/tableInputBarang/tableSum/{numberPO}', [App\Http\Controllers\PurchasingController::class, 'tableSum']);
Route::post('Purchasing/tableInputBarang/postTableSum', [App\Http\Controllers\PurchasingController::class, 'postTableSum']);
Route::get('Purchasing/tableInputBarang/stockIden/{gudang}/{satuan}/{product}', [App\Http\Controllers\PurchasingController::class, 'stockIden']);

Route::get('Purchasing/purchOrder/InputDataPO', [App\Http\Controllers\PurchasingController::class, 'mainPurchaseOrder']);

//Table
Route::get('Purchasing/tablePenerimaan', [App\Http\Controllers\PurchasingController::class, 'tablePenerimaan']);
Route::get('Purchasing/modalPenerimaanPO/{poNumber}', [App\Http\Controllers\PurchasingController::class, 'modalPenerimaanPO']);
Route::get('Purchasing/modalSupplier/{supplierID}', [App\Http\Controllers\PurchasingController::class, 'modalSupplier']);

//Edit Table
Route::get('Purchasing/tablePenerimaan/editTable/{dataEdit}', [App\Http\Controllers\PurchasingController::class, 'editTablePO']);
Route::get('Purchasing/tablePenerimaan/btnApprove/{dataEdit}', [App\Http\Controllers\PurchasingController::class, 'btnApprove']);

// Dashboar 
Route::get('Purchasing/dashboard', [App\Http\Controllers\PurchasingController::class, 'mainDashboard']);

// filter by card
Route::get('Purchasing/Bayar', [App\Http\Controllers\PurchasingController::class, 'Bayar']);
Route::post('Purchasing/Bayar/payPost', [App\Http\Controllers\PurchasingController::class, 'payPost']);
Route::get('Purchasing/Bayar/modalMethod/{nomor}', [App\Http\Controllers\PurchasingController::class, 'modalMethod']);
Route::post('Purchasing/Bayar/postModalPembayaran', [App\Http\Controllers\PurchasingController::class, 'postModalPembayaran']);

Route::post('Purchasing/tablePenerimaan/updateOnChange', [App\Http\Controllers\PurchasingController::class, 'updateOnChange']);
Route::get('Purchasing/tablePenerimaan/deleteItem/{delId}', [App\Http\Controllers\PurchasingController::class, 'deleteItem']);

Route::get('Purchasing/DueDate', [App\Http\Controllers\PurchasingController::class, 'DueDate']);
Route::get('Purchasing/lastPayment', [App\Http\Controllers\PurchasingController::class, 'lastPayment']);
Route::get('Purchasing/Payed', [App\Http\Controllers\PurchasingController::class, 'Payed']);
Route::get('Purchasing/cencelInput/{idNo}', [App\Http\Controllers\PurchasingController::class, 'cencelInput']);

Route::get('Purchasing/getAutoPrice/{prdId}', [App\Http\Controllers\PurchasingController::class, 'getAutoPrice']);
Route::get('Purchasing/notivePoint/{suppID}', [App\Http\Controllers\PurchasingController::class, 'notivePoint']);