<?php

use App\Http\Controllers\SeansApiController;
use App\Http\Controllers\KlientApiController;
use App\Http\Controllers\UslugaApiController;
use Illuminate\Support\Facades\Route;

Route::get('/seans', [SeansApiController::class, 'index']);
Route::get('/seans/{id}', [SeansApiController::class, 'show']);

Route::get('/klient', [KlientApiController::class, 'index']);
Route::get('/klient/{id}', [KlientApiController::class, 'show']);

Route::get('/usluga', [UslugaApiController::class, 'index']);
Route::get('/usluga/{id}', [UslugaApiController::class, 'show']);
