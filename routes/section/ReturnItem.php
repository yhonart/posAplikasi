<?php
Route::get('returnItem/purchasingList', [App\Http\Controllers\ReturnItemController::class, 'displayPurchase']);
Route::get('returnItem/purchasingList/searchData/{keyword}', [App\Http\Controllers\ReturnItemController::class, 'searchData']);
Route::get('returnItem/purchasingList/displayItemList/{numberpo}', [App\Http\Controllers\ReturnItemController::class, 'displayItemList']);
Route::get('returnItem/purchasingList/displayReturnItem/{purchCode}', [App\Http\Controllers\ReturnItemController::class, 'displayReturnItem']);
Route::post('returnItem/postItemReturn', [App\Http\Controllers\ReturnItemController::class, 'postItemReturn']);

Route::get('returnItem/satuanAction/{satuanUnit}/{prdID}/{idLo}', [App\Http\Controllers\ReturnItemController::class, 'satuanAction']);
Route::get('returnItem/prodListAction/{productID}/{numberPO}', [App\Http\Controllers\ReturnItemController::class, 'prodListAction']);

Route::get('returnItem/purchasingList/detailItem/{purchCode}', [App\Http\Controllers\ReturnItemController::class, 'detailItem']);