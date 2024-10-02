<?php
    Route::get('lapLabaRugi/getDisplayAll', [App\Http\Controllers\LapLabaRugiController::class, 'getDisplayAll']);
    Route::get('lapLabaRugi/getDownloadExcel/{prdID}/{fromDate}/{endDate}/{typeCetak}', [App\Http\Controllers\LapLabaRugiController::class, 'getDownloadExcel']);
?>