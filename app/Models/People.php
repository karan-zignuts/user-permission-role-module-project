<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Permission;

class People extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'designation', 'address', 'phone_number', 'email', 'status', 'user_id'];

    // The table associated with the model.
    protected $table = 'peoples';

    // Get the roles associated with the people.
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // Get the permissions associated with the people's roles.
    public function permissions()
    {
        return $this->hasManyThrough(Permission::class, Role::class);
    }
}
