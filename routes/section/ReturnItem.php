<?php
use Illuminate\Support\Facades\Route;
Route::get('returnItem/purchasingList', [App\Http\Controllers\ReturnItemController::class, 'displayPurchase']);
Route::get('returnItem/purchasingList/searchData/{keyword}', [App\Http\Controllers\ReturnItemController::class, 'searchData']);
Route::get('returnItem/purchasingList/displayItemList/{numberpo}', [App\Http\Controllers\ReturnItemController::class, 'displayItemList']);
Route::get('returnItem/purchasingList/displayReturnItem/{purchCode}', [App\Http\Controllers\ReturnItemController::class, 'displayReturnItem']);
Route::post('returnItem/postItemReturn', [App\Http\Controllers\ReturnItemController::class, 'postItemReturn']);

Route::get('returnItem/productAction/{prdID}', [App\Http\Controllers\ReturnItemController::class, 'productAction']);
Route::get('returnItem/satuanAction/{satuanUnit}/{prdID}/{idLo}', [App\Http\Controllers\ReturnItemController::class, 'satuanAction']);
Route::get('returnItem/prodListAction/{productID}/{numberPO}', [App\Http\Controllers\ReturnItemController::class, 'prodListAction']);

Route::get('returnItem/purchasingList/detailItem/{purchCode}', [App\Http\Controllers\ReturnItemController::class, 'detailItem']);
Route::get('returnItem/purchasingList/deleteItem/{id}', [App\Http\Controllers\ReturnItemController::class, 'deleteItem']);

Route::get('returnItem/returnHistory', [App\Http\Controllers\ReturnItemController::class, 'returnHistory']);
Route::get('returnItem/returnHistory/detailHistory/{purchNumber}', [App\Http\Controllers\ReturnItemController::class, 'detailHistory']);
Route::get('returnItem/returnHistory/approveTransaksi/{purchNumber}', [App\Http\Controllers\ReturnItemController::class, 'approveTransaksi']);

Route::get('returnItem/returnNonInv', [App\Http\Controllers\ReturnItemController::class, 'returnNonInv']);
Route::post('returnItem/returnNonInv/postDokumenReturn', [App\Http\Controllers\ReturnItemController::class, 'postDokumenReturn']);
Route::get('returnItem/submitRetur/{poNumber}', [App\Http\Controllers\ReturnItemController::class, 'submitRetur']);
Route::get('returnItem/displayInputItemNonInv', [App\Http\Controllers\ReturnItemController::class, 'displayInputItemNonInv']);
Route::get('returnItem/warehouseSelected/{warehouse}/{productID}/{satuan}', [App\Http\Controllers\ReturnItemController::class, 'warehouseSelected']);
Route::get('returnItem/productActionNonInv/{productID}', [App\Http\Controllers\ReturnItemController::class, 'productActionNonInv']);
Route::post('returnItem/postItemReturnNonInvoice', [App\Http\Controllers\ReturnItemController::class, 'postItemReturnNonInvoice']);
Route::get('returnItem/purchasingList/itemReturnNonInv/{returnNumber}', [App\Http\Controllers\ReturnItemController::class, 'itemReturnNonInv']);
?>