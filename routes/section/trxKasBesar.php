<?php
use Illuminate\Support\Facades\Route;
Route::get('kasBesar/laporanKasBesar', [App\Http\Controllers\TrxKasBesarController::class, 'laporanKasBesar']);
Route::get('kasBesar/tableLaporan/{kasir}/{fromDate}/{endDate}', [App\Http\Controllers\TrxKasBesarController::class, 'tableLaporan']);
Route::get('kasBesar/dashboardKasBesar', [App\Http\Controllers\TrxKasBesarController::class, 'dashboardKasBesar']);

?>