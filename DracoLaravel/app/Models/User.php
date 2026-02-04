<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'role_id',
        'dinero',
        'racha',
        'experiencia',
        'vidas_actuales',
        'vidas_max',
        'imagen_usuario',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_life_recovery_at' => 'datetime',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'role_id');
    }

    public function progresos()
    {
        return $this->hasMany(Progreso::class, 'user_id');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'user_id');
    }
}
