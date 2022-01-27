<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::post('/login', [UserController::class, 'login']);
Route::post('/register-coupon-client', [ClientController::class, 'registerCopupon']);
Route::get('/cunt-coupon-for-day', [CouponController::class, 'cuoponForDay']);
Route::get('/cunt-coupon-for-city', [CouponController::class, 'cuoponForCity']);
Route::get('/top-client-for-coupon', [CouponController::class, 'topClientNumberCoupon']);



Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/list-coupon-client', [ClientController::class, 'listClientsCoupon']);
    Route::get('/detail-coupon-client/{id}', [ClientController::class, 'detailClientCoupon']);
    Route::get('/coupon-export', [CouponController::class, 'export']);
});