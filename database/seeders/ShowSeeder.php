<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Domain\Movie\Entities\Movie;
use App\Domain\Theater\Entities\Theater;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = Movie::where('status', 'now_showing')->get();
        $theaters = Theater::all();

        foreach ($movies as $movie) {
            foreach ($theaters->random(2) as $theater) {
                $startTime = now()->addDays(rand(1, 7))->setTime(rand(10, 20), 0);
                $endTime = (clone $startTime)->addMinutes($movie->duration);

                DB::table('shows')->insert([
                    'id' => Str::uuid(),
                    'movie_id' => $movie->id,
                    'theater_id' => $theater->id,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'language' => $movie->language,
                    'format' => 'IMAX',
                    'status' => 'active',
                    'price_tiers' => json_encode([
                        ['name' => 'Regular', 'price' => 250],
                        ['name' => 'VIP', 'price' => 450],
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

    }
}
