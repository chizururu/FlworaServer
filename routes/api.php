<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\DeviceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    // User
    Route::get('/users', [AuthController::class, 'index']);
    Route::patch('/users/{users}/change-profile', [AuthController::class, 'update']);

    // Sector
    Route::resource('/sector', SectorController::class);

    // Device
    Route::resource('/device', DeviceController::class);
});
