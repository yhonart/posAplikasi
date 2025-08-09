<?php
use Illuminate\Support\Facades\Route;
Route::get('setLokasi/newLokasi', [App\Http\Controllers\setLokasiController::class, 'newFormLokasi']);
Route::post('setLokasi/newLokasi/postNewLocation', [App\Http\Controllers\setLokasiController::class, 'postNewLocation']);
Route::get('setLokasi/tableDataLokasi', [App\Http\Controllers\setLokasiController::class, 'tableDataLokasi']);
?>