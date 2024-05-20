<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;

class Role extends Model
{
    use HasFactory;
    // Fillable attributes
    protected $fillable = ['name', 'description', 'is_active'];

    // Define the relationship with permissions
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    // Define the relationship with users
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    // Check if the role has a specific permission for a module action
    public function hasRole($moduleCode, $action)
    {
        foreach ($this->permissions as $permission) {
            if ($permission->hasPermission($moduleCode, $action)) {
                // dd($moduleCode);
                return true;
            }
        }
        return false;
    }
}
