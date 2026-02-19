<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function sendResetEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email no encontrado');
        }

        $token = Str::random(64);

        $url = url('/reset-password?token=' . $token . '&email=' . $user->email);

        Mail::to($user->email)->send(
            new ResetPasswordMail($user->name, $url)
        );

        return back()->with('success', 'Correo enviado');
    }
}
