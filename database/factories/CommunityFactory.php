<?php
// database/factories/CommunityFactory.php

namespace Database\Factories;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommunityFactory extends Factory
{
    protected $model = Community::class;

    public function definition()
    {
        $name = $this->faker->unique()->words(2, true);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(3),
            'banner_image' => $this->faker->boolean(30) ? 'banners/' . $this->faker->uuid() . '.jpg' : null,
            'profile_image' => $this->faker->boolean(50) ? 'profiles/' . $this->faker->uuid() . '.jpg' : null,
            'type' => $this->faker->randomElement(['public', 'private', 'restricted']),
            'creator_id' => User::factory(),
            'parent_id' => null,
            'is_main' => false,
        ];
    }

    public function main()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_main' => true,
                'type' => 'public',
                'parent_id' => null,
            ];
        });
    }

    public function public()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'public',
            ];
        });
    }

    public function private()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'private',
            ];
        });
    }

    public function restricted()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'restricted',
            ];
        });
    }

    public function withParent($parentId = null)
    {
        return $this->state(function (array $attributes) use ($parentId) {
            return [
                'parent_id' => $parentId,
                'is_main' => false,
            ];
        });
    }
}