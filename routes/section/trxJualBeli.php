<?php
    Route::post('trxJualBeli/displayFiltering', [App\Http\Controllers\trxJualBeliController::class, 'displayfiltering']);
    Route::get('trxJualBeli/editPenjualan/{id}', [App\Http\Controllers\trxJualBeliController::class, 'editPenjualan']);
    Route::get('trxJualBeli/totalBelanja/{nomor}', [App\Http\Controllers\trxJualBeliController::class, 'totalBelanja']);
?>