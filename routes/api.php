<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function(){
    Route::post('/register','register');
    Route::post('/verifyToken','verifyToken');
    Route::post('/resentToken','resentToken');
    Route::post('/login','login');
    Route::post('/resetPassword','resetPassword');
    Route::post('/logout','logout')->middleware('auth:sanctum');
});








