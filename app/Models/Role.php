<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'is_active'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

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
