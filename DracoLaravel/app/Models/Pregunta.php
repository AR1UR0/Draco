<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Pregunta
 * * Representa la entidad de una pregunta dentro del sistema de evaluación de DRACO.
 * Este modelo actúa como el núcleo de los contenidos, vinculando cada enunciado 
 * con un test específico y con sus múltiples opciones de respuesta.
 * * @author Marta
 */
class Pregunta extends Model
{

    /**
     * @var string Nombre de la tabla asociada en la base de datos.
     */
    protected $table = 'preguntas';

    /**
     * @var array Atributos habilitados para la asignación masiva (Mass Assignment).
     * Incluye el enunciado, los puntos de recompensa, el ID del test y el archivo de audio opcional.
     */
    protected $fillable = ['enunciado', 'reward_points', 'test_id', 'audio']; 

    /**
     * Relación Directa (Muchos a Uno): Cada pregunta pertenece a un único Test.
     * * @author Marta
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    /**
     * Relación Inversa (Uno a Muchos): Una pregunta posee varias respuestas.
     * * @author Marta
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'pregunta_id');
    }
}

