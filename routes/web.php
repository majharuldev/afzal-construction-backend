<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/list', [AuthController::class, 'index']);
Route::middleware('api')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
});

