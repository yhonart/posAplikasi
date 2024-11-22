<?php
Route::get('kasKategori/listTableKategori', [App\Http\Controllers\MasterDataKategoriKasController::class, 'listTableKategori']);
Route::get('kasKategori/addKategori', [App\Http\Controllers\MasterDataKategoriKasController::class, 'addKategori']);
Route::get('kasKategori/listTableSubKategori', [App\Http\Controllers\MasterDataKategoriKasController::class, 'listTableSubKategori']);
Route::get('kasKategori/addSubKategori', [App\Http\Controllers\MasterDataKategoriKasController::class, 'addSubKategori']);
?>