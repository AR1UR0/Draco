<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
* User Class
* * Represents the users of the DRACO platform. This class manages both
* authentication and security as well as the core of the gamification system:
* points (coins), experience, lives, and streaks.
* * @author Marta
*/
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
    * @var array Attributes enabled for bulk assignment.
    * Includes profile fields, credentials, and game state variables.
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
        'is_plus',
    ];

    /**
    * @var array Attributes that should remain hidden in serializations (JSON).
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
    * @var array Attribute type casting.
    * Ensures that dates are treated as Carbon objects and passwords are handled as hashes.
    */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_life_recovery' => 'datetime',
        'last_streak_at' => 'datetime',
    ];

    /**
    * Relationship with the User Role.
    * Determines the user's permissions within the platform (Admin/User).
    * @author Marta
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
    * Relationship with test results.
    * Stores the user's performance history across different quizzes.
    * @author Marta
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function results()
    {
        return $this->hasMany(UserTestResult::class);
    }

    /**
    * Relationship with the store's inventory.
    * Allows managing purchased items using a pivot table that
    * stores quantity and expiration dates.
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
    * Model Boot Method.
    * Implements an "Observer" using the 'saving' event. This logic detects changes
    * in the user experience. For every block of 10 XP points earned,
    * the system automatically awards 5 coins (points).
    * @author Marta
    * @return void
    */
    protected static function boot()
{
    parent::boot();

    static::saving(function ($user) {
        // Automatic Reward Logic:
        // Checks if the 'experience' attribute has been modified (isDirty).
        if ($user->isDirty('experience')) {
            
            $xpAntigua = $user->getOriginal('experience') ?? 0;
            $xpNueva = $user->experience;

            // Level block calculation (1 block = 10 XP)
            $bloquesAntiguos = floor($xpAntigua / 10);
            $bloquesNuevos = floor($xpNueva / 10);

            // If the user crosses the threshold of a new block, they receive coins.
            if ($bloquesNuevos > $bloquesAntiguos) {
                $monedasAGanar = ($bloquesNuevos - $bloquesAntiguos) * 5;
                $user->points += $monedasAGanar;
            }
        }
    });
}
}