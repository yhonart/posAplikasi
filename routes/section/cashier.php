<?php
Route::get('Cashier/productList', [App\Http\Controllers\CashierController::class, 'productList']);
// Select Condition With Product Selected
Route::get('Cashier/productList/satuan/{prdID}', [App\Http\Controllers\CashierController::class, 'inputSatuan']);
Route::get('Cashier/productList/hargaSatuan/{idSatuan}/{prdID}', [App\Http\Controllers\CashierController::class, 'hargaSatuan']);
Route::get('Cashier/productList/prdResponse/{prdID}', [App\Http\Controllers\CashierController::class, 'prdResponse']);
Route::get('Cashier/productList/listTableTransaksi', [App\Http\Controllers\CashierController::class, 'listTableTransaksi']);
Route::get('Cashier/productList/listTableInputPrd', [App\Http\Controllers\CashierController::class, 'listTableInputPrd']);
Route::get('Cashier/productList/stockBarang/{idSatuan}/{prdID}', [App\Http\Controllers\CashierController::class, 'stoockBarang']);
Route::post('Cashier/productList/postProduct', [App\Http\Controllers\CashierController::class, 'postProductList']);

//Button rule
Route::get('Cashier/buttonAction', [App\Http\Controllers\CashierController::class, 'buttonAction']);
Route::get('Cashier/buttonAction/loadHelp', [App\Http\Controllers\CashierController::class, 'loadHelp']);
Route::post('Cashier/buttonAction/postVariableData', [App\Http\Controllers\CashierController::class, 'postNoBilling']);
Route::post('Cashier/buttonAction/postUpdateCustomer', [App\Http\Controllers\CashierController::class, 'postUpdateCustomer']);
Route::get('Cashier/buttonAction/manualSelectProduct', [App\Http\Controllers\CashierController::class, 'manualSelectProduct']);
Route::get('Cashier/buttonAction/manualSelectProduct/postProductSale', [App\Http\Controllers\CashierController::class, 'postProductSale']);
Route::get('Cashier/buttonAction/manualSelectProduct/select/{nmProduk}', [App\Http\Controllers\CashierController::class, 'selectProduk']);
Route::get('Cashier/buttonAction/updateToSave/{noBilling}', [App\Http\Controllers\CashierController::class, 'updateToSave']);
Route::post('Cashier/buttonAction/updateToPayment', [App\Http\Controllers\CashierController::class, 'updateToPayment']);
Route::get('Cashier/buttonAction/dataPenjualan', [App\Http\Controllers\CashierController::class, 'modalDataPenjualan']);
Route::post('Cashier/buttonAction/dataPenjualan/postDataClosing', [App\Http\Controllers\CashierController::class, 'postDataClosing']);
Route::get('Cashier/buttonAction/dataPenjualan/funcData/{fromdate}/{enddate}/{keyword}/{method}', [App\Http\Controllers\CashierController::class, 'funcDataPenjualan']);
Route::get('Cashier/buttonAction/dataPenjualan/tampilData/{dateData}', [App\Http\Controllers\CashierController::class, 'tampilDataSimpan']);
Route::get('Cashier/buttonAction/dataPenjualan/selectData/{billingIden}/{trxType}', [App\Http\Controllers\CashierController::class, 'billingIden']);
Route::get('Cashier/buttonAction/dataPenjualan/deleteData/{data}', [App\Http\Controllers\CashierController::class, 'deleteData']);
Route::get('Cashier/buttonAction/dataStock', [App\Http\Controllers\CashierController::class, 'modalDataStock']);
Route::get('Cashier/buttonAction/dataStock/funcData/{point}/{keyword}', [App\Http\Controllers\CashierController::class, 'funcDataStock']);
Route::get('Cashier/buttonAction/dataPelunasan', [App\Http\Controllers\CashierController::class, 'modalDataPelunasan']);
Route::get('Cashier/buttonAction/modalPembayaran/{noBill}/{tBayar}/{tBill}', [App\Http\Controllers\CashierController::class, 'modalPembayaran']);
Route::post('Cashier/buttonAction/postDataPembayaran', [App\Http\Controllers\CashierController::class, 'postDataPembayaran']);
Route::post('Cashier/buttonAction/postDataMethodPembayaran', [App\Http\Controllers\CashierController::class, 'postDataMethodPembayaran']);
Route::get('Cashier/buttonAction/loadDataMethod/{noBill}', [App\Http\Controllers\CashierController::class, 'loadDataMethod']);


Route::get('Cashier/buttonAction/printTemplateCashier/{noBill}/{typeCetak}', [App\Http\Controllers\CashierController::class, 'printTemplateCashier']);
Route::get('Cashier/buttonAction/dataPelunasan/funcData/{keyword}/{fromDate}/{endDate}', [App\Http\Controllers\CashierController::class, 'funcDataPelunasan']);
Route::get('Cashier/buttonAction/dataPelunasan/listDataPinjaman', [App\Http\Controllers\CashierController::class, 'listDataPinjaman']);
Route::post('Cashier/buttonAction/dataPelunasan/actionData', [App\Http\Controllers\CashierController::class, 'actionDataPinjaman']);
Route::post('Cashier/buttonAction/dataPelunasan/postPelunasan', [App\Http\Controllers\CashierController::class, 'postPelunasan']);
Route::get('Cashier/dataPelunasan/printPelunasan/{voucher}', [App\Http\Controllers\CashierController::class, 'printPelunasan']);

//RETURN
Route::get('Cashier/buttonAction/dataReturn', [App\Http\Controllers\CashierController::class, 'modalDataReturn']);
Route::get('Cashier/buttonAction/dataReturn/searchDataReturn/{keyword}/{fromDate}/{endDate}', [App\Http\Controllers\CashierController::class, 'searchDataReturn']);
Route::get('Cashier/buttonAction/dataReturn/clickListProduk/{dataTrx}/{trxType}', [App\Http\Controllers\CashierController::class, 'clickListProduk']);
Route::get('Cashier/buttonAction/dataReturn/clickRetur/{idBrgRet}', [App\Http\Controllers\CashierController::class, 'clickRetur']);
Route::get('Cashier/buttonAction/dataReturn/sumDataInfo/{trxCode}', [App\Http\Controllers\CashierController::class, 'sumDataInfo']);
Route::get('Cashier/buttonAction/dataReturn/updateDataBelanja', [App\Http\Controllers\CashierController::class, 'updateDataBelanja']);

Route::get('Cashier/productList/searchProduct/by/{keyword}', [App\Http\Controllers\CashierController::class, 'searchProdByKeyword']);
Route::post('Cashier/buttonAction/dataPenjualan/postEditItem', [App\Http\Controllers\CashierController::class, 'postEditItem']);
Route::post('Cashier/buttonAction/dataPenjualan/postEditItemUnit', [App\Http\Controllers\CashierController::class, 'postEditItemUnit']);
Route::get('Cashier/buttonAction/deleteAllTrx/{noBill}', [App\Http\Controllers\CashierController::class, 'deleteAllTrx']);
Route::get('Cashier/buttonAction/loadDataSaved', [App\Http\Controllers\CashierController::class, 'loadDataSaved']);
Route::get('Cashier/buttonAction/deleteHoldData/{noBill}', [App\Http\Controllers\CashierController::class, 'deleteHoldData']);

//PDF
Route::get('Cashier/buttonAction/trxReportDetailPdf/{fromDate}/{endDate}', [App\Http\Controllers\CashierController::class, 'cashierReportDetailPdf']);
Route::get('Cashier/buttonAction/trxReportRecapPdf/{fromDate}/{endDate}', [App\Http\Controllers\CashierController::class, 'cashierReportRecapPdf']);
Route::get('Cashier/buttonAction/trxReportRecapExcel/{fromDate}/{endDate}', [App\Http\Controllers\CashierController::class, 'trxReportRecapExcel']);
Route::get('Cashier/buttonAction/trxReportClosing/{fromDate}/{endDate}', [App\Http\Controllers\CashierController::class, 'trxReportClosing']);

//Button
Route::get('Cashier/buttonAction/updateTotalBeanja/{trxCode}', [App\Http\Controllers\CashierController::class, 'updateTotalBelanja']);
Route::get('Cashier/buttonAction/modalDelete/{idTrx}', [App\Http\Controllers\CashierController::class, 'modalDelete']);
Route::post('Cashier/buttonAction/postDaleteData', [App\Http\Controllers\CashierController::class, 'postDaleteData']);

//Unlock
Route::post('Cashier/buttonAction/unlockReturn', [App\Http\Controllers\CashierController::class, 'unlockReturn']);
Route::post('Cashier/buttonAction/unlock', [App\Http\Controllers\CashierController::class, 'unlockBarang']);




