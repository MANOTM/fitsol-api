<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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
    Route::post('/verifyToken','verifyToken')->middleware('auth:sanctum');
    Route::post('/resentToken','resentToken');
    Route::post('/login','login');
    Route::post('/FotgertPassword','FotgertPassword');
    Route::post('/CheckToken','CheckToken');
    Route::post('/resetPassword','resetPassword');
    Route::post('/logout','logout')->middleware('auth:sanctum');
    Route::post('/me','me')->middleware('auth:sanctum');
});


Route::controller(ProductController::class)->group(function(){
    Route::get('/newArrival','newArrival');
    Route::get('/random-for-men','randomformen');
    Route::get('/random-for-women','randomforwomen');
    Route::get('/alsolike','alsolike');
    Route::post('/products-men','productsmen');
    Route::post('/products-women','productswomen');
    Route::post('/products-kids','productskids');
    Route::post('/shop-all','shopall');
    Route::post('/search','search');
    Route::get('/sugg-bag','suggBag');
    Route::get('/searchcount/{term}','searchcount');
    Route::get('/product/{token}','product');
});








