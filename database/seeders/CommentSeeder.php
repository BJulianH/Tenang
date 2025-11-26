<?php
// database/seeders/CommentSeeder.php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $posts = Post::all();
        $users = User::all();

        $comments = [
            [
                'content' => 'Great post! Thanks for sharing.',
                'user_id' => $users->get(1)->id,
                'post_id' => $posts->first()->id,
            ],
            [
                'content' => 'I completely agree with this!',
                'user_id' => $users->get(2)->id,
                'post_id' => $posts->first()->id,
            ],
            [
                'content' => 'Has anyone tried this with the latest version?',
                'user_id' => $users->get(3)->id,
                'post_id' => $posts->get(1)->id,
            ],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }

        // Buat beberapa comment tambahan
        Comment::factory(30)->create([
            'user_id' => fn() => $users->random()->id,
            'post_id' => fn() => $posts->random()->id,
        ]);
    }
}