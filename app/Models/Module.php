<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'parent_code',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $primaryKey = 'code';

    public $incrementing = false;

    public function parent()
    {
        return $this->belongsTo(Module::class, 'parent_code', 'code');
    }

    public function children()
    {
        return $this->hasMany(Module::class, 'parent_code', 'code');
    }
}
