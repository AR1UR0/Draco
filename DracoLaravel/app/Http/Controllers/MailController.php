<?php

namespace App\Http\Controllers; 

use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

/**
* MailController Class
* * A controller specialized in managing email communications.
* It acts as a service for sending transactional notifications,
* allowing the integration of email sending via HTTP requests.
* @author Marta
*/
class MailController extends Controller
{

    /**
    * Processes the manual sending of registration emails.
    * This method allows triggering the sending of the 'RegisterMail' independently.
    * Includes a manual data validation layer and exception handling
    * to capture SMTP protocol failures or server configuration issues.
    * @param \Illuminate\Http\Request $request Object containing the recipient's email and name.
    * @return \Illuminate\Http\JsonResponse Response in JSON format with the operation status.
    * @author Marta
    */
    public function register(Request $request)
    {
        if (!$request->has('email') || !$request->has('name')) {
            return response()->json(['error' => 'Datos insuficientes'], 400);
        }

        /**
        * Sending the email using Facade Mail
        * A try-catch block is implemented to manage communication
        * with the external mail server.
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