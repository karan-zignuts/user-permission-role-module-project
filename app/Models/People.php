<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Permission;

class People extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'designation', 'address', 'phone_number', 'email', 'status','user_id'];
    protected $table = 'peoples';

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->hasManyThrough(Permission::class, Role::class);
    }
}
