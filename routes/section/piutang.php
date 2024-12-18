<?php
    Route::get('adminPiutangPelanggan/pembayaran', [App\Http\Controllers\LoanMaintenanceController::class, 'pembayaran']);
    Route::get('adminPiutangPelanggan/saldo', [App\Http\Controllers\LoanMaintenanceController::class, 'saldo']);
    Route::get('adminPiutangPelanggan/lapCustomer', [App\Http\Controllers\LoanMaintenanceController::class, 'lapCustomer']);
    Route::get('adminPiutangPelanggan/setup', [App\Http\Controllers\LoanMaintenanceController::class, 'setup']);
    Route::get('adminPiutangPelanggan/saldoFaktur', [App\Http\Controllers\LoanMaintenanceController::class, 'saldoFaktur']);
    Route::get('adminPiutangPelanggan/saldoCustomer', [App\Http\Controllers\LoanMaintenanceController::class, 'saldoCustomer']);
?>