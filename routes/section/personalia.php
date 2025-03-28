<?php
use Illuminate\Support\Facades\Route;
Route::get('Personalia/newUsers', [App\Http\Controllers\PersonaliaController::class, 'newUsers']);
Route::post('Personalia/newUsers/postNewUser', [App\Http\Controllers\PersonaliaController::class, 'postNewUser']);
Route::get('Personalia/modalHakAkses/{id}', [App\Http\Controllers\PersonaliaController::class, 'modalHakAkses']);
Route::post('Personalia/postEditHakAkses', [App\Http\Controllers\PersonaliaController::class, 'postEditHakAkses']);
Route::post('Personalia/loadDataHakAkses', [App\Http\Controllers\PersonaliaController::class, 'loadDataHakAkses']);
Route::get('Personalia/modalEditUser/{id}', [App\Http\Controllers\PersonaliaController::class, 'modalEditUser']);
Route::get('Personalia/dataTablePersonalia', [App\Http\Controllers\PersonaliaController::class, 'dataTablePersonalia']);
Route::get('Personalia/dataTablePersonalia/searchData/{keyword}', [App\Http\Controllers\PersonaliaController::class, 'searchData']);
Route::get('Personalia/dataTablePersonalia/modalFormEdit/{id}', [App\Http\Controllers\PersonaliaController::class, 'modalFormEdit']);
Route::post('Personalia/dataTablePersonalia/postEditPersonalia', [App\Http\Controllers\PersonaliaController::class, 'postEditPersonalia']);
Route::get('Personalia/dataTablePersonalia/deletePersonalia/{id}', [App\Http\Controllers\PersonaliaController::class, 'deletePersonalia']);
Route::get('Personalia/delHakAkses/{id}', [App\Http\Controllers\PersonaliaController::class, 'delHakAkses']);
Route::post('Personalia/changeHakAkses', [App\Http\Controllers\PersonaliaController::class, 'changeHakAkses']);
Route::post('Personalia/formEditProfile', [App\Http\Controllers\PersonaliaController::class, 'formEditProfile']);
Route::post('Personalia/changePassword', [App\Http\Controllers\PersonaliaController::class, 'changePassword']);
Route::get('Personalia/delPersonalia/{id}', [App\Http\Controllers\PersonaliaController::class, 'delPersonalia']);
Route::post('Personalia/postHakAksesMenu', [App\Http\Controllers\PersonaliaController::class, 'postHakAksesMenu']);
Route::get('Personalia/loadHakAksesMenu/{id}', [App\Http\Controllers\PersonaliaController::class, 'loadHakAksesMenu']);
Route::get('Personalia/subMenuList/{menuId}', [App\Http\Controllers\PersonaliaController::class, 'subMenuList']);
Route::get('Personalia/deleteAksesMenu/{paramId}', [App\Http\Controllers\PersonaliaController::class, 'deleteAksesMenu']);
Route::post('Personalia/postChangePassword', [App\Http\Controllers\PersonaliaController::class, 'postChangePassword']);
?>