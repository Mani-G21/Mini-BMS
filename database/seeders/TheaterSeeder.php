<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Domain\Movie\Entities\City;
use App\Domain\Theater\Entities\Theater;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TheaterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = City::all();

        foreach ($cities as $city) {
            Theater::create([
                'id' => Str::uuid(),
                'name' => $city->name . ' Central Multiplex',
                'address' => 'Main Road, ' . $city->name,
                'city_id' => $city->id,
                'latitude' => fake()->latitude,
                'longitude' => fake()->longitude,
            ]);
        }

    }
}
