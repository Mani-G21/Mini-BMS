<?php

namespace App\Domain\Movie\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'state',
        'country',
        'is_active',
    ];

    public function movies(){
        return $this->belongsToMany(Movie::class, 'movie_city');
    }
}
