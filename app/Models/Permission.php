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
      // Assuming you have a relationship defined between Permission and Module
      // Adjust this query based on your database schema and relationships
      return $this->modules()->where('code', $code)->where('code', $permissionType)->exists();
  }
}
