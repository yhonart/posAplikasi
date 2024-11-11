<?php
Route::get('mutasi/tableDataMutasi', [App\Http\Controllers\MutasibarangController::class, 'tableDataMutasi']);
Route::get('mutasi/tableDataMutasi/detailMutasi/{idParam}', [App\Http\Controllers\MutasibarangController::class, 'detailMutasi']);
Route::get('mutasi/tableDataMutasi/deleteMutasi/{idParam}', [App\Http\Controllers\MutasibarangController::class, 'deleteMutasi']);
Route::get('mutasi/tableDataMutasi/editMutasi/{idParam}', [App\Http\Controllers\MutasibarangController::class, 'editMutasi']);
Route::get('mutasi/tableDataMutasi/delivery/{idParam}', [App\Http\Controllers\MutasibarangController::class, 'delivery']);
Route::get('mutasi/tableDataMutasi/pickup/{idParam}', [App\Http\Controllers\MutasibarangController::class, 'pickup']);

Route::get('mutasi/formEntryMutasi', [App\Http\Controllers\MutasibarangController::class, 'formEntryMutasi']);
Route::post('mutasi/formEntryMutasi/submitMutasi', [App\Http\Controllers\MutasibarangController::class, 'submitMutasi']);
Route::get('mutasi/formEntryMutasi/getTableInputProduct', [App\Http\Controllers\MutasibarangController::class, 'getTableInputProduct']);
Route::post('mutasi/formEntryMutasi/submitDataBarang', [App\Http\Controllers\MutasibarangController::class, 'submitDataBarang']);
Route::get('mutasi/formEntryMutasi/entryStock/{satuanVal}/{productVal}/{warehouse}', [App\Http\Controllers\MutasibarangController::class, 'entryStock']);
Route::get('mutasi/formEntryMutasi/listBarang/{mutasiCode}', [App\Http\Controllers\MutasibarangController::class, 'listBarang']);
Route::post('mutasi/formEntryMutasi/submitTotalMutasi', [App\Http\Controllers\MutasibarangController::class, 'submitTotalMutasi']);
Route::post('mutasi/formEntryMutasi/submitUpdateMutasi', [App\Http\Controllers\MutasibarangController::class, 'submitUpdateMutasi']);
Route::get('mutasi/formEntryMutasi/editDocMutasi/{idparam}', [App\Http\Controllers\MutasibarangController::class, 'editDocMutasi']);

Route::get('mutasi/listTableItem/deleteData/{idparam}', [App\Http\Controllers\MutasibarangController::class, 'deleteData']);
Route::post('mutasi/listTableItem/editTable', [App\Http\Controllers\MutasibarangController::class, 'editTable']);

Route::get('mutasi/listSatuan/satuan/{idmProduct}', [App\Http\Controllers\MutasibarangController::class, 'satuan']);
Route::get('mutasi/manualBook', function () {
    return view('Mutasi/manualBook');
});
Route::get('mutasi/tableDokMutasi/{fromDate}/{endDate}/{status}', [App\Http\Controllers\MutasibarangController::class, 'tableDokMutasi']);


