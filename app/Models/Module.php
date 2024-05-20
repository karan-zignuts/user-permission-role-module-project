<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */

    protected $primaryKey = 'code';
    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'name', 'description', 'parent_code', 'is_active', 'created_by', 'updated_by'];

    public $incrementing = false;

    // Get the permissions associated with the module.
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'module_code', 'module_code');
    }

    // Get the parent module of this module.
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
