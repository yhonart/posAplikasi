<?php
Route::get('Personalia/modalFormAdd', [App\Http\Controllers\PersonaliaController::class, 'modalFormAdd']);
Route::post('Personalia/modalFormAdd/postDataPersonalia', [App\Http\Controllers\PersonaliaController::class, 'postDataPersonalia']);
Route::get('Personalia/dataTablePersonalia', [App\Http\Controllers\PersonaliaController::class, 'dataTablePersonalia']);
Route::get('Personalia/dataTablePersonalia/searchData/{keyword}', [App\Http\Controllers\PersonaliaController::class, 'searchData']);
Route::get('Personalia/dataTablePersonalia/modalFormEdit/{id}', [App\Http\Controllers\PersonaliaController::class, 'modalFormEdit']);
Route::post('Personalia/dataTablePersonalia/postEditPersonalia', [App\Http\Controllers\PersonaliaController::class, 'postEditPersonalia']);
Route::get('Personalia/dataTablePersonalia/deletePersonalia/{id}', [App\Http\Controllers\PersonaliaController::class, 'deletePersonalia']);