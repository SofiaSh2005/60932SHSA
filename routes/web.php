<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return view('hello', ['title' => 'Hello World!']);
});

use App\Http\Controllers\KlientController;
use App\Http\Controllers\KosmetologController;
use App\Http\Controllers\SeansController;
use App\Http\Controllers\UslugaController;
use App\Http\Controllers\OkazannayaUslugaController;

Route::get('/klient', [KlientController::class, 'index']);
Route::get('/kosmetolog', [KosmetologController::class, 'index']);
Route::get('/seans', [SeansController::class, 'index']);
Route::get('/usluga', [UslugaController::class, 'index']);
Route::get('/okazannaya_usluga', [OkazannayaUslugaController::class, 'index']);
