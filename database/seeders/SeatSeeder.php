<?php

namespace Database\Seeders;

use App\Domain\Seat\Entities\Seat;
use Illuminate\Database\Seeder;
use App\Domain\Theater\Entities\Theater;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        $theaters = Theater::all();

        foreach ($theaters as $theater) {
            $totalRows = rand(8, 12);
            $totalCols = rand(10, 15);
            $lastReclinerRows = rand(1, 3);
            $firstRegularRows = rand(2, 5);

            for ($row = 1; $row <= $totalRows; $row++) {
                for ($col = 1; $col <= $totalCols; $col++) {
                    // Determine category
                    if ($row > $totalRows - $lastReclinerRows) {
                        $category = 'Recliner';
                    } elseif ($row <= $firstRegularRows) {
                        $category = 'Regular';
                    } else {
                        $category = 'VIP';
                    }

                    Seat::create([
                        'theater_id' => $theater->id,
                        'label' => chr(64 + $row) . $col, // e.g., A1, B5
                        'row' => $row,
                        'column' => $col,
                        'category' => $category,
                        'status' => 'active',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
