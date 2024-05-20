<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = ['name', 'description'];

    // Define the relationship with modules
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'permission_modules');
    }

    // Define the relationship with roles
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // Define the relationship with users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with permission modules
    public function permissionModules()
    {
        return $this->hasMany(PermissionModule::class);
    }

    // Define the relationship with a single module
    public function module()
    {
        return $this->belongsToMany(Module::class, 'permission_modules', 'permission_id', 'module_code');
    }

    // Method to update module permissions
    public function updateModulePermissions($moduleCode, $permissions)
    {
        $modulePermission = PermissionModule::firstOrNew([
            'permission_id' => $this->id,
            'module_code' => $moduleCode,
        ]);

        $modulePermission->fill($permissions);
        $modulePermission->save();
    }

    // Method to check if a permission exists for a module and action
    public function hasPermission($moduleCode, $action)
    {
        $modulePermission = $this->permissionModules()->where('module_code', $moduleCode)->first();

        // dd($modulePermission->$action);
        if ($modulePermission) {
            return $modulePermission->$action;
        }

        return false;
    }
}
