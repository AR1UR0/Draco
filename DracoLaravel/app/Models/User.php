<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',           // Antes era 'nombre'
        'email',          
        'password',       
        'role_id',        
        'points',         // Antes era 'dinero' 
        'experience',      // antes experiencia
        'streak',         // Antes era 'racha' 
        'current_lives',  // Antes era 'vidas_actuales'
        'max_lives',      // Antes era 'vidas_max'
        'last_life_recovery', // Antes era 'last_life_recovery_at' 
        'profile_image',  // Antes era 'imagen_usuario' 
        'last_streak_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_life_recovery' => 'datetime',
        'last_streak_at' => 'datetime',
    ];

    // Relación con el nuevo modelo Role [cite: 282, 431]
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relación con los nuevos resultados de tests [cite: 298, 473]
    public function results()
    {
        return $this->hasMany(UserTestResult::class);
    }

    // Relación con el inventario de la tienda [cite: 304, 488]
    public function inventory()
    {
        return $this->belongsToMany(Item::class, 'user_inventory')
                    ->withPivot('quantity', 'expires_at')
                    ->withTimestamps();
    }
    
    protected static function boot()
{
    parent::boot();

    static::saving(function ($user) {
        // La clave está aquí: ¿Ha cambiado la experiencia? 
        // Si solo estamos comprando vidas, la experiencia NO cambia, por lo tanto no regala monedas.
        if ($user->isDirty('experience')) {
            
            $xpAntigua = $user->getOriginal('experience') ?? 0;
            $xpNueva = $user->experience;

            $bloquesAntiguos = floor($xpAntigua / 10);
            $bloquesNuevos = floor($xpNueva / 10);

            if ($bloquesNuevos > $bloquesAntiguos) {
                $nuevosBloques = $bloquesNuevos - $bloquesAntiguos;
                $monedasAGanar = $nuevosBloques * 5;
                
                $user->points += $monedasAGanar;
                \Log::info("Canje XP activado: +{$monedasAGanar} monedas.");
            }
        }
    });
}
}