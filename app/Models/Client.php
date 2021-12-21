<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class)->withDefault([
            'id' => -1,
            'name' => 'Удаленный админ'
        ]);
    }

    public function getFullnameAttribute(): string {
        return sprintf("%s %s", $this->attributes['name'], $this->attributes['surname']);
    }
}
