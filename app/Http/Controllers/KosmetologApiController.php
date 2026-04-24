<?php

namespace App\Http\Controllers;

use App\Models\Kosmetolog;

class KosmetologApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Kosmetolog::with('seanss')->get()
        );
    }
}
