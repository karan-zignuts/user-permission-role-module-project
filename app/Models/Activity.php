<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'description', 'assign_person','user_id'];
  protected $table = 'activity_logs';
}
