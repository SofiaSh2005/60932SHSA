<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return view('hello', ['title' => 'Hello World!']);
});

use App\Http\Controllers\KlientController;
use App\Http\Controllers\KosmetologController;
use App\Http\Controllers\UslugaController;
use App\Http\Controllers\OkazannayaUslugaController;

use App\Http\Controllers\SeansController;

Route::get('/klient', [KlientController::class, 'index']);
Route::get('/kosmetolog', [KosmetologController::class, 'index']);
Route::get('/usluga', [UslugaController::class, 'index']);
Route::get('/okazannaya_usluga', [OkazannayaUslugaController::class, 'index']);



Route::get('/seans', [SeansController::class, 'index'])->name('seans.index');
Route::get('/seans/create', [SeansController::class, 'create'])->name('seans.create')->middleware('auth');
Route::post('/seans', [SeansController::class, 'store'])->name('seans.store');
Route::get('/seans/edit/{id}', [SeansController::class, 'edit'])->name('seans.edit')->middleware('auth');
Route::post('/seans/update/{id}', [SeansController::class, 'update'])->name('seans.update')->middleware('auth');
Route::get('/seans/delete/{id}', [SeansController::class, 'destroy'])->name('seans.destroy')->middleware('auth');


Route::get('/login', [LoginController::class, 'login']) -> name("login");
Route::post('/auth', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/error', function () {
    return view('error');
});



