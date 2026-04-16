<?php

namespace App\Domain\Seat\Entities;

use App\Domain\Seat\Enums\SeatCategory;
use App\Domain\Seat\Enums\SeatStatus;
use App\Domain\Theater\Entities\Theater;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'theater_id',
        'label',
        'row',
        'column',
        'category',
        'status',
    ];

    protected $casts = [
        'category' => SeatCategory::class,
        'status' => SeatStatus::class,
        'row' => 'integer',
        'column' => 'integer',
    ];

    /**
     * Get the theater that owns the seat
     */
    public function theater(): BelongsTo
    {
        return $this->belongsTo(Theater::class, 'theater_id');
    }

    /**
     * Convert the model instance to an array compatible with DTOs
     */
    public function toEntityArray(): array
    {
        return [
            'id' => $this->id,
            'theater_id' => $this->theater_id,
            'label' => $this->label,
            'row' => $this->row,
            'column' => $this->column,
            'category' => $this->category->value,
            'status' => $this->status->value,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}

