<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\Show\Validators\Rules\NoShowOverlap;

class NoShowOverlapTest extends TestCase
{
    use RefreshDatabase;

    private string $movieId = '019657d4-d443-72db-98fa-17c27adf2539';
    private string $theaterId = '01968a5c-a135-7195-8d6b-3b6e4248947f';
    private string $cityId = '11111111-aaaa-bbbb-cccc-222222222222';

    protected function setUp():void
    {
        parent::setUp();

        // Ensure foreign key checks for SQLite
        DB::statement('PRAGMA foreign_keys=ON');

        // Insert dependent data
        DB::table('cities')->insert([
            'id' => $this->cityId,
            'name' => 'Mumbai',
            'country' => 'India',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('theaters')->insert([
            'id' => $this->theaterId,
            'name' => 'INOX Metro',
            'address' => 'Metro Junction, Mumbai Central, Mumbai',
            'city_id' => $this->cityId,
            'latitude' => 19.0760,
            'longitude' => 72.8777,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('movies')->insert([
            'id' => $this->movieId,
            'title' => 'Inception',
            'description' => 'A skilled thief is offered a chance to implant an idea in a target’s subconscious.',
            'trailer_url' => 'https://youtube.com/trailer/inception',
            'poster_url' => 'https://cdn.example.com/posters/inception.jpg',
            'release_date' => '2010-07-16',
            'duration' => 148,
            'language' => 'English',
            'genre' => 'Science Fiction',
            'rating' => 8.8,
            'status' => 'now_showing',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Existing overlapping show (6 PM to 8 PM)
        DB::table('shows')->insert([
            'id' => 1,
            'movie_id' => $this->movieId,
            'theater_id' => $this->theaterId,
            'start_time' => '2025-05-01 18:00:00',
            'end_time' => '2025-05-01 20:00:00',
            'status' => 'active',
            'language' => 'English',
            'format' => 'IMAX',
            'price_tiers' => json_encode([
                ['name' => 'Regular', 'price' => 250],
                ['name' => 'VIP', 'price' => 450],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    #[Test]
    public function it_fails_if_new_show_starts_before_and_ends_during_existing_show()
    {
        $rule = new NoShowOverlap($this->theaterId, '2025-05-01 17:30:00', '2025-05-01 18:30:00');
        $this->assertFalse($rule->passes('start_time', '2025-05-01 17:30:00'));
    }

    #[Test]
    public function it_fails_if_new_show_starts_during_and_ends_after_existing_show()
    {
        $rule = new NoShowOverlap($this->theaterId, '2025-05-01 19:30:00', '2025-05-01 20:30:00');
        $this->assertFalse($rule->passes('start_time', '2025-05-01 19:30:00'));
    }

    #[Test]
    public function it_fails_if_new_show_completely_overlaps_existing_show()
    {
        $rule = new NoShowOverlap($this->theaterId, '2025-05-01 17:00:00', '2025-05-01 21:00:00');
        $this->assertFalse($rule->passes('start_time', '2025-05-01 17:00:00'));
    }

    #[Test]
    public function it_fails_if_new_show_is_completely_within_existing_show()
    {
        $rule = new NoShowOverlap($this->theaterId, '2025-05-01 18:30:00', '2025-05-01 19:00:00');
        $this->assertFalse($rule->passes('start_time', '2025-05-01 18:30:00'));
    }

    #[Test]
    public function it_passes_if_new_show_ends_when_existing_show_starts()
    {
        $rule = new NoShowOverlap($this->theaterId, '2025-05-01 16:00:00', '2025-05-01 18:00:00');
        $this->assertTrue($rule->passes('start_time', '2025-05-01 16:00:00'));
    }

    #[Test]
    public function it_passes_if_new_show_starts_when_existing_show_ends()
    {
        $rule = new NoShowOverlap($this->theaterId, '2025-05-01 20:00:00', '2025-05-01 22:00:00');
        $this->assertTrue($rule->passes('start_time', '2025-05-01 20:00:00'));
    }

    #[Test]
    public function it_passes_if_theater_has_no_shows()
    {
        $rule = new NoShowOverlap('NEW_THEATER', '2025-05-01 18:00:00', '2025-05-01 20:00:00');
        $this->assertTrue($rule->passes('start_time', '2025-05-01 18:00:00'));
    }
}
