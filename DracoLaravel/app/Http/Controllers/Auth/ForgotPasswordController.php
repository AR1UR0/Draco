<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function sendResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Email no encontrado'], 404);
        }

        $token = Str::random(64);

        // Guardar token en DB (ejemplo en tabla password_resets)
        \DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        $url = url('/reset-password?token=' . $token . '&email=' . $user->email);

        Mail::to($user->email)->send(new ResetPasswordMail($user->name, $url));

        return response()->json(['success' => 'Correo enviado satisfactoriamente']);
    }
}
