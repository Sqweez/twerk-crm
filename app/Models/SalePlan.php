<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SalePlan
 *
 * @property int $id
 * @property int $user_id
 * @property int $hall_id
 * @property int $visits_count
 * @property-read \App\Models\Hall $hall
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SalePlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalePlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalePlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalePlan whereHallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalePlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalePlan whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalePlan whereVisitsCount($value)
 * @mixin \Eloquent
 * @property int $sale_count
 * @method static \Illuminate\Database\Eloquent\Builder|SalePlan whereSaleCount($value)
 */
class SalePlan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function user(): BelongsTo {
        return $this->belongsTo(User::class)->select(['id', 'name']);
    }

    public function hall(): BelongsTo {
        return $this->belongsTo(Hall::class);
    }
}
