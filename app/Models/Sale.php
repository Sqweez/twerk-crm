<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Sale
 *
 * @property int $id
 * @property int $client_id
 * @property int $user_id
 * @property int $subscription_id
 * @property int|null $trainer_id
 * @property int $price
 * @property int $payment_type
 * @property int $validity_visits
 * @property string|null $active_until
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read \App\Models\Subscription $subscription
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereActiveUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereTrainerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereValidityVisits($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User|null $trainer
 * @property-read \App\Models\User $user
 * @property-read bool $is_activated
 * @property-read bool $is_active
 * @property-read bool $is_expired
 * @property-read int $visits_remaining
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Visit[] $visits
 * @property-read int|null $visits_count
 * @property int $hall_id
 * @property int $time_id
 * @property-read string $payment_type_name
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereHallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereTimeId($value)
 * @property-read string $time
 * @property-read \App\Models\Hall|null $hall
 */
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
        [
            'id' => 4,
            'name' => 'Онлайн'
        ]
    ];

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }

    public function hall(): BelongsTo {
        return $this->belongsTo(Hall::class);
    }

    public function subscription(): BelongsTo {
        return $this->belongsTo(Subscription::class)->withTrashed();
    }

    public function trainer(): BelongsTo {
        return $this->belongsTo(User::class, 'trainer_id')->withDefault([
            'id' => -1,
            'name' => 'Не установлен'
        ]);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function visits(): HasMany {
        return $this->hasMany(Visit::class);
    }

    public function getIsActivatedAttribute(): bool {
        return !!$this->active_until;
    }

    public function getVisitsRemainingAttribute(): int {
        return $this->validity_visits - $this->visits->count();
    }

    public function getIsExpiredAttribute(): bool {
        return $this->getIsActivatedAttribute()
            && !now()->lessThanOrEqualTo(Carbon::parse($this->active_until));
    }

    public function getIsActiveAttribute(): bool {
        return $this->getVisitsRemainingAttribute() > 0
            && !$this->getIsExpiredAttribute();
    }

    public function getPaymentTypeNameAttribute(): string {
        return collect(self::PAYMENT_TYPES)->where('id', $this->payment_type)->first()['name'];
    }

    public function getTimeAttribute(): string {
        return Subscription::TIME_TYPES[$this->time_id];
    }
}
