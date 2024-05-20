<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionModule extends Model
{
    // Guarded attributes to prevent mass assignment vulnerability
    protected $guarded = [];

    // Define the relationship with permission
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    // Define the relationship with module
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_code', 'code');
    }
}
