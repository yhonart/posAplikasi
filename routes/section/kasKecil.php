<?php
use Illuminate\Support\Facades\Route;
Route::get('kasKecil/laporanKasKecil', [App\Http\Controllers\TrxKasKecilController::class, 'laporanKasKecil']);
Route::get('kasKecil/tableLaporan/{kasir}/{fromDate}/{endDate}', [App\Http\Controllers\TrxKasKecilController::class, 'tableLaporan']);
Route::get('kasKecil/cetakKasKecil/{kasir}/{fromDate}/{endDate}', [App\Http\Controllers\TrxKasKecilController::class, 'cetakKasKecil']);
Route::get('kasKecil/addModalKas', [App\Http\Controllers\TrxKasKecilController::class, 'addModalKas']);
Route::get('kasKecil/boxContentDana', [App\Http\Controllers\TrxKasKecilController::class, 'boxContentDana']);
Route::post('kasKecil/addModalKas/postingTambahSaldo', [App\Http\Controllers\TrxKasKecilController::class, 'postingTambahSaldo']);
?>