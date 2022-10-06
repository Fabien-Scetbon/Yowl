<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_id' =>Post::all()->random()->id,
            'user_id' =>User::all()->random()->id,
            'content' =>$this->faker->text,
        ];
    }
}


