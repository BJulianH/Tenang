<?php
// database/factories/UserFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $username = strtolower($firstName . $lastName . $this->faker->randomNumber(3));

        return [
            'name' => $firstName . ' ' . $lastName,
            'username' => $username,
            'email' => $username . '@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'bio' => $this->faker->boolean(70) ? $this->faker->sentence(10) : null,
            'profile_image' => $this->faker->boolean(30) ? 'profiles/' . $this->faker->uuid() . '.jpg' : null,
            'cover_image' => $this->faker->boolean(20) ? 'covers/' . $this->faker->uuid() . '.jpg' : null,
            'website' => $this->faker->boolean(20) ? $this->faker->url() : null,
            'location' => $this->faker->boolean(60) ? $this->faker->city() . ', ' . $this->faker->country() : null,
            'facebook_url' => $this->faker->boolean(15) ? $this->faker->url() : null,
            'twitter_url' => $this->faker->boolean(15) ? $this->faker->url() : null,
            'instagram_url' => $this->faker->boolean(15) ? $this->faker->url() : null,
            'linkedin_url' => $this->faker->boolean(15) ? $this->faker->url() : null,
            'github_url' => $this->faker->boolean(15) ? $this->faker->url() : null,
            'date_of_birth' => $this->faker->boolean(50) ? $this->faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d') : null,
            'gender' => $this->faker->randomElement(['male', 'female', 'other', null]),
            'role' => 'user',
            'account_type' => $this->faker->randomElement(['personal', 'business', 'creator']),
            'is_verified' => $this->faker->boolean(20),
            'is_active' => $this->faker->boolean(95),
            'is_online' => $this->faker->boolean(30),
            'show_email' => $this->faker->boolean(10),
            'show_date_of_birth' => $this->faker->boolean(20),
            'profile_visibility' => $this->faker->randomElement(['public', 'private', 'friends_only']),
            'reputation_score' => $this->faker->numberBetween(0, 1000),
            'post_count' => $this->faker->numberBetween(0, 100),
            'comment_count' => $this->faker->numberBetween(0, 200),
            'follower_count' => $this->faker->numberBetween(0, 500),
            'following_count' => $this->faker->numberBetween(0, 300),
            'timezone' => $this->faker->timezone,
            'locale' => 'id',
            'notification_settings' => json_encode([
                'email' => [
                    'new_follower' => $this->faker->boolean(80),
                    'new_message' => $this->faker->boolean(90),
                    'community_updates' => $this->faker->boolean(60),
                    'post_replies' => $this->faker->boolean(70),
                ],
                'push' => [
                    'new_follower' => $this->faker->boolean(70),
                    'new_message' => $this->faker->boolean(80),
                    'post_replies' => $this->faker->boolean(60),
                ]
            ]),
            'last_login_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'last_login_ip' => $this->faker->ipv4,
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
                'is_verified' => true,
            ];
        });
    }

    public function moderator()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'moderator',
                'is_verified' => true,
            ];
        });
    }

    public function verified()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_verified' => true,
            ];
        });
    }
}