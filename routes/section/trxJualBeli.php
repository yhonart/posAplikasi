<?php
    Route::post('trxJualBeli/displayFiltering', [App\Http\Controllers\trxJualBeliController::class, 'displayfiltering']);
    Route::get('trxJualBeli/editPenjualan/{id}', [App\Http\Controllers\trxJualBeliController::class, 'editPenjualan']);
?>