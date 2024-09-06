<?php
Route::get('Delivery/formEntryDelivery', [App\Http\Controllers\DeliveryController::class, 'formEntryDelivery']);
Route::post('Delivery/formEntryDelivery/postDataDelivery', [App\Http\Controllers\DeliveryController::class, 'postDataDelivery']);

Route::get('Delivery/tableDataDelivery', [App\Http\Controllers\DeliveryController::class, 'tableDataDelivery']);
Route::get('Delivery/tableDataDelivery/editMenu/{$idDelivery}', [App\Http\Controllers\DeliveryController::class, 'editMenu']);
Route::get('Delivery/tableDataDelivery/deleteMenu/{idDelivery}', [App\Http\Controllers\DeliveryController::class, 'deleteData']);