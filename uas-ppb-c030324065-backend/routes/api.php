<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MahasiswaController;
use App\Http\Controllers\Api\ProgramStudiController;
use App\Http\Controllers\Api\AngkatanController;
use App\Http\Controllers\Api\HobbyController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('mahasiswa', MahasiswaController::class);

    Route::get('/program-studi', [ProgramStudiController::class, 'index']);
    Route::get('/angkatan', [AngkatanController::class, 'index']);
    Route::get('/hobby', [HobbyController::class, 'index']);

});
