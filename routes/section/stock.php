<?php
Route::get('StockList', [App\Http\Controllers\StockListController::class, 'stockList']);
Route::get('Stock/AddProduct', [App\Http\Controllers\StockListController::class, 'AddProduct']);
Route::get('Stock/AddProduct/SelectCat/{id}', [App\Http\Controllers\StockListController::class, 'SelectCat']);
Route::get('Stock/AddProduct/sizeProductInput/{dataIdProd}', [App\Http\Controllers\StockListController::class, 'listSizePrdInput']);
Route::post('Stock/AddProduct/PostProductSetSizing', [App\Http\Controllers\StockListController::class, 'PostProductSetSizing']);
Route::post('Stock/AddProduct/PostProduct', [App\Http\Controllers\StockListController::class, 'PostProduct']);
Route::get('Stock/ProductMaintenance', [App\Http\Controllers\StockListController::class, 'ProductMaintenance']);
Route::get('Stock/ProductMaintenance/SearchProduct/{keyword}', [App\Http\Controllers\StockListController::class, 'ProductSearch']);
Route::get('Stock/ProductMaintenance/MenuPriceEdit/{id}', [App\Http\Controllers\StockListController::class, 'PriceEdit']);
Route::post('Stock/ProductMaintenance/PostNewProductPrice', [App\Http\Controllers\StockListController::class, 'PostNewProductPrice']);
Route::post('Stock/ProductMaintenance/PostEditProductPrice', [App\Http\Controllers\StockListController::class, 'PostEditProductPrice']);
Route::get('Stock/ProductMaintenance/MenuInventory/{id}', [App\Http\Controllers\StockListController::class, 'ProductInventory']);
Route::post('Stock/ProductMaintenance/PostInventory', [App\Http\Controllers\StockListController::class, 'PostInventory']);
