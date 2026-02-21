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
* LoginController Class
* * Handles user authentication, session control,
* role-based redirection, and password recovery.
* @author Marta
*/
class LoginController extends Controller
{
    /**
    * Manages the user authentication process.
    * Validates the entered credentials, regenerates the session to prevent
    * fixation attacks, and redirects the user according to their role:
    * - Administrator (role_id = 1) -> Administration Panel.
    * - User (role_id = 2) -> Main Topics Page.
    * @param \Illuminate\Http\Request $request Object with the form data.
    * @return \Illuminate\Http\RedirectResponse Redirect to the corresponding path or error.
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
    * Closes the user's active session.
    * * Removes authentication information, invalidates the session on the server
    * and regenerates the CSRF token to ensure a secure closure.
    * * @param \Illuminate\Http\Request $request Object of the current request.
    * @return \Illuminate\Http\RedirectResponse Redirects to the landing page.
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
    * Manages access recovery using a temporary password.
    * 1. Verifies the user exists in the database.
    * 2. Generates a random 8-character string.
    * 3. Encrypts and updates the password in the database.
    * 4. Sends the new password via email using the Mail facade.
    * @param \Illuminate\Http\Request $request Object containing the user's email address.
    * @return \Illuminate\Http\RedirectResponse Success or error notification.
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