<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   $categories = [1, 2, 3,4];
        return [

            'title'        => $this->faker->sentence,
            'content'      => $this->faker->paragraph,
            'category_id'  => $categories[array_rand($categories)],
            // 'user_id'      => User::factory(),
            'user_id'      => User::all()->random()->id,
            'likes_number' => random_int(0, 500),
            'url'          => $this->faker->url,
        ];
    }
}



