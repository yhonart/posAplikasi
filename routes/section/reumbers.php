<?php
    use Illuminate\Support\Facades\Route;
    Route::get('trxReumbers/tableReumbers', [App\Http\Controllers\TrxReumbersController::class, 'tableReumbers']);
    Route::get('trxReumbers/addReumbers', [App\Http\Controllers\TrxReumbersController::class, 'addReumbers']);
?>