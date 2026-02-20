<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Clase LoginController
 * * Se encarga de gestionar la autenticación de usuarios, el control de sesiones,
 * la redirección basada en roles y la recuperación de contraseñas.
 * @author Marta
 */ 
class LoginController extends Controller
{
    /**
     * Gestiona el proceso de autenticación del usuario.
     * * Valida las credenciales introducidas, regenera la sesión para evitar
     * ataques de fijación y redirige al usuario según su rol:
     * - Administrador (role_id = 1) -> Panel de Administración.
     * - Usuario (role_id = 2) -> Página Principal de temáticas.
     * * @param  \Illuminate\Http\Request  $request Objeto con los datos del formulario.
     * @return \Illuminate\Http\RedirectResponse Redirección a la ruta correspondiente o error.
     * @author Marta
     */
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        if (Auth::user()->role_id == 1) {
            return redirect()->intended(route('admin')); 
        }
        return redirect()->intended(route('pagPrincipal')); 
    }

    return back()->withErrors([
        'email' => 'Las credenciales no coinciden con nuestros registros.',
    ])->onlyInput('email');
}

    /**
     * Cierra la sesión activa del usuario.
     * * Elimina la información de autenticación, invalida la sesión en el servidor
     * y regenera el token CSRF para garantizar un cierre seguro.
     * * @param  \Illuminate\Http\Request  $request Objeto de la petición actual.
     * @return \Illuminate\Http\RedirectResponse Redirección a la landing page.
     * @author Marta
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }

    /**
     * Gestiona la recuperación de acceso mediante contraseña temporal.
     * * 1. Verifica la existencia del usuario en la base de datos.
     * 2. Genera una cadena aleatoria de 8 caracteres.
     * 3. Encripta y actualiza la contraseña en la base de datos.
     * 4. Envía la nueva clave por correo electrónico utilizando la fachada Mail.
     * * @param  \Illuminate\Http\Request  $request Objeto con el email del usuario.
     * @return \Illuminate\Http\RedirectResponse Notificación de éxito o error.
     * @author Marta
     */
    public function sendTempPassword(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            \Log::info("Usuario no encontrado en la DB");
            return back()->withErrors(['email' => 'No encontramos ningún usuario con ese correo.']);
        }

        $tempPassword = Str::random(8);
        $user->password = Hash::make($tempPassword);
        $user->save();

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