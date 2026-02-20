<?php

namespace App\Http\Controllers\Auth;
use App\Mail\RegisterMail;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Clase RegisterController
 * * Gestiona la creación de nuevas cuentas de usuario, la asignación de valores iniciales
 * de gamificación (puntos, vidas, experiencia) y el envío de correos de bienvenida.
 * @author Marta
 */
class RegisterController extends Controller
{
    /**
     * Muestra la interfaz de registro de usuario.
     * * @return \Illuminate\View\View Vista del formulario de registro.
     * @author Marta
     */
    public function showRegistrationForm()
    {
        return view('auth.registro'); 
    }

    /**
     * Procesa la solicitud de registro de un nuevo usuario.
     * * El proceso sigue estos pasos:
     * 1. Validación de integridad de datos (email único y contraseña confirmada).
     * 2. Persistencia en base de datos con valores iniciales de sistema.
     * 3. Notificación vía Email mediante la clase Mailable 'RegisterMail'.
     * 4. Autenticación automática y redirección con disparador de eventos (oferta_plus).
     * * @param  \Illuminate\Http\Request  $request Datos del formulario de registro.
     * @return \Illuminate\Http\RedirectResponse Redirección a la página principal.
     * @author Marta
     */
    public function register(Request $request)
{

    $request->validate([
        'name' => 'required|string|max:255', 
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name'           => $request->name,
        'email'          => $request->email,
        'password'       => Hash::make($request->password),
        'role_id'        => 2, 
        'points'         => 100, 
        'streak'         => 1, 
        'last_streak_at' => now(),
        'experience'     => 0, 
        'current_lives'  => 7, 
        'max_lives'      => 7, 
    ]);

    /**
    * Lógica de Envío de Email de Bienvenida
    * Se utiliza un bloque try-catch para asegurar que un fallo en el servidor
    * de correo no interrumpa el flujo de registro del usuario.
    * @author Marta
    */
    try {
        Mail::to($user->email)->send(new RegisterMail($user->name));
    } catch (\Exception $e) {
        \Log::error("Error enviando mail: " . $e->getMessage());
    }

    Auth::login($user);
    return redirect()->route('pagPrincipal')->with('oferta_plus', true);
}
}
