<?php

namespace App\Domain\Booking\Entities;

use App\Core\Entities\User;
use App\Domain\Show\Entities\Show;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasUuids;
    protected $table = 'bookings';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'show_id',
        'payment_id',
        'total_amount',
        'status'
    ];

    /**
     * A booking belongs to a show.
     */
    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    /**
     * A booking belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A booking has many seats.
     */
    public function seats(): HasMany
    {
        return $this->hasMany(BookingSeat::class);
    }
}
