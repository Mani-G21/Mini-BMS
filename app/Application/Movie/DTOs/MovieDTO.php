<?php

namespace App\Application\Movie\DTOs;

use Illuminate\Support\Str;

class MovieDTO{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $description,
        public readonly ?string $trailer_url,
        public readonly ?string $poster_url,
        public readonly string $release_date,
        public readonly int $duration,
        public readonly string $language,
        public readonly string $genre,
        public readonly ?float $rating,
        public readonly string $status,
        public readonly array $cities = []
    ) 
    {}

    public static function fromModel($movie): self{
        return new self(
            id: $movie->id,
            title: $movie->title,
            description: $movie->description,
            trailer_url: $movie->trailer_url,
            poster_url: $movie->poster_url,
            release_date: $movie->release_date->format('Y-m-d'),
            duration: $movie->duration,
            language: $movie->language,
            genre: $movie->genre,
            rating: $movie->rating,
            status: $movie->status,
            cities: $movie->cities->map(fn($city) => [
                'id' => $city->id,
                'name' => $city->name
            ])->toArray()
        );
    }

    public static function fromRequest(array $data): self
    {
        $tempId = (string) Str::uuid();

       $cities = [];
        if (isset($data['city_ids']) && is_array($data['city_ids'])) {
            foreach ($data['city_ids'] as $cityId) {
                $cities[] = ['id' => $cityId];
            }
        }

        return new self(
            id: $tempId,
            title: $data['title'],
            description: $data['description'] ?? '',
            trailer_url: $data['trailer_url'] ?? null,
            poster_url: $data['poster_url'] ?? null,
            release_date: $data['release_date'] ?? date('Y-m-d'),
            duration: (int)($data['duration'] ?? 0),
            language: $data['language'],
            genre: $data['genre'],
            rating: isset($data['rating']) ? (float)$data['rating'] : null,
            status: $data['status'],
            cities: $cities
        );
    }



}