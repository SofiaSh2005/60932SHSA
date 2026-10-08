<?php

use App\Http\Controllers\SeansApiController;
use App\Http\Controllers\KlientApiController;
use App\Http\Controllers\UslugaApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KosmetologApiController;
use App\Http\Controllers\BookingApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/seans/{id}', [SeansApiController::class, 'show']);

Route::get('/klient', [KlientApiController::class, 'index']);
Route::get('/klient/{id}', [KlientApiController::class, 'show']);

Route::get('/usluga', [UslugaApiController::class, 'index']);
Route::get('/bookable-services', [UslugaApiController::class, 'bookable']);
Route::get('/usluga/{id}', [UslugaApiController::class, 'show']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/usluga/{usluga}/masters', [BookingApiController::class, 'masters']);
Route::get('/available-slots', [BookingApiController::class, 'slots']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/seans', [SeansApiController::class, 'index']);

    Route::get('/user', function (Request $request) {
        return $request->user()->load('klient');
    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::post('/usluga', [UslugaApiController::class, 'store']);
    Route::put('/usluga/{id}', [UslugaApiController::class, 'update']);
    Route::delete('/usluga/{id}', [UslugaApiController::class, 'destroy']);

    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/bookings', [BookingApiController::class, 'store']);
    Route::get('/my-bookings', [BookingApiController::class, 'mine']);
    Route::get('/admin/bookings', [BookingApiController::class, 'adminIndex']);
    Route::post('/admin/bookings', [BookingApiController::class, 'adminStore']);
    Route::patch('/admin/bookings/{seans}/status', [BookingApiController::class, 'setStatus']);

    Route::post('/kosmetolog', [KosmetologApiController::class, 'store']);
    Route::put('/kosmetolog/{kosmetolog}', [KosmetologApiController::class, 'update']);
    Route::delete('/kosmetolog/{kosmetolog}', [KosmetologApiController::class, 'destroy']);

});

Route::get('/klient_total', [KlientApiController::class, 'total']);

Route::get('/usluga_total', [UslugaApiController::class, 'total']);

Route::get('/kosmetolog', [KosmetologApiController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/klient', [KlientApiController::class, 'store']);
    Route::put('/klient/{id}', [KlientApiController::class, 'update']);
    Route::delete('/klient/{id}', [KlientApiController::class, 'destroy']);
});
