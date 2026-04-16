<?php

namespace App\Application\Booking\DTOs;

use App\Domain\Seat\Enums\SeatCategory;

class SeatMapDTO
{
    public function __construct(
        public readonly string $seat_id,
        public readonly string $label,
        public readonly int $row,
        public readonly int $column,
        public readonly SeatCategory $category,
        public readonly string $status
    ) {
    }

    public function toArray(): array
    {
        return [
            'seat_id' => $this->seat_id,
            'label' => $this->label,
            'row' => $this->row,
            'column' => $this->column,
            'category' => $this->category,
            'status' => $this->status,
        ];
    }
}
