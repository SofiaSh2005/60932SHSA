<?php

namespace App\Http\Controllers;

use App\Models\Usluga;

class UslugaController extends Controller
{
    public function index()
    {
        $uslugas = Usluga::with('seans')->get();
        return view('usluga.index', compact('uslugas'));
    }

}
