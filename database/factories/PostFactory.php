<?php
// database/factories/PostFactory.php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Community;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraphs(3, true),
            'image' => $this->faker->boolean(20) ? 'posts/' . $this->faker->uuid() . '.jpg' : null,
            'user_id' => User::factory(),
            'community_id' => Community::factory(),
            'mood' => $this->faker->randomElement(['happy', 'calm', 'anxious', 'sad', 'angry', 'neutral']),
            'is_anonymous' => $this->faker->boolean(10),
            'content_type' => 'text',
            'is_support_request' => $this->faker->boolean(15),
            'tags' => $this->faker->boolean(30) ? $this->faker->randomElements(
                ['anxiety', 'depression', 'self-care', 'mindfulness', 'therapy', 'support'], 
                $this->faker->numberBetween(1, 3)
            ) : null,
            'upvotes_count' => $this->faker->numberBetween(0, 100),
            'downvotes_count' => $this->faker->numberBetween(0, 20),
            'comments_count' => $this->faker->numberBetween(0, 50),
            'saves_count' => $this->faker->numberBetween(0, 25),
            'share_count' => $this->faker->numberBetween(0, 10),
            'view_count' => $this->faker->numberBetween(0, 500),
            'is_approved' => $this->faker->boolean(95),
            'is_featured' => $this->faker->boolean(5),
        ];
    }

    public function withImage()
    {
        return $this->state(function (array $attributes) {
            return [
                'image' => 'posts/' . $this->faker->uuid() . '.jpg',
                'content_type' => 'image',
            ];
        });
    }

    public function popular()
    {
        return $this->state(function (array $attributes) {
            return [
                'upvotes_count' => $this->faker->numberBetween(50, 500),
                'comments_count' => $this->faker->numberBetween(20, 200),
                'view_count' => $this->faker->numberBetween(500, 2000),
            ];
        });
    }

    public function supportRequest()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_support_request' => true,
                'mood' => $this->faker->randomElement(['anxious', 'sad', 'angry']),
            ];
        });
    }

    public function anonymous()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_anonymous' => true,
            ];
        });
    }

    public function featured()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_featured' => true,
                'featured_until' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            ];
        });
    }

    public function happy()
    {
        return $this->state(function (array $attributes) {
            return [
                'mood' => 'happy',
            ];
        });
    }

    public function anxious()
    {
        return $this->state(function (array $attributes) {
            return [
                'mood' => 'anxious',
                'is_support_request' => $this->faker->boolean(40),
            ];
        });
    }
}