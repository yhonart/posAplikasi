<?php
Route::get('Customers/AddCustomers', [App\Http\Controllers\CustomersController::class, 'AddCustomers']);
Route::post('Customers/AddCustomers/PostNewCustomer', [App\Http\Controllers\CustomersController::class, 'PostNewCustomer']);
// Route::get('Customers/TableDataCustomer', [App\Http\Controllers\CustomersController::class, 'TableDataCustomer']);
Route::get('Customers/TableDataCustomer/searchTableCus/{keyword}', [App\Http\Controllers\CustomersController::class, 'TableDataCustomer']);
Route::get('Customers/TableDataCustomer/EditTable/{id}', [App\Http\Controllers\CustomersController::class, 'EditTable']);
Route::post('Customers/TableDataCustomer/PostEditTable', [App\Http\Controllers\CustomersController::class, 'PostEditTable']);
Route::get('Customers/TableDataCustomer/DeleteTable/{id}', [App\Http\Controllers\CustomersController::class, 'DeleteTable']);
Route::get('Customers/downloadAllCustomer', [App\Http\Controllers\CustomersController::class, 'downloadAllCustomer']);