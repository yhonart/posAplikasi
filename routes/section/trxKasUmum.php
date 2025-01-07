<?php
use Illuminate\Routing\Route;    
    Route::get('trxKasUmum/tambahBiaya', [App\Http\Controllers\TrxKasUmumController::class, 'tambahBiaya']);
    Route::get('trxKasUmum/selectKategori/{kategori}', [App\Http\Controllers\TrxKasUmumController::class, 'selectKategori']);
    Route::post('trxKasUmum/postTrxPembiayaan', [App\Http\Controllers\TrxKasUmumController::class, 'postTrxPembiayaan']);
    Route::get('trxKasUmum/filterByDate/{fromDate}/{endDate}', [App\Http\Controllers\TrxKasUmumController::class, 'filterByDate']);
    Route::get('trxKasUmum/modalEditKas/{id}', [App\Http\Controllers\TrxKasUmumController::class, 'modalEditKas']);
    Route::post('trxKasUmum/postTrxEditKas', [App\Http\Controllers\TrxKasUmumController::class, 'postTrxEditKas']);
    Route::get('trxKasUmum/exportData/{exportType}/{fromDate}/{endDate}', [App\Http\Controllers\TrxKasUmumController::class, 'exportData']);
?>