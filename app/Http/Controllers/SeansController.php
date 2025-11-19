<?php

namespace App\Http\Controllers;

use App\Models\Seans;
use App\Models\Klient;
use App\Models\Kosmetolog;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;



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
        $seans = Seans::find($id);

        if (! Gate::allows('edit-expensive-seans', $seans)) {
            return redirect('/error')->with('msg', 'Редактировать можно только записи дороже 1000 руб!');
        }

        return view('seans.edit', compact('seans'));
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
        $seans = Seans::find($id);

        if (! Gate::allows('delete-seans', $seans)) {
            return redirect('/error')->with('msg', 'Удалять записи может только администратор!');
        }

        $seans->delete();
        return redirect('/seans');
    }



}
