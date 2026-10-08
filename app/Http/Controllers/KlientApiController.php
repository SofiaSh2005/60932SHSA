<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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

    public function total(Request $request)
    {
        return response()->json(
            Klient::where('fio', 'LIKE', '%' . ($request->search ?? '') . '%')->count()
        );
    }

    public function destroy(string $id)
    {
        abort_unless(request()->user()->isAdmin(), 403, 'Доступно только администратору');
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

        DB::transaction(function () use ($klient) {
            $klient->user?->delete();
            $klient->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Клиент успешно удалён'
        ]);
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->isAdmin(), 403, 'Доступно только администратору');
        try {
            $validated = $request->validate([
                'fio' => 'required|max:255',
                'telefon' => 'required|max:30|unique:users,telefon',
                'password' => 'required|string|min:6',
            ]);

            [$klient, $user] = DB::transaction(function () use ($validated) {
                $klient = Klient::create([
                    'fio' => $validated['fio'],
                    'telefon' => $validated['telefon'],
                ]);

                $user = User::create([
                    'name' => $validated['fio'],
                    'telefon' => $validated['telefon'],
                    'email' => preg_replace('/\D+/', '', $validated['telefon']) . '@local.salon',
                    'password' => $validated['password'],
                    'role' => 'user',
                    'klient_id' => $klient->id,
                ]);

                return [$klient, $user];
            });

            return response()->json([
                'code' => 0,
                'message' => 'Клиент создан',
                'data' => $klient,
                'user' => $user,
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
        abort_unless($request->user()->isAdmin(), 403, 'Доступно только администратору');
        try {
            $klient = Klient::findOrFail($id);
            $validated = $request->validate([
                'fio' => 'required|max:255',
                'telefon' => ['required', 'max:30', Rule::unique('users', 'telefon')->ignore($klient->user?->id)],

            ]);

            $klient->fio = $validated['fio'];
            $klient->telefon = $validated['telefon'] ?? null;


            $klient->save();
            $klient->user?->update(['name' => $validated['fio'], 'telefon' => $validated['telefon']]);

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
