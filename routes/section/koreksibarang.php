<?php
Route::post('koreksiBarang/submitFormKoreksi', [App\Http\Controllers\CorrectPrdController::class, 'submitFormKoreksi']);
Route::get('koreksiBarang/listInputBarang', [App\Http\Controllers\CorrectPrdController::class, 'listInputBarang']);
Route::post('koreksiBarang/listInputBarang/submitBarang', [App\Http\Controllers\CorrectPrdController::class, 'submitBarang']);

Route::get('koreksiBarang/listInputBarang/satuan/{productID}', [App\Http\Controllers\CorrectPrdController::class, 'satuan']);
Route::get('koreksiBarang/listInputBarang/lastQty/{satuan}/{productID}/{locationID}', [App\Http\Controllers\CorrectPrdController::class, 'lastQty']);
Route::post('koreksiBarang/listInputBarang/submitKoreksi', [App\Http\Controllers\CorrectPrdController::class, 'submitKoreksi']);
Route::get('koreksiBarang/listInputBarang/listBarang/{noOpname}', [App\Http\Controllers\CorrectPrdController::class, 'listBarang']);
Route::post('koreksiBarang/listInputBarang/submitLapKoreksi', [App\Http\Controllers\CorrectPrdController::class, 'submitLapKoreksi']);

Route::post('koreksiBarang/submitUpdateStockOpname', [App\Http\Controllers\CorrectPrdController::class, 'submitUpdateStockOpname']);

Route::get('koreksiBarang/listDataKoreksi', [App\Http\Controllers\CorrectPrdController::class, 'listDataKoreksi']);
Route::get('koreksiBarang/listDataKoreksi/approvalKoreksi/{number}', [App\Http\Controllers\CorrectPrdController::class, 'approvalKoreksi']);
Route::get('koreksiBarang/listDataKoreksi/detailKoreksi/{number}', [App\Http\Controllers\CorrectPrdController::class, 'detailKoreksi']);
Route::get('koreksiBarang/listDataKoreksi/deleteKoreksi/{number}', [App\Http\Controllers\CorrectPrdController::class, 'deleteKoreksi']);
Route::get('koreksiBarang/deleteItem/{number}', [App\Http\Controllers\CorrectPrdController::class, 'deleteItem']);

Route::get('koreksiBarang/filterByDate/{fromDate}/{endDate}', [App\Http\Controllers\CorrectPrdController::class, 'filterByDate']);

?>