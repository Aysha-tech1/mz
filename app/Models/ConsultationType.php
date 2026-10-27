<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationType extends Model
{
    protected $fillable = ['title', 'duration', 'price', 'is_active'];
}
