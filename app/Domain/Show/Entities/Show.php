<?php

namespace App\Domain\Show\Entities;

use App\Domain\Movie\Entities\Movie;
use App\Domain\Show\Enums\ShowFormat;
use App\Domain\Show\Enums\ShowStatus;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Theater\Entities\Theater;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }


    public function theater(): BelongsTo
    {
        return $this->belongsTo(Theater::class);
    }

}
