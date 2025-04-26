<?php

namespace Database\Seeders;

use App\Domain\Movie\Entities\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Mumbai', 'state' => 'Maharashtra', 'country' => 'India', 'is_active' => true],
            ['name' => 'Delhi', 'state' => 'Delhi', 'country' => 'India', 'is_active' => true],
            ['name' => 'Bangalore', 'state' => 'Karnataka', 'country' => 'India', 'is_active' => true],
            ['name' => 'Chennai', 'state' => 'Tamil Nadu', 'country' => 'India', 'is_active' => true],
            ['name' => 'Hyderabad', 'state' => 'Telangana', 'country' => 'India', 'is_active' => true],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }

    }
}
