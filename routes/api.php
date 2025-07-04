<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SensorMeasurementDataController;

/*
 * User Controller -> Login and Register */
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);

// Routes dengan middleware
Route::middleware('auth:sanctum')->group(function () {
    // Sectors
    Route::resource('/sector', SectorController::class);
    // Devices
    Route::resource('/device', DeviceController::class);
});
