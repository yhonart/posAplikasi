<?php
use Illuminate\Support\Facades\Route;
Route::get('setKasKasir', [App\Http\Controllers\GlobSettingController::class, 'setKasKasir'])->name('setKasKasir');
Route::get('setKasKasir/newNominal', [App\Http\Controllers\GlobSettingController::class, 'newNominal']);
Route::post('setKasKasir/newNominal/postNewNominal', [App\Http\Controllers\GlobSettingController::class, 'postNewNominal']);
Route::get('setKasKasir/tableSetKasKasir', [App\Http\Controllers\GlobSettingController::class, 'tableSetKasKasir']);
Route::get('setKasKasir/editKasKasir/{idKasir}', [App\Http\Controllers\GlobSettingController::class, 'editKasKasir']);
Route::get('setKasKasir/deleteKasKasir/{idKasir}', [App\Http\Controllers\GlobSettingController::class, 'deleteKasKasir']);
Route::post('setKasKasir/editKasKasir/postEditKasKasir', [App\Http\Controllers\GlobSettingController::class, 'postEditKasKasir']);

//set metode pembayarann
Route::get('setPembayaran', [App\Http\Controllers\GlobSettingController::class, 'setPembayaran'])->name('setPembayaran');
Route::get('setPembayaran/tableSetPembayaran', [App\Http\Controllers\GlobSettingController::class, 'tableSetPembayaran']);
Route::get('setPembayaran/newPembayaran', [App\Http\Controllers\GlobSettingController::class, 'newPembayaran']);
Route::post('setPembayaran/newPembayaran/postPembayaran', [App\Http\Controllers\GlobSettingController::class, 'postPembayaran']);
Route::get('setPembayaran/newAkunBank', [App\Http\Controllers\GlobSettingController::class, 'newAkunBank']);
Route::post('setPembayaran/newAkunBank/postnewAkunBank', [App\Http\Controllers\GlobSettingController::class, 'postnewAkunBank']);
Route::get('setPembayaran/editAkun/{id}', [App\Http\Controllers\GlobSettingController::class, 'editAkun']);
Route::post('setPembayaran/postEditAkun', [App\Http\Controllers\GlobSettingController::class, 'postEditAkun']);
Route::get('setPembayaran/deleteAkun/{id}', [App\Http\Controllers\GlobSettingController::class, 'deleteAkun']);
Route::get('setPembayaran/deletePembayaran/{id}', [App\Http\Controllers\GlobSettingController::class, 'deletePembayaran']);
Route::get('setPembayaran/editMethod/{id}', [App\Http\Controllers\GlobSettingController::class, 'editMethod']);
Route::post('setPembayaran/editMethod/postEditPembayaran', [App\Http\Controllers\GlobSettingController::class, 'postEditPembayaran']);


Route::get('modalKasKecil', [App\Http\Controllers\GlobSettingController::class, 'modalKasKecil'])->name('modalKasKecil');
Route::get('modalKasKecil/formAddModalFix', [App\Http\Controllers\GlobSettingController::class, 'formAddModalFix']);
Route::post('modalKasKecil/formAddModalFix/postModalFixed', [App\Http\Controllers\GlobSettingController::class, 'postModalFixed']);
?>
