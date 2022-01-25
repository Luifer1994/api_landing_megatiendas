<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [UserController::class, 'login']);
Route::post('/register-coupon-client', [ClientController::class, 'registerCopupon']);
Route::get('/cunt-coupon-for-day', [ClientController::class, 'cuoponForDay']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/list-coupon-client', [ClientController::class, 'listClientsCoupon']);
    Route::get('/detail-coupon-client/{id}', [ClientController::class, 'detailClientCoupon']);
});