<?php

namespace App\Http\Controllers;

use App\Models\OkazannayaUsluga;

class OkazannayaUslugaController extends Controller
{
    public function index()
    {

        $okazannyeUslugi = OkazannayaUsluga::with(['seans.klient', 'seans.kosmetolog', 'usluga'])->get();


        return view('okazannaya_usluga.index', compact('okazannyeUslugi'));
    }
}
