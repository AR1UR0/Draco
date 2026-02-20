<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Test
 * * Representa un cuestionario o nivel específico dentro de una temática.
 * Este modelo organiza las preguntas en bloques lógicos y permite establecer
 * un orden secuencial de aprendizaje para el usuario.
 * * @author Marta
 */
class Test extends Model
{
    /**
     * @var string Nombre de la tabla asociada en la base de datos.
     */
    protected $table = 'tests';

    /**
     * @var array Atributos habilitados para la asignación masiva.
     * 'order' permite clasificar los tests para que aparezcan en una secuencia determinada.
     */
    protected $fillable = ['title', 'order', 'tematica_id']; 

    /**
     * Relación Directa (Muchos a Uno): Cada Test pertenece a una única Temática.
     * * Permite acceder a los datos de la categoría superior (ej: Saber que el
     * test "Gondor" pertenece a la temática "El Señor de los Anillos").
     * * @author Marta
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tematica()
    {
        return $this->belongsTo(Tematica::class, 'tematica_id');
    }

    /**
     * Relación Inversa (Uno a Muchos): Un Test contiene múltiples preguntas.
     * * Es la relación principal utilizada por el PreguntaController para cargar
     * el contenido de los test.
     * * @author Marta
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'test_id');
    }
}