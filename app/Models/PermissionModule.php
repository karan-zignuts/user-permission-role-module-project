<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionModule extends Model
{
    protected $guarded = [];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_code', 'code');
    }
}
