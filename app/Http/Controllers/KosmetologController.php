<?php

namespace App\Http\Controllers;

use App\Models\Kosmetolog;

class KosmetologController extends Controller
{
    public function index()
    {
        $kosmetologs = Kosmetolog::with('seanss')->get();
        return view('kosmetolog.index', compact('kosmetologs'));
    }
}
