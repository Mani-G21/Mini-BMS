<?php

namespace Database\Seeders;

use App\Domain\Movie\Entities\City;
use App\Domain\Movie\Entities\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = City::all();

        $movies = [
            [
                'title' => 'The Shawshank Redemption',
                'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'trailer_url' => 'https://www.youtube.com/watch?v=6hB3S9bIaco',
                'poster_url' => 'https://example.com/posters/shawshank.jpg',
                'release_date' => '1994-09-23',
                'duration' => 142,
                'language' => 'English',
                'genre' => 'Drama',
                'rating' => 9.3,
                'status' => 'now_showing',
                'cities' => [0, 1, 2] // Mumbai, Delhi, Bangalore
            ],
            [
                'title' => 'The Godfather',
                'description' => 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
                'trailer_url' => 'https://www.youtube.com/watch?v=sY1S34973zA',
                'poster_url' => 'https://example.com/posters/godfather.jpg',
                'release_date' => '1972-03-24',
                'duration' => 175,
                'language' => 'English',
                'genre' => 'Crime',
                'rating' => 9.2,
                'status' => 'now_showing',
                'cities' => [0, 3] // Mumbai, Chennai
            ],
            [
                'title' => 'The Dark Knight',
                'description' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'trailer_url' => 'https://www.youtube.com/watch?v=EXeTwQWrcwY',
                'poster_url' => 'https://example.com/posters/dark_knight.jpg',
                'release_date' => '2008-07-18',
                'duration' => 152,
                'language' => 'English',
                'genre' => 'Action',
                'rating' => 9.0,
                'status' => 'now_showing',
                'cities' => [0, 1, 2, 3, 4] // All cities
            ],
            [
                'title' => 'Pulp Fiction',
                'description' => 'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine in four tales of violence and redemption.',
                'trailer_url' => 'https://www.youtube.com/watch?v=s7EdQ4FqbhY',
                'poster_url' => 'https://example.com/posters/pulp_fiction.jpg',
                'release_date' => '1994-10-14',
                'duration' => 154,
                'language' => 'English',
                'genre' => 'Crime',
                'rating' => 8.9,
                'status' => 'now_showing',
                'cities' => [1, 4] // Delhi, Hyderabad
            ],
            [
                'title' => 'Schindler\'s List',
                'description' => 'In German-occupied Poland during World War II, industrialist Oskar Schindler gradually becomes concerned for his Jewish workforce after witnessing their persecution by the Nazis.',
                'trailer_url' => 'https://www.youtube.com/watch?v=gG22XNhtnoY',
                'poster_url' => 'https://example.com/posters/schindlers_list.jpg',
                'release_date' => '1993-12-15',
                'duration' => 195,
                'language' => 'English',
                'genre' => 'Biography',
                'rating' => 8.9,
                'status' => 'now_showing',
                'cities' => [0, 2] // Mumbai, Bangalore
            ],
            [
                'title' => 'Inception',
                'description' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'trailer_url' => 'https://www.youtube.com/watch?v=YoHD9XEInc0',
                'poster_url' => 'https://example.com/posters/inception.jpg',
                'release_date' => '2010-07-16',
                'duration' => 148,
                'language' => 'English',
                'genre' => 'Sci-Fi',
                'rating' => 8.8,
                'status' => 'now_showing',
                'cities' => [0, 1, 2, 3] // Mumbai, Delhi, Bangalore, Chennai
            ],
            [
                'title' => 'Fight Club',
                'description' => 'An insomniac office worker and a devil-may-care soapmaker form an underground fight club that evolves into something much, much more.',
                'trailer_url' => 'https://www.youtube.com/watch?v=SUXWAEX2jlg',
                'poster_url' => 'https://example.com/posters/fight_club.jpg',
                'release_date' => '1999-10-15',
                'duration' => 139,
                'language' => 'English',
                'genre' => 'Drama',
                'rating' => 8.8,
                'status' => 'now_showing',
                'cities' => [1, 3] // Delhi, Chennai
            ],
            [
                'title' => '3 Idiots',
                'description' => 'Two friends are searching for their long lost companion. They revisit their college days and recall the memories of their friend who inspired them to think differently, even as the rest of the world called them "idiots".',
                'trailer_url' => 'https://www.youtube.com/watch?v=xvszmNXdM4w',
                'poster_url' => 'https://example.com/posters/3_idiots.jpg',
                'release_date' => '2009-12-25',
                'duration' => 170,
                'language' => 'Hindi',
                'genre' => 'Comedy',
                'rating' => 8.4,
                'status' => 'now_showing',
                'cities' => [0, 1, 2, 3, 4] // All cities
            ],
            [
                'title' => 'Dangal',
                'description' => 'Former wrestler Mahavir Singh Phogat and his two wrestler daughters struggle towards glory at the Commonwealth Games in the face of societal oppression.',
                'trailer_url' => 'https://www.youtube.com/watch?v=x_7YlGv9u1g',
                'poster_url' => 'https://example.com/posters/dangal.jpg',
                'release_date' => '2016-12-23',
                'duration' => 161,
                'language' => 'Hindi',
                'genre' => 'Biography',
                'rating' => 8.4,
                'status' => 'now_showing',
                'cities' => [0, 1, 4] // Mumbai, Delhi, Hyderabad
            ],
            [
                'title' => 'Baahubali: The Beginning',
                'description' => 'In ancient India, an adventurous and daring man becomes involved in a decades-old feud between two warring peoples.',
                'trailer_url' => 'https://www.youtube.com/watch?v=sOEg_YZQsTI',
                'poster_url' => 'https://example.com/posters/baahubali.jpg',
                'release_date' => '2015-07-10',
                'duration' => 159,
                'language' => 'Telugu',
                'genre' => 'Action',
                'rating' => 8.1,
                'status' => 'now_showing',
                'cities' => [2, 3, 4] // Bangalore, Chennai, Hyderabad
            ],
            [
                'title' => 'K.G.F: Chapter 1',
                'description' => 'In the 1970s, a fierce rebel rises against brutal oppression and becomes the symbol of hope to legions of downtrodden people.',
                'trailer_url' => 'https://www.youtube.com/watch?v=qXQsCfOOhCw',
                'poster_url' => 'https://example.com/posters/kgf.jpg',
                'release_date' => '2018-12-21',
                'duration' => 156,
                'language' => 'Kannada',
                'genre' => 'Action',
                'rating' => 8.2,
                'status' => 'now_showing',
                'cities' => [0, 2, 3] // Mumbai, Bangalore, Chennai
            ],
            [
                'title' => 'Vikram',
                'description' => 'A special agent investigates a murder committed by a masked group of serial killers. However, a tangled maze of clues soon leads him to the drug kingpin of Chennai.',
                'trailer_url' => 'https://www.youtube.com/watch?v=OKBMCL-frPU',
                'poster_url' => 'https://example.com/posters/vikram.jpg',
                'release_date' => '2022-06-03',
                'duration' => 175,
                'language' => 'Tamil',
                'genre' => 'Action',
                'rating' => 8.3,
                'status' => 'now_showing',
                'cities' => [3, 4] // Chennai, Hyderabad
            ],
            [
                'title' => 'Avatar: The Way of Water',
                'description' => 'Jake Sully lives with his newfound family formed on the extrasolar moon Pandora. Once a familiar threat returns to finish what was previously started, Jake must work with Neytiri and the army of the Na\'vi race to protect their home.',
                'trailer_url' => 'https://www.youtube.com/watch?v=d9MyW72ELq0',
                'poster_url' => 'https://example.com/posters/avatar_way_of_water.jpg',
                'release_date' => '2022-12-16',
                'duration' => 192,
                'language' => 'English',
                'genre' => 'Sci-Fi',
                'rating' => 7.6,
                'status' => 'now_showing',
                'cities' => [0, 1, 2, 3, 4] // All cities
            ],
            [
                'title' => 'Dune: Part Two',
                'description' => 'Paul Atreides unites with Chani and the Fremen while seeking revenge against the conspirators who destroyed his family.',
                'trailer_url' => 'https://www.youtube.com/watch?v=Way9Dexny3w',
                'poster_url' => 'https://example.com/posters/dune_part_two.jpg',
                'release_date' => '2024-03-01',
                'duration' => 166,
                'language' => 'English',
                'genre' => 'Sci-Fi',
                'rating' => 8.8,
                'status' => 'now_showing',
                'cities' => [0, 1, 2] // Mumbai, Delhi, Bangalore
            ],
            [
                'title' => 'Deadpool & Wolverine',
                'description' => 'Wolverine is recovering from his injuries when he is approached by the motor-mouthed mercenary Deadpool to join forces.',
                'trailer_url' => 'https://www.youtube.com/watch?v=eDakAihCF8M',
                'poster_url' => 'https://example.com/posters/deadpool_wolverine.jpg',
                'release_date' => '2024-07-26',
                'duration' => 150,
                'language' => 'English',
                'genre' => 'Action',
                'rating' => null,
                'status' => 'coming_soon',
                'cities' => [0, 1, 2, 3, 4] // All cities
            ],
            [
                'title' => 'Venom: The Last Dance',
                'description' => 'Eddie and Venom are on the run. On the hunt for the symbiote, Eddie and Venom come face to face with a new threat: Knull.',
                'trailer_url' => 'https://www.youtube.com/watch?v=jbE5ja-SbrI',
                'poster_url' => 'https://example.com/posters/venom_last_dance.jpg',
                'release_date' => '2024-10-25',
                'duration' => 140,
                'language' => 'English',
                'genre' => 'Action',
                'rating' => null,
                'status' => 'coming_soon',
                'cities' => [0, 1] // Mumbai, Delhi
            ],
            [
                'title' => 'Pushpa 2: The Rule',
                'description' => 'After solidifying his position in the red sandalwood smuggling syndicate, Pushpa Raj aims to become its leader while facing threats from old and new enemies alike.',
                'trailer_url' => 'https://www.youtube.com/watch?v=gXz0qjwzNRI',
                'poster_url' => 'https://example.com/posters/pushpa_2.jpg',
                'release_date' => '2024-12-06',
                'duration' => 180,
                'language' => 'Telugu',
                'genre' => 'Action',
                'rating' => null,
                'status' => 'coming_soon',
                'cities' => [2, 3, 4] // Bangalore, Chennai, Hyderabad
            ],
            [
                'title' => 'Kalki 2898 AD',
                'description' => 'Set in the future, this science fiction film explores the last avatar of Lord Vishnu in a post-apocalyptic world, blending mythology with futuristic elements.',
                'trailer_url' => 'https://www.youtube.com/watch?v=p6N7_iCRVlA',
                'poster_url' => 'https://example.com/posters/kalki_2898.jpg',
                'release_date' => '2024-06-27',
                'duration' => 165,
                'language' => 'Telugu',
                'genre' => 'Sci-Fi',
                'rating' => null,
                'status' => 'coming_soon',
                'cities' => [0, 2, 3, 4] // Mumbai, Bangalore, Chennai, Hyderabad
            ],
            [
                'title' => 'Stree 2',
                'description' => 'The residents of Chanderi face a new supernatural threat as the vengeful spirit of Stree returns stronger than before.',
                'trailer_url' => 'https://www.youtube.com/watch?v=jj4boQcSVBQ',
                'poster_url' => 'https://example.com/posters/stree_2.jpg',
                'release_date' => '2024-08-15',
                'duration' => 145,
                'language' => 'Hindi',
                'genre' => 'Horror',
                'rating' => null,
                'status' => 'coming_soon',
                'cities' => [0, 1, 4] // Mumbai, Delhi, Hyderabad
            ]
        ];

        foreach ($movies as $movieData) {
           
            $cityIndices = $movieData['cities'];
            unset($movieData['cities']);
            $movie = Movie::create($movieData);

            $cityIds = [];
            foreach ($cityIndices as $index) {
                if (isset($cities[$index])) {
                    $cityIds[] = $cities[$index]->id;
                }
            }

            if (!empty($cityIds)) {
                foreach ($cityIds as $cityId) {
                    DB::table('movie_city')->insert([
                        'movie_id' => $movie->id,
                        'city_id' => $cityId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

    }
}
