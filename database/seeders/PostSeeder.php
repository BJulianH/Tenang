<?php
// database/seeders/PostSeeder.php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $communities = Community::all();
        $users = User::all();

        $posts = [
            [
                'title' => 'Welcome to our Community!',
                'content' => 'This is the first post in our amazing community. Feel free to introduce yourself!',
                'user_id' => $users->first()->id,
                'community_id' => $communities->first()->id,
            ],
            [
                'title' => 'Laravel 11 Features',
                'content' => 'What are the most exciting features coming in Laravel 11? Let\'s discuss!',
                'user_id' => $users->get(1)->id,
                'community_id' => $communities->where('slug', 'laravel')->first()->id,
            ],
            [
                'title' => 'JavaScript Frameworks Comparison',
                'content' => 'React vs Vue vs Angular - which one do you prefer and why?',
                'user_id' => $users->get(2)->id,
                'community_id' => $communities->where('slug', 'javascript')->first()->id,
            ],
            [
                'title' => 'Programming Tips for Beginners',
                'content' => 'Share your best programming tips for those just starting out!',
                'user_id' => $users->get(3)->id,
                'community_id' => $communities->where('slug', 'programming')->first()->id,
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }

        // Buat beberapa post tambahan
        Post::factory(20)->create([
            'user_id' => fn() => $users->random()->id,
            'community_id' => fn() => $communities->random()->id,
        ]);
    }
}