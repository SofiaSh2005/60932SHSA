<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Models\Klient;

class KlientApiController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Klient::limit($request->perpage ?? 5)
                ->offset(($request->perpage ?? 5) * ($request->page ?? 0))
                ->where('fio', 'LIKE', '%' . $request->search . "%")
                ->get()
        );
    }

    public function total()
    {
        return response()->json(Klient::count());
    }

    public function destroy(string $id)
    {
        $klient = Klient::find($id);

        if (!$klient) {
            return response()->json([
                'success' => false,
                'message' => 'Клиент не найден'
            ], 404);
        }

        if ($klient->seans()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Нельзя удалить клиента, у которого есть сеансы'
            ], 409);
        }

        $klient->delete();

        return response()->json([
            'success' => true,
            'message' => 'Клиент успешно удалён'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'fio' => 'required|max:255',
                'telefon' => 'nullable|max:50',
            ]);

            $klient = Klient::create($validated);

            return response()->json([
                'code' => 0,
                'message' => 'Клиент создан',
                'data' => $klient
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'code' => 2,
                'message' => 'Ошибка создания',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {


        try {
            $validated = $request->validate([
                'fio' => 'required|max:255',
                'telefon' => 'nullable|max:50',
                'image' => 'nullable|image|max:2048',
            ]);

            $klient = Klient::findOrFail($id);

            $klient->fio = $validated['fio'];
            $klient->telefon = $validated['telefon'] ?? null;

            if ($request->hasFile('image')) {

                $path = $request->file('image')->store('klient', 's3');

                $klient->picture_url = Storage::disk('s3')->url($path);
            }

            $klient->save();

            return response()->json([
                'code' => 0,
                'message' => 'Клиент обновлён',
                'data' => $klient
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'code' => 2,
                'message' => 'Ошибка обновления',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        return response()->json(Klient::findOrFail($id));
    }
}
