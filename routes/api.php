<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LayananController;
use App\Http\Controllers\Api\LayananTambahanController;
use App\Http\Controllers\Api\UkuranKendaraanController;
use App\Http\Controllers\Api\PesananCuciController;
use App\Http\Controllers\Api\RiwayatPesananController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\MetodePembayaranController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('autospark')->group(function () {
    // Public Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::apiResource('/roles', RoleController::class);

    // jika role admin
    Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::apiResource('/users-admin', UserController::class);
        Route::apiResource('/layanans-admin', LayananController::class);
        Route::apiResource('/layanan-tambahans-admin', LayananTambahanController::class);
        Route::apiResource('/ukuran-kendaraans-admin', UkuranKendaraanController::class);
        Route::apiResource('/pesanan-cucis-admin', PesananCuciController::class);
        Route::apiResource('/riwayat-pesanans-admin', RiwayatPesananController::class);
        Route::apiResource('/metode-pembayarans-admin', MetodePembayaranController::class);
    });

    // jika role pengguna
    Route::middleware(['auth:sanctum', 'role:Pengguna'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/layanans', [LayananController::class, 'index']);
        Route::get('/layanan-tambahans', [LayananTambahanController::class, 'index']);
        Route::get('/ukuran-kendaraans', [UkuranKendaraanController::class, 'index']);
        Route::get('/options', [PesananCuciController::class, 'getOptions']);
        Route::post('/pesanan-cucis', [PesananCuciController::class, 'store']);
        Route::get('/riwayat-pesanans', [RiwayatPesananController::class, 'index']);
        Route::get('/profile-pengguna', [UserProfileController::class, 'getProfile']);
        Route::post('/profile-pengguna', [UserProfileController::class, 'updateProfile']);
    });
});
