<?php
use Illuminate\Support\Facades\Route;
    Route::get('sales/daftarKunjungan', [App\Http\Controllers\SalesController::class, 'daftarKunjungan']);
    Route::get('sales/detailCustomer/{id}', [App\Http\Controllers\SalesController::class, 'detailCustomer']);
    Route::get('sales/formKunjungan', [App\Http\Controllers\SalesController::class, 'formKunjungan']);
    Route::post('sales/formKunjungan/postNewTransaksi', [App\Http\Controllers\SalesController::class, 'postNewTransaksi']);
    Route::post('sales/formKunjungan/postAddProduct', [App\Http\Controllers\SalesController::class, 'postAddProduct']);
    Route::get('sales/formKunjungan/tableProdukDeal', [App\Http\Controllers\SalesController::class, 'tableProdukDeal']);
    Route::get('sales/formKunjungan/tableProdukDeal/deletedOrder/{dataID}', [App\Http\Controllers\SalesController::class, 'deletedOrder']);
    Route::get('sales/salesDasboard', [App\Http\Controllers\SalesController::class, 'salesDasboard']);
    
    // Admin 
    Route::get('sales/mainDashboard', [App\Http\Controllers\SalesAdminController::class, 'mainDashboard']);

    // Admin Master Produk
    Route::get('sales/mainProduct', [App\Http\Controllers\SalesAdminController::class, 'mainProduct']);
    Route::get('sales/mainProduct/newProduct', [App\Http\Controllers\SalesAdminController::class, 'newProduct']);
    Route::post('sales/mainProduct/newProduct/postNewProduct', [App\Http\Controllers\SalesAdminController::class, 'postNewProduct']);
    Route::get('sales/mainProduct/newProduct/newPrice/{id}', [App\Http\Controllers\SalesAdminController::class, 'newPrice']);
    Route::get('sales/mainProduct/newProduct/modalNewVarian/{id}', [App\Http\Controllers\SalesAdminController::class, 'modalNewVarian']);
    Route::get('sales/mainProduct/newProduct/modalNewVarianFixed/{id}', [App\Http\Controllers\SalesAdminController::class, 'modalNewVarianFixed']);
    Route::get('sales/mainProduct/newProduct/tableVarianPrice/{id}', [App\Http\Controllers\SalesAdminController::class, 'tableVarianPrice']);
    Route::post('sales/mainProduct/newProduct/postNewVarian', [App\Http\Controllers\SalesAdminController::class, 'postNewVarian']);
    Route::post('sales/mainProduct/newProduct/postNewVarianFixed', [App\Http\Controllers\SalesAdminController::class, 'postNewVarianFixed']);
    
    Route::get('sales/mainProduct/detailProduct/{dataID}', [App\Http\Controllers\SalesAdminController::class, 'detailProduct']);

    Route::get('sales/mainCustomer', [App\Http\Controllers\SalesAdminController::class, 'mainCustomer']);
    Route::get('sales/mainSalesOrder', [App\Http\Controllers\SalesAdminController::class, 'mainSalesOrder']);
    Route::get('sales/mainDeliveryReport', [App\Http\Controllers\SalesAdminController::class, 'mainDeliveryReport']);
    
    Route::get('sales/mainUser', [App\Http\Controllers\SalesAdminController::class, 'mainUser']);
    Route::get('sales/mainCategory', [App\Http\Controllers\SalesAdminController::class, 'mainCategory']);
    Route::get('sales/mainCategory/newCategory', [App\Http\Controllers\SalesAdminController::class, 'newCategory']);
    Route::get('sales/mainCategory/dataTableCategory', [App\Http\Controllers\SalesAdminController::class, 'dataTableCategory']);
    
    Route::get('sales/mainStock', [App\Http\Controllers\SalesAdminController::class, 'mainStock']);
    Route::get('sales/mainStock/dataResultInv/{prdVal}/{catVal}', [App\Http\Controllers\SalesAdminController::class, 'dataResultInv']);
    
    Route::get('sales/mainStockOpname', [App\Http\Controllers\SalesAdminController::class, 'mainStockOpname']);
    Route::get('sales/displayStockOpname', [App\Http\Controllers\SalesAdminController::class, 'displayStockOpname']);
    Route::post('sales/displayStockOpname/postDokumen', [App\Http\Controllers\SalesAdminController::class, 'postDokumen']);
    Route::get('sales/displaySatuanProduct/{prdID}', [App\Http\Controllers\SalesAdminController::class, 'displaySatuanProduct']);
    Route::get('sales/displayStock/{satuan}/{prdID}/{loc}', [App\Http\Controllers\SalesAdminController::class, 'displayStock']);
    Route::post('sales/displayStockOpname/postItem', [App\Http\Controllers\SalesAdminController::class, 'postItem']);
    Route::get('sales/displayStockOpname/tableInputItem/{docNo}', [App\Http\Controllers\SalesAdminController::class, 'tableInputItem']);
    Route::get('sales/displayStockOpname/submitTransItem/{docNo}', [App\Http\Controllers\SalesAdminController::class, 'submitTransItem']);
    Route::get('sales/displayStockOpname/submitBatalTransItem/{docNo}', [App\Http\Controllers\SalesAdminController::class, 'submitBatalTransItem']);
    Route::get('sales/mainTableStockOpname', [App\Http\Controllers\SalesAdminController::class, 'mainTableStockOpname']);
    
    //Admin Kurir
    Route::get('sales/mainKurir', [App\Http\Controllers\KurirController::class, 'mainKurir']);
    Route::get('sales/mainKurir/funcDate/{date}', [App\Http\Controllers\KurirController::class, 'funcDate']);
    Route::get('sales/mainKurir/historyDate/{date}', [App\Http\Controllers\KurirController::class, 'historyDate']);
    Route::get('sales/historyDelivery', [App\Http\Controllers\KurirController::class, 'historyDelivery']);
    Route::get('sales/mainKurir/penerimaan/{configID}/{customerCode}', [App\Http\Controllers\KurirController::class, 'penerimaan']);
    Route::post('sales/mainKurir/postPenerimaan', [App\Http\Controllers\KurirController::class, 'postPenerimaan']);
    Route::get('sales/mainKurir/pending/{configID}', [App\Http\Controllers\KurirController::class, 'pending']);
    
    //Admin Konfig
    Route::get('sales/configCustomer', [App\Http\Controllers\ConfigController::class, 'mainConfigCustomer']);
    Route::get('sales/configCustomer/aturPengiriman/{idmCus}', [App\Http\Controllers\ConfigController::class, 'aturPengiriman']);
    Route::get('sales/configCustomer/aturPembayaran/{idmCus}', [App\Http\Controllers\ConfigController::class, 'aturPembayaran']);
    Route::post('sales/configCustomer/postConfigSchedule', [App\Http\Controllers\ConfigController::class, 'postConfigSchedule']);
    Route::post('sales/configCustomer/postConfigPembayaran', [App\Http\Controllers\ConfigController::class, 'postConfigPembayaran']);
    Route::get('sales/configCustomer/aturPenjualan/{cusCode}', [App\Http\Controllers\ConfigController::class, 'aturPenjualan']);
    Route::post('sales/configCustomer/aturPenjualan/updateQty', [App\Http\Controllers\ConfigController::class, 'updateQty']);
    Route::get('sales/configCustomer/aturPenjualan/addOrder/{cusCode}', [App\Http\Controllers\ConfigController::class, 'addOrder']);
    Route::post('sales/configCustomer/aturPenjualan/addOrder/postOrder', [App\Http\Controllers\ConfigController::class, 'postOrder']);
    
    //Admin Transaksi 
    Route::get('sales/mainPengiriman', [App\Http\Controllers\DeliveryController::class, 'mainPengiriman']);
    Route::get('sales/mainPengiriman/selectDatePengiriman/{date}', [App\Http\Controllers\DeliveryController::class, 'selectDatePengiriman']);

?>