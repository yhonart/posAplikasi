<?php
use Illuminate\Support\Facades\Route;
Route::get('MsService', [App\Http\Controllers\HomeController::class, 'getMenu'])->name('MsService');
?>