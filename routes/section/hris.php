<?php
use Illuminate\Support\Facades\Route;
Route::get('HRIS', [App\Http\Controllers\HomeController::class, 'getMenu'])->name('HRIS');
?>