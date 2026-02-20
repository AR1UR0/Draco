<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Role
 * * Gestiona los diferentes niveles de acceso y permisos dentro de la plataforma.
 * Este modelo es la base del sistema de Control de Acceso Basado en Roles (RBAC),
 * permitiendo segmentar las funcionalidades entre usuarios estándar y administradores.
 * * @author Marta
 */
class Role extends Model 
{
    /**
     * @var array Atributos habilitados para la asignación masiva.
     * El campo 'name' suele almacenar valores como 'admin' o 'user'.
     */
    protected $fillable = ['name']; 

    /**
     * Relación Directa (Uno a Muchos): Un rol puede estar asignado a múltiples usuarios.
     * * Esta relación permite, por ejemplo, obtener de forma sencilla todos los
     * usuarios que poseen privilegios de administrador.
     * * @author Marta
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
