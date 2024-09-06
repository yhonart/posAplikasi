<?php

Route::get('setKasKasir', [App\Http\Controllers\GlobSettingController::class, 'setKasKasir'])->name('setKasKasir');
Route::get('setKasKasir/newNominal', [App\Http\Controllers\GlobSettingController::class, 'newNominal']);
Route::get('setKasKasir/tableSetKasKasir', [App\Http\Controllers\GlobSettingController::class, 'tableSetKasKasir']);