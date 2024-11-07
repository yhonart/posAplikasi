<?php
    Route::get('trxKasUmum/tambahBiaya', [App\Http\Controllers\TrxKasUmumController::class, 'tambahBiaya']);
    Route::get('trxKasUmum/selectKategori/{kategori}', [App\Http\Controllers\TrxKasUmumController::class, 'selectKategori']);
?>