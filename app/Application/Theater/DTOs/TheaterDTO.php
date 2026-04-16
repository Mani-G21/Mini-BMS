<?php

namespace App\Application\Theater\DTOs;

class TheaterDTO
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $name,
        public readonly string $address,
        public readonly string $city_id,
        public readonly ?float $latitude,
        public readonly ?float $longitude,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            address: $data['address'],
            city_id: $data['city_id'],
            latitude: $data['latitude'] ?? null,
            longitude: $data['longitude'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'city_id' => $this->city_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
