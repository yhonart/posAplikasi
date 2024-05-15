<?php
Route::get('WhManaged', [App\Http\Controllers\HomeController::class, 'getMenu'])->name('WhManaged');