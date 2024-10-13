<?php
Route::get('AssManaged', [App\Http\Controllers\AssManagedController::class, 'main'])->name('AssManaged');
Route::get('M_Category', [App\Http\Controllers\AssManagedController::class, 'mCategory'])->name('M_Category');
Route::get('M_Category/AddCategory', [App\Http\Controllers\AssManagedController::class, 'FormAddCategory']);
Route::post('M_Category/AddCategory/PostNewCategory', [App\Http\Controllers\AssManagedController::class, 'PostNewCategory']);
Route::get('M_Category/arrayCategory', [App\Http\Controllers\AssManagedController::class, 'arrayCategory']);
Route::get('M_Category/arrayCategory/editMenu/{id}', [App\Http\Controllers\AssManagedController::class, 'editMenuCategory']);
Route::post('M_Category/arrayCategory/PostEditCategory', [App\Http\Controllers\AssManagedController::class, 'PostEditCategory']);
Route::get('M_Category/arrayCategory/DelPermanently/{id}', [App\Http\Controllers\AssManagedController::class, 'PostDelPermanent']);

//Master Data Manufacture
Route::get('M_Manufacture', [App\Http\Controllers\AssManagedController::class, 'mManufacture'])->name('M_Manufacture');
Route::get('M_Manufacture/AddManufacture', [App\Http\Controllers\AssManagedController::class, 'FormAddManufacture']);
Route::post('M_Manufacture/AddManufacture/PostNewManufacture', [App\Http\Controllers\AssManagedController::class, 'PostNewManufacture']);
Route::get('M_Manufacture/arrayManufacture', [App\Http\Controllers\AssManagedController::class, 'arrayManufacture']);
Route::get('M_Manufacture/arrayManufacture/editMenu/{id}', [App\Http\Controllers\AssManagedController::class, 'editManufacture']);
Route::post('M_Manufacture/arrayManufacture/PostEditManufacture', [App\Http\Controllers\AssManagedController::class, 'PostEditManufacture']);
Route::get('M_Manufacture/arrayManufacture/DelPermanently/{id}', [App\Http\Controllers\AssManagedController::class, 'PostDelPermanentMF']);

//Master Data Model
Route::get('M_Model', [App\Http\Controllers\AssManagedController::class, 'mModel'])->name('M_Model');
Route::get('M_Model/AddModel', [App\Http\Controllers\AssManagedController::class, 'FormAddModel']);
Route::post('M_Model/AddModel/PostNewModel', [App\Http\Controllers\AssManagedController::class, 'PostNewModel']);
Route::get('M_Model/arrayModel', [App\Http\Controllers\AssManagedController::class, 'arrayModel']);
Route::get('M_Model/arrayModel/editMenu/{id}', [App\Http\Controllers\AssManagedController::class, 'editMenuModel']);
Route::post('M_Model/arrayModel/PostEditModel', [App\Http\Controllers\AssManagedController::class, 'PostEditModel']);


//Asset List
Route::get('AllAssets', [App\Http\Controllers\AssetController::class, 'AssetListIndex'])->name('AllAssets');
Route::get('AllAssets/NewAsset', [App\Http\Controllers\AssetController::class, 'AssetListIndex']);
?>