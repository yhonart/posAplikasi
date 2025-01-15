<?php
use Illuminate\Support\Facades\Route;
Route::get('kasKecil/laporanKasKecil', [App\Http\Controllers\TrxKasKecilController::class, 'laporanKasKecil']);
Route::get('kasKecil/tableLaporan/{kasir}/{fromDate}/{endDate}', [App\Http\Controllers\TrxKasKecilController::class, 'tableLaporan']);
Route::get('kasKecil/cetakKasKecil/{kasir}/{fromDate}/{endDate}', [App\Http\Controllers\TrxKasKecilController::class, 'cetakKasKecil']);
Route::get('kasKecil/addModalKas', [App\Http\Controllers\TrxKasKecilController::class, 'addModalKas']);
?>