<?php
Route::get('CompanySetup', [App\Http\Controllers\cpSetupController::class, 'main'])->name('CompanySetup');
Route::get('CompanySetup/companyDisplay', [App\Http\Controllers\cpSetupController::class, 'contentCompany']);
Route::get('CompanySetup/companyDisplay/add_new_cp', [App\Http\Controllers\cpSetupController::class, 'formAddCompany']);
Route::post('CompanySetup/companyDisplay/postNewCompany', [App\Http\Controllers\cpSetupController::class, 'postNewCompany']);
Route::get('CompanySetup/siteSetup', [App\Http\Controllers\cpSetupController::class, 'contentSite'])->name('content_site');
Route::get('CompanySetup/siteSetup/AddWarehouse', [App\Http\Controllers\cpSetupController::class, 'AddWarehouse']);
Route::post('CompanySetup/siteSetup/AddWarehouse/postDataWarehouse', [App\Http\Controllers\cpSetupController::class, 'postDataWarehouse']);
Route::get('CompanySetup/warehouseTable', [App\Http\Controllers\cpSetupController::class, 'warehouseTable']);
Route::get('CompanySetup/warehouseTable/deleteData/{id}', [App\Http\Controllers\cpSetupController::class, 'deleteLocWarehouse']);