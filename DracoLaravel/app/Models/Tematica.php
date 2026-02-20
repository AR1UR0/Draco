<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Tematica
 * * Representa las categorías principales de contenido de la plataforma (ej: Mitología, Star Wars).
 * Este modelo actúa como la entidad de nivel superior en la jerarquía de conocimientos,
 * agrupando los diferentes tests bajo un contexto temático común.
 * * @author Marta
 */
class Tematica extends Model
{

    /**
     * @var string Nombre de la tabla en la base de datos.
     */
    protected $table = 'tematicas';

    /**
     * @var array Atributos habilitados para asignación masiva.
     * Incluye metadatos visuales (image) y estados de disponibilidad (is_active).
     */
    protected $fillable = ['name', 'description', 'image', 'is_active']; 

    /**
     * Relación Directa (Uno a Muchos): Una temática engloba múltiples tests.
     * * Esta relación permite que, al seleccionar una temática en la interfaz, 
     * el sistema recupere automáticamente todos los niveles o cuestionarios asociados.
     * * @author Marta
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tests()
    {
        return $this->hasMany(Test::class, 'tematica_id');
    }
    
    
}