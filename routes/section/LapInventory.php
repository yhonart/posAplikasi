<?php
Route::get('lapInv/formFiltering', [App\Http\Controllers\LapInventoryController::class, 'formFiltering']);
Route::get('lapInv/getFilter/{prdID}', [App\Http\Controllers\LapInventoryController::class, 'getFilter']);
Route::post('lapInv/postFilter', [App\Http\Controllers\LapInventoryController::class, 'postFilter']);