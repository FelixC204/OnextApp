<?php

use App\Http\Controllers\Shopify\AuthController;
use App\Http\Controllers\Shopify\HomeController;
use App\Http\Controllers\Shopify\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::controller(AuthController::class)
    ->group(function() {
        Route::get('/login', 'login')->name('login');
        Route::get('/callback', 'callback')->name('callback');
        Route::post('/get-access-token', 'getAccessToken')->name('getsession');
});


Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class,'logout'])->name('logout')->middleware('web');
});

Route::controller(HomeController::class)
->group(function() {
    Route::get('/home', 'homeIndex')->name('home');
});

Route::post('/profile', [ProfileController::class, 'getProfile'])->name('profile')->middleware('auth:sanctum');



