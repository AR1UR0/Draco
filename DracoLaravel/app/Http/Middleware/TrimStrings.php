<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;


/**
 * Clase TrimStrings
 * * Este middleware se encarga de la normalización de los datos de entrada.
 * Su función es eliminar automáticamente los espacios en blanco accidentales 
 * al inicio y al final de las cadenas de texto enviadas a través de formularios.
 * * @author Marta
 */
class TrimStrings extends Middleware
{
    /**
     * Lista de atributos que no deben ser recortados.
     * * Ciertos campos, como las contraseñas, no deben ser alterados, ya que los 
     * espacios en blanco pueden formar parte intencionada de la clave de seguridad.
     * * @author Marta
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
