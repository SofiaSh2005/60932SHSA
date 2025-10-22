<?php

namespace App\Http\Controllers;

use App\Models\Klient;

class KlientController extends Controller
{
    public function index()
    {
        // Получаем всех клиентов с их сеансами
        $klients = Klient::with('seanss')->get();
        return view('klient.index', compact('klients'));
    }
}

