<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\BlueprintController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function (){

    Route::post('/logout', [AuthController::class, 'logout']);

    // Route::apiResource('blueprints', \App\Http\Controllers\BlueprintController::class);

    Route::get('/blueprints',[BlueprintController::class, 'index']);
    Route::post('/blueprints',[BlueprintController::class, 'store']);
    Route::get('/blueprints/{blueprint}',[BlueprintController::class, 'show']);
    Route::put('/blueprints/{blueprint}',[BlueprintController::class, 'update']);
    Route::delete('/blueprints/{blueprint}',[BlueprintController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

