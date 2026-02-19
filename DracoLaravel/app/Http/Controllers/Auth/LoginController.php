<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        // Diferenciar Admin vs Usuario al entrar
        if (Auth::user()->role_id == 1) {
            return redirect()->intended(route('admin')); // Va directo al panel
        }
        
        return redirect()->intended(route('pagPrincipal')); // Usuario normal va a aprender
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

        return redirect()->route('index');
    }



    public function sendTempPassword(Request $request)
    {
        // Chivato 1: ¿Llegan los datos?
    \Log::info("Intento de recuperación para: " . $request->email);

        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            \Log::info("Usuario no encontrado en la DB");
            return back()->withErrors(['email' => 'No encontramos ningún usuario con ese correo.']);
        }
        \Log::info("Usuario encontrado: " . $user->name);

        // 1. Generar contraseña temporal de 8 caracteres
        $tempPassword = Str::random(8);

        // 2. Actualizar en la base de datos
        $user->password = Hash::make($tempPassword);
        $user->save();

        // 3. Enviar el correo (usaremos una clase nueva o una simple)
        try {
            Mail::send('emails.forgot', ['name' => $user->name, 'password' => $tempPassword], function($message) use ($user) {
                $message->to($user->email);
                $message->subject('Tu nueva contraseña de Draco');
            });
            
            return back()->with('success', 'Te hemos enviado una nueva contraseña a tu correo.');
        } catch (\Exception $e) {
            \Log::error("Error recuperación: " . $e->getMessage());
            return back()->withErrors(['email' => 'Error al enviar el correo. Inténtalo más tarde.']);
        }
    }

}