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

* RegisterController Class
* Manages the creation of new user accounts, the assignment of initial gamification values ​​(points, lives, experience), and the sending of welcome emails.
* @author Marta
*/
class RegisterController extends Controller
{
    /**
    * Displays the user registration interface.
    * @return \Illuminate\View\View Registration form view.
    * @author Marta
    */
    public function showRegistrationForm()
    {
        return view('auth.registro'); 
    }

    /**
    * Processes a new user registration request.
    * The process follows these steps:
    * 1. Data integrity validation (unique email and confirmed password).
    * 2. Database persistence with system defaults.
    * 3. Email notification using the Mailable class 'RegisterMail'.
    * 4. Automatic authentication and redirection with an event trigger (oferta_plus).
    * @param \Illuminate\Http\Request $request Registration form data.
    * @return \Illuminate\Http\RedirectResponse Redirection to the homepage.
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
    * Welcome Email Sending Logic
    * A try-catch block is used to ensure that a mail server failure does not interrupt the user registration flow.
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
