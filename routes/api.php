<?php

use App\Http\Controllers\SeansApiController;
use App\Http\Controllers\KlientApiController;
use App\Http\Controllers\UslugaApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KosmetologApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/seans', [SeansApiController::class, 'index']);
Route::get('/seans/{id}', [SeansApiController::class, 'show']);

Route::get('/klient', [KlientApiController::class, 'index']);
Route::get('/klient/{id}', [KlientApiController::class, 'show']);

Route::get('/usluga', [UslugaApiController::class, 'index']);
Route::get('/usluga/{id}', [UslugaApiController::class, 'show']);





Route::post('/login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/seans', [SeansApiController::class, 'index']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::get('/klient_total', [KlientApiController::class, 'total']);

Route::get('/usluga_total', [UslugaApiController::class, 'total']);


Route::post('/usluga', [UslugaApiController::class, 'store']);


Route::get('/kosmetolog', [KosmetologApiController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/klient', [KlientApiController::class, 'store']);
    Route::put('/klient/{id}', [KlientApiController::class, 'update']);
    Route::delete('/klient/{id}', [KlientApiController::class, 'destroy']);
});
