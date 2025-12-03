<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show() //возвращает страницу login.blade.php.
    {
        return view('usluga');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([ //Валидация данных,
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('usluga')->withErrors([
                'success' => 'Вы успешно вошли в систему'
            ]);
        }

        return back()->withErrors([
            'error' => 'Неверный email или пароль.',
        ])->onlyInput('email');
    }



    public function login(Request $request)
    {
        return redirect('/seans')->withErrors([
            'success' => 'Вы не вошли в систему, заполните форму входа!',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/usluga')->withErrors([
            'success' => 'Вы успешно вышли из системы',
        ]);
    }
}
