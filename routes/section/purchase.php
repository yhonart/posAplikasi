<?php
// PRN Route
Route::get('Purchasing/dataPurchasing', [App\Http\Controllers\PurchasingController::class, 'dataPurchasing']);
Route::get('Purchasing/metodePembayaran/{supplier}', [App\Http\Controllers\PurchasingController::class, 'metodePembayaran']);

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
Route::get('Purchasing/collapseDokumen/{dokPurchase}', [App\Http\Controllers\PurchasingController::class, 'collapseDokumen']);

//Table
Route::get('Purchasing/tablePenerimaan/{status}/{fromDate}/{endDate}', [App\Http\Controllers\PurchasingController::class, 'tablePenerimaan']);
Route::get('Purchasing/modalPenerimaanPO/{poNumber}', [App\Http\Controllers\PurchasingController::class, 'modalPenerimaanPO']);
Route::get('Purchasing/modalSupplier/{supplierID}', [App\Http\Controllers\PurchasingController::class, 'modalSupplier']);

//Edit Table
Route::get('Purchasing/tablePenerimaan/editTable/{dataEdit}', [App\Http\Controllers\PurchasingController::class, 'editTablePO']);
Route::get('Purchasing/tablePenerimaan/btnApprove/{dataEdit}', [App\Http\Controllers\PurchasingController::class, 'btnApprove']);
Route::get('Purchasing/tablePenerimaan/btnDelete/{dataEdit}', [App\Http\Controllers\PurchasingController::class, 'btnDelete']);
Route::post('Purchasing/editPurchasing/postEditDocPenerimaan', [App\Http\Controllers\PurchasingController::class, 'postEditDocPenerimaan']);

// Dashboar 
Route::get('Purchasing/dashboardPembayaran', [App\Http\Controllers\PurchasingController::class, 'mainDashboard']);

// filter by card
Route::get('Purchasing/inputPembayaran', [App\Http\Controllers\PurchasingController::class, 'inputPembayaran']);
Route::get('Purchasing/Bayar/{supplier}/{fromDate}/{endDate}', [App\Http\Controllers\PurchasingController::class, 'Bayar']);
Route::post('Purchasing/Bayar/payPost', [App\Http\Controllers\PurchasingController::class, 'payPost']);
Route::get('Purchasing/Bayar/modalMethod/{nomor}', [App\Http\Controllers\PurchasingController::class, 'modalMethod']);
Route::post('Purchasing/Bayar/postModalPembayaran', [App\Http\Controllers\PurchasingController::class, 'postModalPembayaran']);
Route::get('Purchasing/Bayar/modalDetailKredit/{nomor}', [App\Http\Controllers\PurchasingController::class, 'modalDetailKredit']);
Route::post('Purchasing/Bayar/postSumberDana', [App\Http\Controllers\PurchasingController::class, 'postSumberDana']);
Route::get('Purchasing/Bayar/getDisplaySumberDana/{kasir}/{apNumber}/{purchaseNumber}', [App\Http\Controllers\PurchasingController::class, 'getDisplaySumberDana']);

Route::post('Purchasing/tablePenerimaan/updateOnChange', [App\Http\Controllers\PurchasingController::class, 'updateOnChange']);
Route::get('Purchasing/tablePenerimaan/deleteItem/{delId}', [App\Http\Controllers\PurchasingController::class, 'deleteItem']);

Route::get('Purchasing/DueDate', [App\Http\Controllers\PurchasingController::class, 'DueDate']);
Route::get('Purchasing/lastPayment', [App\Http\Controllers\PurchasingController::class, 'lastPayment']);
Route::get('Purchasing/Payed', [App\Http\Controllers\PurchasingController::class, 'Payed']);
Route::get('Purchasing/cencelInput/{idNo}', [App\Http\Controllers\PurchasingController::class, 'cencelInput']);

Route::get('Purchasing/getAutoPrice/{prdId}', [App\Http\Controllers\PurchasingController::class, 'getAutoPrice']);
Route::get('Purchasing/notivePoint/{suppID}', [App\Http\Controllers\PurchasingController::class, 'notivePoint']);
Route::get('Purchasing/displayItemReturn/{suppID}', [App\Http\Controllers\PurchasingController::class, 'displayItemReturn']);

Route::get('piutangSupplier/pembayaran', [App\Http\Controllers\PurchasingController::class, 'pembayaran']);

Route::get('Purchasing/historyPembayaran', [App\Http\Controllers\PurchasingController::class, 'historyPembayaran']);
Route::get('Purchasing/historyPembayaran/filtering/{supplier}/{fromDate}/{endDate}/{status}', [App\Http\Controllers\PurchasingController::class, 'filteringHistory']);

Route::get('Purchasing/modalDetailKreditPembayaran/{id}/{noDok}', [App\Http\Controllers\PurchasingController::class, 'modalDetailKreditPembayaran']);
