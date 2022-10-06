<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // DB::table("categories")->insert([
        //     ["name" => "article"],
        //     ["name" => "photo"],
        //     ["name" => "video"],
        //     ["name" => "autre"],
        // ]);
        // \App\Models\User::factory(50)->create();
        \App\Models\Post::factory(50)->create();
        \App\Models\Comment::factory(200)->create();
        


    }
}
