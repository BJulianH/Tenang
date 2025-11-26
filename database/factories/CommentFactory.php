<?php
// database/factories/CommentFactory.php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'content' => $this->faker->paragraph(2),
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'parent_id' => null,
            'upvotes_count' => $this->faker->numberBetween(0, 50),
            'downvotes_count' => $this->faker->numberBetween(0, 10),
        ];
    }

    public function reply()
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => Comment::factory(),
            ];
        });
    }

    public function withParent($parentId)
    {
        return $this->state(function (array $attributes) use ($parentId) {
            return [
                'parent_id' => $parentId,
            ];
        });
    }
}