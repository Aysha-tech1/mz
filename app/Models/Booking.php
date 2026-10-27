<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = ['consultation_type_id', 'name', 'email', 'phone', 'topic', 'date', 'time', 'status'];

    public function consultationType(): BelongsTo
    {
        return $this->belongsTo(ConsultationType::class);
    }
}
