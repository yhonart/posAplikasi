<?php
use Illuminate\Support\Facades\Route;
Route::get('StockList', [App\Http\Controllers\StockListController::class, 'stockList']);

Route::get('Stock/AddProduct', [App\Http\Controllers\StockListController::class, 'AddProduct']);
Route::post('Stock/AddProduct/PostProduct', [App\Http\Controllers\StockListController::class, 'PostProduct']);

Route::get('Stock/AddProduct/SelectCat/{id}', [App\Http\Controllers\StockListController::class, 'SelectCat']);
Route::get('Stock/AddProduct/sizeProductEdit/{coreProductId}', [App\Http\Controllers\StockListController::class, 'listSizePrdEdit']);

Route::post('Stock/AddProduct/PostProductSetSizing', [App\Http\Controllers\StockListController::class, 'PostProductSetSizing']);
Route::post('Stock/AddProduct/PostProductSetGrouping', [App\Http\Controllers\StockListController::class, 'PostProductSetGrouping']);

Route::get('Stock/AddProduct/sizeProductInput/{dataIdProd}', [App\Http\Controllers\StockListController::class, 'listSizePrdInput']);
Route::get('Stock/AddProduct/prodCategoryInput/{dataIdProd}', [App\Http\Controllers\StockListController::class, 'prodCategoryInput']);
Route::get('Stock/AddProduct/cencelSubmit/{dataIdProd}', [App\Http\Controllers\StockListController::class, 'cencelSubmit']);

Route::get('Stock/ProductMaintenance', [App\Http\Controllers\StockListController::class, 'ProductMaintenance']);
Route::get('Stock/ProductMaintenance/SearchProduct/{keyword}', [App\Http\Controllers\StockListController::class, 'ProductSearch']);
Route::get('Stock/ProductMaintenance/MenuPriceEdit/{id}', [App\Http\Controllers\StockListController::class, 'PriceEdit']);
Route::get('Stock/ProductMaintenance/deleteProduct/{id}', [App\Http\Controllers\StockListController::class, 'deleteProduct']);
Route::get('Stock/ProductMaintenance/activeProduct/{id}', [App\Http\Controllers\StockListController::class, 'activeProduct']);
Route::get('Stock/ProductMaintenance/deleteProductPermanent/{id}', [App\Http\Controllers\StockListController::class, 'deleteProductPermanent']);

Route::post('Stock/ProductMaintenance/postEditProduct', [App\Http\Controllers\StockListController::class, 'postEditProduct']);
Route::get('Stock/ProductMaintenance/deleteUnit/{id}', [App\Http\Controllers\StockListController::class, 'deleteUnit']);
Route::post('Stock/ProductMaintenance/postAddUnit', [App\Http\Controllers\StockListController::class, 'postAddUnit']);

Route::post('Stock/ProductMaintenance/PostNewProductPrice', [App\Http\Controllers\StockListController::class, 'PostNewProductPrice']);
Route::post('Stock/ProductMaintenance/PostEditProductPrice', [App\Http\Controllers\StockListController::class, 'PostEditProductPrice']);
Route::get('Stock/ProductMaintenance/MenuInventory/{id}', [App\Http\Controllers\StockListController::class, 'ProductInventory']);
Route::get('Stock/ProductMaintenance/MenuEditHarga/{id}', [App\Http\Controllers\StockListController::class, 'MenuEditHarga']);
Route::post('Stock/ProductMaintenance/PostInventory', [App\Http\Controllers\StockListController::class, 'PostInventory']);

Route::get('Stock/postDeleteItem/{dataId}/{dataSize}', [App\Http\Controllers\StockListController::class, 'postDeleteItem']);
?>