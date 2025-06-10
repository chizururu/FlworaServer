<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\DeviceController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

/*
 * User Controller -> Login and Register */
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);
