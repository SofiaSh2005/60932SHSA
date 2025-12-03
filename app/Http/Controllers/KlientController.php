<?php

namespace App\Http\Controllers;

use App\Models\Klient;
use Illuminate\Http\Request;

class KlientController extends Controller
{
    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 2;

        return view('klient.index', [
            'klients' => Klient::with('seanss')->paginate($perpage)->withQueryString(),
            'perpage' => $perpage
        ]);
    }


}
