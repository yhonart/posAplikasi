<?php
Route::get('MoU/AddMoU', [App\Http\Controllers\MoUController::class, 'AddMoU']);
Route::post('MoU/AddMoU/PostNewMoU', [App\Http\Controllers\MoUController::class, 'PostAddMoU']);
Route::get('MoU/tableMoU', [App\Http\Controllers\MoUController::class, 'tableMoU']);
Route::get('MoU/tableMoU/EditMoU/{id}', [App\Http\Controllers\MoUController::class, 'editMOU']);
Route::post('MoU/EditMoU/PostEditMoU', [App\Http\Controllers\MoUController::class, 'PostEditMoU']);
Route::get('MoU/tableMoU/DeleteMoU/{id}', [App\Http\Controllers\MoUController::class, 'tableMoU']);