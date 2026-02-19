<?php

namespace App\Http\Controllers\Auth;
use App\Mail\RegisterMail;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
    // 1. Validar los datos (usando 'name' en lugar de 'nombre')
    $request->validate([
        'name' => 'required|string|max:255', 
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // 2. Crear el usuario en la BD con los nombres en INGLÉS
    $user = User::create([
        'name'           => $request->name,
        'email'          => $request->email,
        'password'       => Hash::make($request->password),
        'role_id'        => 2, // Usuario normal
        'points'         => 100, // Antes 'dinero'
        'streak'         => 1, // Antes 'racha'
        'last_streak_at' => now(),
        'experience'     => 0, // Antes 'experiencia'
        'current_lives'  => 7, // Antes 'vidas_actuales'
        'max_lives'      => 7, // Antes 'vidas_max'
    ]);

    // ENVÍO DEL MAIL
    try {
        Mail::to($user->email)->send(new RegisterMail($user->name));
    } catch (\Exception $e) {
        // Logueamos el error por si falla, pero dejamos que el usuario entre a la web
        \Log::error("Error enviando mail: " . $e->getMessage());
    }

    // 3. Loguear y redirigir
    Auth::login($user);
    return redirect()->route('pagPrincipal')->with('oferta_plus', true);
}
}
