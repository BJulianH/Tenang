<?php
// database/factories/VoteFactory.php

namespace Database\Factories;

use App\Models\Vote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition()
    {
        $voteableType = $this->faker->randomElement(['App\Models\Post', 'App\Models\Comment']);
        
        return [
            'user_id' => User::factory(),
            'voteable_type' => $voteableType,
            'voteable_id' => $this->getVoteableId($voteableType),
            'type' => $this->faker->randomElement(['upvote', 'downvote']),
        ];
    }

    private function getVoteableId($voteableType)
    {
        if ($voteableType === 'App\Models\Post') {
            return \App\Models\Post::factory();
        }
        
        return \App\Models\Comment::factory();
    }

    public function upvote()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'upvote',
            ];
        });
    }

    public function downvote()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'downvote',
            ];
        });
    }

    public function forPost($postId = null)
    {
        return $this->state(function (array $attributes) use ($postId) {
            return [
                'voteable_type' => 'App\Models\Post',
                'voteable_id' => $postId ?? \App\Models\Post::factory(),
            ];
        });
    }

    public function forComment($commentId = null)
    {
        return $this->state(function (array $attributes) use ($commentId) {
            return [
                'voteable_type' => 'App\Models\Comment',
                'voteable_id' => $commentId ?? \App\Models\Comment::factory(),
            ];
        });
    }
}