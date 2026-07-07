<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlueprintController;
use App\Http\Controllers\RawContentController;

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

    Route::get('/raw-contents', [RawContentController::class, 'index']);
    Route::post('/raw-content', [RawContentController::class, 'store']);
    Route::get('/raw-content/{rawContent}', [RawContentController::class, 'show']);

    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::put('/posts/{post}/status', [PostController::class, 'UpdateStatus']);

    Route::post('/posts/{post}/chat', [ChatController::class, 'store']);
});



