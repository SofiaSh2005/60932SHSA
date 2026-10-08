<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Klient;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Валидация
        $fields = $request->validate([
            'telefon' => 'required|string',
            'password' => 'required|string'
        ]);

        // Проверка пользователя
        $user = User::where('telefon', $fields['telefon'])->first();

        if (!$user) {
            return response(['message' => 'Пользователь с таким телефоном не найден'], 401);
        }

        // Проверка пароля
        if (!Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Неверный пароль'], 401);
        }

        // Создание токена
        $token = $user->createToken('myapptoken')->plainTextToken;

        // Ответ
        $response = [
            'user' => $user->load('klient'),
            'token' => $token
        ];
        return response($response, 201);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'fio' => 'required|string|max:255',
            'telefon' => 'required|string|max:30|unique:users,telefon',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = DB::transaction(function () use ($validated) {
            $klient = Klient::firstOrCreate(
                ['telefon' => $validated['telefon']],
                ['fio' => $validated['fio']]
            );

            return User::create([
                'name' => $validated['fio'],
                'telefon' => $validated['telefon'],
                'email' => preg_replace('/\D+/', '', $validated['telefon']) . '@local.salon',
                'password' => $validated['password'],
                'role' => 'user',
                'klient_id' => $klient->id,
            ]);
        });

        return response()->json([
            'user' => $user->load('klient'),
            'token' => $user->createToken('salon')->plainTextToken,
        ], 201);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'fio' => 'required|string|max:255',
            'telefon' => ['required', 'string', 'max:30', Rule::unique('users', 'telefon')->ignore($user->id)],
        ]);

        DB::transaction(function () use ($user, $validated) {
            $user->update(['name' => $validated['fio'], 'telefon' => $validated['telefon']]);
            $user->klient?->update(['fio' => $validated['fio'], 'telefon' => $validated['telefon']]);
        });

        return response()->json($user->fresh()->load('klient'));
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response(['message' => 'Logged out']);
    }

}
