<?php
Route::post('stockOpname/submitStockOpname', [App\Http\Controllers\StockopnameController::class, 'submitStockOpname']);

Route::get('stockOpname/listDataOpname', [App\Http\Controllers\StockopnameController::class, 'listDataOpname']);
Route::get('stockOpname/listDataOpname/approvalOpname/{idOpname}', [App\Http\Controllers\StockopnameController::class, 'approvalOpname']);
Route::get('stockOpname/listDataOpname/deleteDataOpname/{idOpname}', [App\Http\Controllers\StockopnameController::class, 'deleteDataOpname']);
Route::get('stockOpname/listDataOpname/detailOpname/{idOpname}', [App\Http\Controllers\StockopnameController::class, 'detailOpname']);
Route::get('stockOpname/listDataOpname/editOpname/{idOpname}', [App\Http\Controllers\StockopnameController::class, 'editOpname']);

Route::get('stockOpname/disInputBarang', [App\Http\Controllers\StockopnameController::class, 'disInputBarang']);

Route::get('stockOpname/listInputBarang', [App\Http\Controllers\StockopnameController::class, 'listInputBarang']);
Route::post('stockOpname/listInputBarang/submitBarang', [App\Http\Controllers\StockopnameController::class, 'submitBarang']);
Route::get('stockOpname/listInputBarang/satuan/{productID}', [App\Http\Controllers\StockopnameController::class, 'satuan']);
Route::get('stockOpname/listInputBarang/lastQty/{satuan}/{productID}/{location}', [App\Http\Controllers\StockopnameController::class, 'lastQty']);
Route::post('stockOpname/listInputBarang/submitOpname', [App\Http\Controllers\StockopnameController::class, 'submitOpname']);
Route::get('stockOpname/listInputBarang/listBarang/{noOpname}/{codeDisplay}', [App\Http\Controllers\StockopnameController::class, 'listBarang']);
Route::post('stockOpname/listInputBarang/submitOpnameReport', [App\Http\Controllers\StockopnameController::class, 'submitOpnameReport']);
Route::post('stockOpname/listInputBarang/modalEditBarang/{idlist}', [App\Http\Controllers\StockopnameController::class, 'modalEditBarang']);
Route::get('stockOpname/listInputBarang/deleteBarang/{idlist}', [App\Http\Controllers\StockopnameController::class, 'deleteBarang']);
Route::get('stockOpname/listInputBarang/editDocumentOpname/{idParam}', [App\Http\Controllers\StockopnameController::class, 'editDocumentOpname']);

Route::post('stockOpname/saveToEditTable', [App\Http\Controllers\StockopnameController::class, 'saveToEditTable']);

Route::post('stockOpname/submitUpdateStockOpname', [App\Http\Controllers\StockopnameController::class, 'submitUpdateStockOpname']);

Route::get('stockOpname/listTableOpname/{fromDate}/{endDate}', [App\Http\Controllers\StockopnameController::class, 'listTableOpname']);