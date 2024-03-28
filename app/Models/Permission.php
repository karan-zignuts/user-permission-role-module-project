<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'description'];

  public function modules()
  {
    return $this->belongsToMany(Module::class, 'permission_modules');
  }

  public function roles()
  {
    return $this->belongsToMany(Role::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function hasPermission($code, $permissionType)
  {
      return $this->modules()->where('code', $code)->where('code', $permissionType)->exists();
  }
  public function updateModulePermissions($moduleCode, $permissions)
  {
      $modulePermission = PermissionModule::firstOrNew([
          'permission_id' => $this->id,
          'module_code' => $moduleCode,
      ]);

      $modulePermission->fill($permissions);
      $modulePermission->save();
  }
  public function permissionModules()
  {
      return $this->hasMany(PermissionModule::class);
  }
  public function module()
  {
      return $this->belongsToMany(Module::class, 'permission_modules', 'permission_id', 'module_code');
  }

}
