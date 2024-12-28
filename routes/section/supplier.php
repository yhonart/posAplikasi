<?php
Route::get('Supplier/AddSupliyer', [App\Http\Controllers\SuplayerController::class, 'AddSupliyer']);
Route::post('Supplier/AddSupliyer/PostSupplier', [App\Http\Controllers\SuplayerController::class, 'PostNewSupplier']);
Route::get('Supplier/tableSupplier/searchTableSup/{keyWord}', [App\Http\Controllers\SuplayerController::class, 'tableSupplier']);
Route::get('Supplier/tableSupplier/EditSupplier/{id}', [App\Http\Controllers\SuplayerController::class, 'editSupplier']);
Route::post('Supplier/tableSupplier/PostSupplierEdit', [App\Http\Controllers\SuplayerController::class, 'postEditSupplier']);
Route::get('Supplier/tableSupplier/DeleteSupplier/{id}', [App\Http\Controllers\SuplayerController::class, 'deleteSupplier']);
Route::get('Supplier/tableSupplier/downloadExcelSupplier', [App\Http\Controllers\SuplayerController::class, 'downloadExcelSupplier']);