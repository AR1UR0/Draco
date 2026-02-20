<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Respuesta
 * * Representa las posibles opciones de contestación para cada pregunta del sistema.
 * Este modelo permite determinar la validez de las elecciones del usuario y soporta
 * diversos formatos de respuesta (texto, imagen o audio) para enriquecer la experiencia.
 * * @author Marta
 */
class Respuesta extends Model
{

    /**
     * @var string Nombre de la tabla en la base de datos.
     */
    protected $table = 'respuestas';

    /**
     * @var array Atributos habilitados para asignación masiva.
     * 'is_correct' es el campo booleano crítico para la lógica de corrección del TestController.
     */
    protected $fillable = ['opcion', 'is_correct', 'pregunta_id', 'image', 'audio'];

    /**
     * Relación Inversa (Muchos a Uno): Cada respuesta pertenece a una única pregunta.
     * * @author Marta
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id');
    }
}

