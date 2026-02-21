<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;


/**
* TrimStrings Class
* This middleware handles the normalization of input data.
* Its function is to automatically remove accidental whitespace
* from the beginning and end of text strings submitted through forms.
* @author Marta
*/
class TrimStrings extends Middleware
{
    /**
    * List of attributes that should not be truncated.
    * * Certain fields, such as passwords, should not be altered, as the
    * spaces may be an intentional part of the security key.
    * * @author Marta
    * @var array<int, string>
    */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
