<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\LayananController;
use App\Http\Controllers\Web\LayananTambahanController;

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


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
