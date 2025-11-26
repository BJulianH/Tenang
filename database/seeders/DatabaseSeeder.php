<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CommunitySeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            NoiseTypeSeeder::class,
            UseCaseSeeder::class,
            NoiseSeeder::class,
        ]);
    }
}