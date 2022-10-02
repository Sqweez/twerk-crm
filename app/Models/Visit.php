<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Visit
 *
 * @property int $id
 * @property int $client_id
 * @property int $subscription_id
 * @property int $user_id
 * @property int|null $trainer_id
 * @property int $sale_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Visit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Visit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Visit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereSaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereTrainerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereUserId($value)
 * @mixin \Eloquent
 */
class Visit extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function trainer(): BelongsTo {
        return $this->belongsTo(User::class, 'trainer_id')
            ->withDefault([
                'id' => -1,
                'name' => 'Не установлен'
            ]);
    }

    public function subscription(): BelongsTo {
        return $this->belongsTo(Subscription::class);
    }
}
