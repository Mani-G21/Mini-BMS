<?php

namespace App\Application\Seat\DTOs;

use App\Domain\Seat\Enums\SeatCategory;
use App\Domain\Seat\Enums\SeatStatus;

class SeatDTO
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $theater_id,
        public readonly string $label,
        public readonly int $row,
        public readonly int $column,
        public readonly SeatCategory $category,
        public readonly SeatStatus $status,
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            theater_id: $data['theater_id'],
            label: $data['label'],
            row: $data['row'],
            column: $data['column'],
            category: isset($data['category']) ?
                (is_string($data['category']) ? SeatCategory::from($data['category']) : $data['category']) :
                SeatCategory::REGULAR,
            status: isset($data['status']) ?
                (is_string($data['status']) ? SeatStatus::from($data['status']) : $data['status']) :
                SeatStatus::ACTIVE,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'theater_id' => $this->theater_id,
            'label' => $this->label,
            'row' => $this->row,
            'column' => $this->column,
            'category' => $this->category->value,
            'status' => $this->status->value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

