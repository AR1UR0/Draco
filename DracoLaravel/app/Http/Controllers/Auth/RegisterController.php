<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Muestra la vista del formulario
    public function showRegistrationForm()
    {
        return view('auth.registro'); // Asegúrate de que tu vista esté en resources/views/auth/registro.blade.php
    }

    // Procesa el registro
    public function register(Request $request)
    {
        // 1. Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Crear el usuario en la BD
        $user = User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptar contraseña
            'role_id' => 2, // ID de usuario normal
            'dinero' => 0,
            'racha' => 0,
            'experiencia' => 0,
            'vidas_actuales' => 5, // Empezamos con 5 vidas
            'vidas_max' => 5,
        ]);

        // 3. Loguear automáticamente al usuario
        Auth::login($user);

        // 4. Redirigir a la página principal con el mensaje de oferta (vuestro requisito)
        return redirect()->route('pagPrincipal')->with('oferta_plus', true);
    }
}
