<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const PAYMENT_TYPES = [
        [
            'id' => 1,
            'name' => 'Наличные'
        ],
        [
            'id' => 2,
            'name' => 'Перевод'
        ],
        [
            'id' => 3,
            'name' => 'Карта'
        ],
    ];

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }
}
