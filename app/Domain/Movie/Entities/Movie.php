<?php

namespace App\Domain\Movie\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'trailer_url',
        'poster_url',
        'release_date',
        'duration',
        'language',
        'genre',
        'rating',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'release_date' => 'date',
        'rating' => 'decimal:1',
        'duration' => 'integer',
    ];

    /**
     * Get the cities where this movie is available.
     */
    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'movie_city');
    }
}

