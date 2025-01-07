<?php
use Illuminate\Support\Facades\Route;
Route::get('ProjcManaged', [App\Http\Controllers\HomeController::class, 'getMenu'])->name('ProjcManaged');
?>