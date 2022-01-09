<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\PublicationCity;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Book::truncate();
        User::truncate();
        Author::truncate();
        PublicationCity::truncate();

        $user = User::factory()->create();
        $author1 = Author::factory()->create();
        $author2 = Author::factory()->create();
        $city1 = PublicationCity::factory()->create();
        $city2 = PublicationCity::factory()->create();
        $city3 = PublicationCity::factory()->create();

        Book::factory(5)->create([
            'user_id' => $user->id,
            'author_id' => $author1->id,
            'city_id' => $city1->id
        ]);

        Book::factory(3)->create([
            'user_id' => $user->id,
            'author_id' => $author1->id,
            'city_id' => $city2->id
        ]);
        Book::factory(2)->create([
            'user_id' => $user->id,
            'author_id' => $author2->id,
            'city_id' => $city3->id
        ]);
    }
}
