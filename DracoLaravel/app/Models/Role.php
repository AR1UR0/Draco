<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
* Role Class
* Manages the different levels of access and permissions within the platform.
* This model is the basis of the Role-Based Access Control (RBAC) system,
* allowing functionalities to be segmented between standard users and administrators.
* @author Marta
*/
class Role extends Model 
{
    /**
    * @var array Attributes enabled for bulk assignment.
    * The 'name' field typically stores values ​​like 'admin' or 'user'.
    */
    protected $fillable = ['name']; 

    /**
    * Direct Relationship (One-to-Many): A role can be assigned to multiple users.
    * This relationship allows, for example, easily obtaining all
    * users who have administrator privileges.
    * @author Marta
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
