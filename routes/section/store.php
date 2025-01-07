<?php
use Illuminate\Support\Facades\Route;
Route::get('Store/cariProduk/{keyword}', [App\Http\Controllers\StoreController::class, 'cariProduk']);
?>