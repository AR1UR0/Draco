<?php

namespace App\Http\Controllers; // Asegúrate de que esta línea esté presente

use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

/**
 * Clase MailController
 * * Controlador especializado en la gestión de comunicaciones vía email.
 * Actúa como un servicio para el envío de notificaciones transaccionales,
 * permitiendo la integración de envíos de correo mediante peticiones HTTP.
 * @author Marta
 */
class MailController extends Controller
{

    /**
     * Procesa el envío manual de correos de registro.
     * * Este método permite disparar el envío del 'RegisterMail' de forma independiente.
     * Incluye una capa de validación manual de datos y una gestión de excepciones
     * para capturar fallos en el protocolo SMTP o configuración del servidor.
     * * @param  \Illuminate\Http\Request  $request Objeto con el 'email' y 'name' del destinatario.
     * @return \Illuminate\Http\JsonResponse Respuesta en formato JSON con el estado de la operación.
     * @author Marta
     */
    public function register(Request $request)
    {
        if (!$request->has('email') || !$request->has('name')) {
            return response()->json(['error' => 'Datos insuficientes'], 400);
        }

        /**
         * Ejecución del envío mediante el Facade Mail
         * Se implementa un bloque try-catch para gestionar la comunicación
         * con el servidor de correo externo.
         * @author Marta
         */
        try {
            Mail::to($request->email)
                ->send(new RegisterMail($request->name));

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}