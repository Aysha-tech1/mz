<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileSale extends Model
{
    protected $fillable = [
        'digital_product_id',
        'type',
        'filename',
        'email',
        'ip',
        'user_agent',
    ];

    public function digitalProduct(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class);
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'sale' => 'بيع',
            'lead' => 'اهتمام',
            default => 'تنزيل',
        };
    }
}
