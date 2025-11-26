<?php
// database/factories/NoiseTypeFactory.php

namespace Database\Factories;

use App\Models\NoiseType;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoiseTypeFactory extends Factory
{
    protected $model = NoiseType::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'color_code' => $this->faker->hexColor,
            'description' => $this->faker->sentence,
            'sort_order' => $this->faker->numberBetween(1, 10),
            'is_active' => true, // Default aktif
        ];
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
}