<?php

namespace App\Domain\Show\Entities;

use App\Domain\Movie\Entities\Movie;
use App\Domain\Show\Enums\ShowFormat;
use App\Domain\Show\Enums\ShowStatus;
use App\Domain\Theater\Entities\Theater;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Show extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'movie_id',
        'theater_id',
        'start_time',
        'end_time',
        'language',
        'format',
        'status',
        'price_tiers',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'format' => ShowFormat::class,
        'status' => ShowStatus::class,
        'price_tiers' => 'json',
    ];

    /**
     * Get the movie that owns the show.
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Get the theater that owns the show.
     */
    public function theater(): BelongsTo
    {
        return $this->belongsTo(Theater::class);
    }

}
