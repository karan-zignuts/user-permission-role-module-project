<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'date', 'time', 'user_id'];

    // Automatically deactivate meetings whose date and time have passed
    public static function boot()
    {
        parent::boot();
        static::saving(function ($meeting) {
            if ($meeting->date < now()->toDateString() || ($meeting->date == now()->toDateString() && $meeting->time < now()->toTimeString())) {
                $meeting->active = false;
            }
        });
    }
}
