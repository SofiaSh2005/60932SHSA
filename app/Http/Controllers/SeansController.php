<?php

namespace App\Http\Controllers;

use App\Models\Seans;

class SeansController extends Controller
{
    public function index()
    {
        $seanss = Seans::with(['klient', 'kosmetolog', 'uslugis'])->get();
        return view('seans.index', compact('seanss'));
    }

}
