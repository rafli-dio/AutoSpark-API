<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\LayananController;
use App\Http\Controllers\Web\LayananTambahanController;
use App\Http\Controllers\Web\UkuranKendaraanController;
use App\Http\Controllers\Web\MetodePembayaranController;
use App\Http\Controllers\Web\PesananController;
use App\Http\Controllers\Web\PembayaranController;
use App\Http\Controllers\Web\UserController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('post-login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('admin.web')->group(function () {
    Route::get('/admin-autoSpark', [DashboardController::class, 'index'])->name('get-dashboard-admin');

    // Layanan Routes
    Route::get('/admin-autoSpark/layanan', [LayananController::class, 'index'])->name('get-layanan-admin');
    Route::post('save-layanan-admin', [LayananController::class, 'store'])->name('save-layanan-admin');
    Route::put('/admin-autoSpark/layanan/{id}', [LayananController::class, 'update'])->name('update-layanan-admin');
    Route::delete('/admin-autoSpark/layanan/{id}', [LayananController::class, 'destroy'])->name('destroy-layanan-admin');

    // Layanan Tambahan Routes  
    Route::get('/admin-autoSpark/layanan-tambahan', [LayananTambahanController::class, 'index'])->name('get-layanan-tambahan-admin');
    Route::post('save-layanan-tambahan-admin', [LayananTambahanController::class, 'store'])->name('save-layanan-tambahan-admin');
    Route::put('/admin-autoSpark/layanan-tambahan/{id}', [LayananTambahanController::class, 'update'])->name('update-layanan-tambahan-admin');
    Route::delete('/admin-autoSpark/layanan-tambahan/{id}', [LayananTambahanController::class, 'destroy'])->name('destroy-layanan-tambahan-admin');

    // Metode Pembayaran Routes
    Route::get('/admin-autoSpark/metode-pembayaran', [MetodePembayaranController::class, 'index'])->name('get-metode-pembayaran-admin');
    Route::post('save-metode-pembayaran-admin', [MetodePembayaranController::class, 'store'])->name('save-metode-pembayaran-admin');
    Route::put('/admin-autoSpark/metode-pembayaran/{id}', [MetodePembayaranController::class, 'update'])->name('update-metode-pembayaran-admin');
    Route::delete('/admin-autoSpark/metode-pembayaran/{id}', [MetodePembayaranController::class, 'destroy'])->name('destroy-metode-pembayaran-admin');

    // Ukuran Kendaraan Routes
    Route::get('/admin-autoSpark/ukuran-kendaraan', [UkuranKendaraanController::class, 'index'])->name('get-ukuran-kendaraan-admin');
    Route::post('save-ukuran-kendaraan-admin', [UkuranKendaraanController::class, 'store'])->name('save-ukuran-kendaraan-admin');
    Route::put('/admin-autoSpark/ukuran-kendaraan/{id}', [UkuranKendaraanController::class, 'update'])->name('update-ukuran-kendaraan-admin');
    Route::delete('/admin-autoSpark/ukuran-kendaraan/{id}', [UkuranKendaraanController::class, 'destroy'])->name('destroy-ukuran-kendaraan-admin');

    // Pesanan Routes
    Route::get('/admin-autoSpark/pesanan-cuci', [PesananController::class, 'index'])->name('get-pesanan-cuci-admin');
    Route::put('/admin-autoSpark/pesanan-cuci/{id}/update-status', [PesananController::class, 'update'])->name('update-pesanan-cuci-admin');
  
    // Pembayaran Routes
    Route::get('/admin-autoSpark/pembayaran', [PembayaranController::class, 'index'])->name('get-pembayaran-admin');
    Route::put('/admin-autoSpark/pembayaran/{id}/update-status', [PembayaranController::class, 'updateStatus'])->name('update-status-pembayaran-admin');

    //User Routes
    Route::get('/admin-autoSpark/user/admin', [UserController::class, 'getAdmin'])->name('get-user-admin');
    Route::get('/admin-autoSpark/user/pegawai', [UserController::class, 'getPewagai'])->name('get-user-pegawai');
    Route::get('/admin-autoSpark/user/pengguna', [UserController::class, 'getPengguna'])->name('get-user-pengguna');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
