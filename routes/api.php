<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\LayananController;
use App\Http\Controllers\Api\LayananTambahanController;
use App\Http\Controllers\Api\UkuranKendaraanController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('autospark/roles', RoleController::class);
Route::apiResource('autospark/layanans', LayananController::class);
Route::apiResource('autospark/layanan-tambahans', LayananTambahanController::class);
Route::apiResource('autospark/ukuran-kendaraans', UkuranKendaraanController::class);