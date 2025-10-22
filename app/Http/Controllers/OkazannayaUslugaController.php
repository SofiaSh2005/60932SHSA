<?php

namespace App\Http\Controllers;

use App\Models\OkazannayaUsluga;

class OkazannayaUslugaController extends Controller
{
    public function index()
    {
        // Загружаем все оказанные услуги с их связями
        $okazannyeUslugi = OkazannayaUsluga::with(['seans.klient', 'seans.kosmetolog', 'usluga'])->get();

        // Передаём в Blade-файл
        return view('okazannaya_usluga.index', compact('okazannyeUslugi'));
    }
}
