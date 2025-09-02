<?php

namespace App\Application\Show\DTOs;

use App\Domain\Show\Enums\ShowFormat;
use App\Domain\Show\Enums\ShowStatus;

class ShowDTO
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $movie_id,
        public readonly string $theater_id,
        public readonly string $start_time,
        public readonly string $end_time,
        public readonly string $language,
        public readonly ShowFormat $format,
        public readonly ShowStatus $status,
        public readonly array $price_tiers,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            movie_id: $data['movie_id'],
            theater_id: $data['theater_id'],
            start_time: $data['start_time'],
            end_time: $data['end_time'],
            language: $data['language'],
            format: is_string($data['format']) ? ShowFormat::from($data['format']) : $data['format'],
            status: is_string($data['status']) ? ShowStatus::from($data['status']) : $data['status'],
            price_tiers: $data['price_tiers'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'movie_id' => $this->movie_id,
            'theater_id' => $this->theater_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'language' => $this->language,
            'format' => $this->format->value,
            'status' => $this->status->value,
            'price_tiers' => $this->price_tiers,
        ];
    }
}
