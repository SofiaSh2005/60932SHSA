<?php

namespace App\Http\Controllers;

use App\Models\Seans;
use App\Models\Klient;
use App\Models\Kosmetolog;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class SeansController extends Controller
{
    public function index()
    {
        $seansy = Seans::with(['klient', 'kosmetolog'])->get();
        return view('seans.index', compact('seansy'));
    }

    public function create()
    {
        $klients = Klient::all();
        $kosmetologs = Kosmetolog::all();
        return view('seans.create', compact('klients', 'kosmetologs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'klient_id' => 'required|exists:klient,id',
            'kosmetolog_id' => 'required|exists:kosmetolog,id',
            'data_vremya' => 'required|date'
        ]);

        Seans::create($validated);

        return redirect()->route('seans.index')->with('success', 'Сеанс успешно добавлен!');
    }

    public function edit($id)
    {
        $seans = Seans::findOrFail($id);
        $klients = Klient::all();
        $kosmetologs = Kosmetolog::all();
        return view('seans.edit', compact('seans', 'klients', 'kosmetologs'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'klient_id' => 'required|exists:klient,id',
            'kosmetolog_id' => 'required|exists:kosmetolog,id',
            'data_vremya' => 'required|date'
        ]);

        $seans = Seans::findOrFail($id);
        $seans->update($validated);

        return redirect()->route('seans.index')->with('success', 'Сеанс обновлён!');
    }

    public function destroy($id)
    {
        Seans::destroy($id);
        return redirect()->route('seans.index')->with('success', 'Сеанс удалён.');
    }

}
