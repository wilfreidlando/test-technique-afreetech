<?php

use App\Http\Controllers\api\AssuranceController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ClientController;
use App\Http\Controllers\api\SuccursaleController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);


    Route::apiResource('succursales', SuccursaleController::class);


    Route::apiResource('clients', ClientController::class);


    Route::apiResource('assurances', AssuranceController::class);
    Route::get('clients/{clientId}/assurances', [AssuranceController::class, 'byClient']);
});
