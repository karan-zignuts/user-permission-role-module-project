<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
  // use SoftDeletes; 

    protected $primaryKey = 'code';
    protected $keyType = 'string'; // Assuming 'code' is a string primary key

    protected $fillable = [
        'code',
        'name',
        'description',
        'parent_code',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public $incrementing = false;

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
    public function parent()
    {
        return $this->belongsTo(Module::class, 'parent_code', 'code');
    }

    // Define relationship for child modules
    public function children()
    {
        return $this->hasMany(Module::class, 'parent_code', 'code');
    }
}
