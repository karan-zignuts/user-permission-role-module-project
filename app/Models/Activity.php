<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['name', 'description', 'assign_person', 'user_id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'activity_logs';
}
