<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Gestiona el intento de inicio de sesión.
     */
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // OPCIÓN A: Si quieres que TODOS vayan a la misma página principal
        return redirect()->intended(route('pagPrincipal'));
/*
        //* OPCIÓN B: Por si quieres diferenciar (Admin vs Usuario)
        if (Auth::user()->role_id == 1) {
            return redirect()->intended('/admin');
        }
        return redirect()->intended('/pag-principal'); 
*/
    }

    return back()->withErrors([
        'email' => 'Las credenciales no coinciden con nuestros registros.',
    ])->onlyInput('email');
}

    /**
     * Cerrar sesión.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}