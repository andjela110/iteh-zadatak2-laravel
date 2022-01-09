<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Author;
use App\Models\PublicationCity;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->slug(),
            'title' => $this->faker->title(),
            'description' => $this->faker->paragraph(),
            'user_id' => User::factory(),
            'author_id' => Author::factory(),
            'city_id' => PublicationCity::factory()
        ];
    }
}
