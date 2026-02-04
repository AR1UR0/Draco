<?php

namespace App\Http\Controllers; // Asegúrate de que esta línea esté presente

use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function register(Request $request)
    {
        // Validación básica para evitar errores si los datos no llegan
        if (!$request->has('email') || !$request->has('name')) {
            return response()->json(['error' => 'Datos insuficientes'], 400);
        }

        try {
            Mail::to($request->email)
                ->send(new RegisterMail($request->name));

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            // Esto te dirá el error real de SMTP en el log
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}