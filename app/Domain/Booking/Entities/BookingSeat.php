<?php


namespace App\Domain\Booking\Entities;

use App\Domain\Seat\Entities\Seat;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BookingSeat extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'booking_seats';
    protected $keyType = 'string';

    protected $fillable = [
        'booking_id',
        'seat_id',
    ];

    /**
     * A booked seat belongs to a booking.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * A booked seat belongs to a seat.
     */
    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }
}

