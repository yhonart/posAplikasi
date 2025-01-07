<?php
use Illuminate\Support\Facades\Route;
Route::get('WhManaged', [App\Http\Controllers\HomeController::class, 'getMenu'])->name('WhManaged');
?>