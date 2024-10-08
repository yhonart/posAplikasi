<?php
Route::get('remainingStock/filNamaBarang/{fromBarang}/{endBarang}', [App\Http\Controllers\RemainingController::class, 'filNamaBarang']);
Route::post('remainingStock/filteringData', [App\Http\Controllers\RemainingController::class, 'filteringData']);
Route::get('remainingStock/searchByKeyword/{keyword}/{filOption}/{lokasi}', [App\Http\Controllers\RemainingController::class, 'searchByKeyword']);
Route::get('remainingStock/downloadData/{keyword}/{filOption}/{lokasi}', [App\Http\Controllers\RemainingController::class, 'downloadData']);
Route::post('remainingStock/generateStock', [App\Http\Controllers\RemainingController::class, 'generateStock']);
Route::get('remainingStock/detailInfoStock/{idmproduk}', [App\Http\Controllers\RemainingController::class, 'detailInfoStock']);
Route::post('remainingStock/postModalUpdateStock', [App\Http\Controllers\RemainingController::class, 'postModalUpdateStock']);