<?php

namespace App\Domain\Theater\Entities;

use App\Domain\Movie\Entities\City;
use App\Domain\Show\Entities\Show;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theater extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'city_id',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];


    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function shows(): HasMany
    {
        return $this->hasMany(Show::class);
    }
}
