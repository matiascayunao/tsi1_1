<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validación básica
        $credenciales = $request->validate([
            'rut' => 'required|string',
            'password' => 'required|string',
        ]);

        // Intento de login
        $ok = Auth::attempt([
            'rut' => $credenciales['rut'],
            'password' => $credenciales['password'],
        ], false); // false = sin "remember me"

        // Log de diagnóstico (mira storage/logs/laravel.log si algo falla)
        Log::info('Intento login', ['rut' => $credenciales['rut'], 'ok' => $ok]);

        if ($ok) {
            $request->session()->regenerate(); // MUY IMPORTANTE
            return redirect()->intended(route('home.index'))
                   ->with('success', 'Sesión iniciada como ' . Auth::user()->rol);
        }

        return back()->withErrors(['rut' => 'RUT o contraseña incorrectos.'])
                     ->onlyInput('rut');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home.index');
    }
}
