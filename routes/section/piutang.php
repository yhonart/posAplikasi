<?php
    Route::get('adminPiutangPelanggan/pembayaran', [App\Http\Controllers\LoanMaintenanceController::class, 'pembayaran']);
    Route::get('adminPiutangPelanggan/saldo', [App\Http\Controllers\LoanMaintenanceController::class, 'saldo']);
    Route::get('adminPiutangPelanggan/lapCustomer', [App\Http\Controllers\LoanMaintenanceController::class, 'lapCustomer']);
    Route::get('adminPiutangPelanggan/setup', [App\Http\Controllers\LoanMaintenanceController::class, 'setup']);
?>