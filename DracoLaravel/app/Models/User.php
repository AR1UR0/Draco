<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Clase User
 * * Representa a los usuarios de la plataforma DRACO. Esta clase gestiona tanto 
 * la autenticación y seguridad como el núcleo del sistema de gamificación: 
 * puntos (monedas), experiencia, vidas y rachas.
 * * @author Marta
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @var array Atributos habilitados para la asignación masiva.
     * Incluye campos de perfil, credenciales y variables de estado del juego.
     */
    protected $fillable = [
        'name',           
        'email',          
        'password',       
        'role_id',        
        'points',         
        'experience',      
        'streak',          
        'current_lives',  
        'max_lives',      
        'last_life_recovery', 
        'profile_image',  
        'last_streak_at',
    ];

    /**
     * @var array Atributos que deben permanecer ocultos en las serializaciones (JSON).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array Conversión de tipos de atributos (Casting).
     * Asegura que las fechas se traten como objetos Carbon y las contraseñas se gestionen como hashes.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_life_recovery' => 'datetime',
        'last_streak_at' => 'datetime',
    ];

    /**
     * Relación con el Rol de Usuario.
     * Determina los permisos del usuario dentro de la plataforma (Admin/User).
     * * @author Marta
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relación con los resultados de los tests.
     * Almacena el historial de desempeño del usuario en los diferentes cuestionarios.
     * * @author Marta
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany(UserTestResult::class);
    }

    /**
     * Relación con el inventario de la tienda.
     * Permite gestionar los objetos comprados mediante una tabla pivote que 
     * almacena cantidad y fechas de expiración.
     * * @author Marta
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inventory()
    {
        return $this->belongsToMany(Item::class, 'user_inventory')
                    ->withPivot('quantity', 'expires_at')
                    ->withTimestamps();
    }

    /**
     * Método Boot del Modelo.
     * * Implementa un "Observer" mediante el evento 'saving'. Esta lógica detecta cambios 
     * en la experiencia del usuario. Por cada bloque de 10 puntos de XP ganados, 
     * el sistema otorga automáticamente 5 monedas (points).
     * * @author Marta
     * @return void
     */
    protected static function boot()
{
    parent::boot();

    static::saving(function ($user) {
        // Lógica de Recompensa Automática:
        // Se comprueba si el atributo 'experience' ha sido modificado (isDirty).
        if ($user->isDirty('experience')) {
            
            $xpAntigua = $user->getOriginal('experience') ?? 0;
            $xpNueva = $user->experience;

            // Cálculo de bloques de nivel (1 bloque = 10 XP)
            $bloquesAntiguos = floor($xpAntigua / 10);
            $bloquesNuevos = floor($xpNueva / 10);

            // Si el usuario cruza el umbral de un nuevo bloque, recibe monedas.
            if ($bloquesNuevos > $bloquesAntiguos) {
                $monedasAGanar = ($bloquesNuevos - $bloquesAntiguos) * 5;
                $user->points += $monedasAGanar;
            }
        }
    });
}
}