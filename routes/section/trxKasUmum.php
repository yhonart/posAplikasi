<?php
    Route::get('trxKasUmum/tambahBiaya', [App\Http\Controllers\TrxKasUmumController::class, 'tambahBiaya']);
    Route::get('trxKasUmum/selectKategori/{kategori}', [App\Http\Controllers\TrxKasUmumController::class, 'selectKategori']);
    Route::post('trxKasUmum/postTrxPembiayaan', [App\Http\Controllers\TrxKasUmumController::class, 'postTrxPembiayaan']);
?>