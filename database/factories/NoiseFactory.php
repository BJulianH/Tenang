<?php
// database/factories/NoiseFactory.php

namespace Database\Factories;

use App\Models\Noise;
use App\Models\NoiseType;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoiseFactory extends Factory
{
    protected $model = Noise::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'audio_file' => 'noises/' . $this->faker->uuid() . '.mp3',
            'duration' => $this->faker->numberBetween(300, 3600), // 5-60 menit
            'is_loop' => true,
            'is_premium' => $this->faker->boolean(20),
            'play_count' => $this->faker->numberBetween(0, 1000),
            'volume_level' => $this->faker->randomFloat(1, 0.3, 1.0),
            'tags' => $this->faker->boolean(50) ? $this->faker->words(3) : null,
            'is_active' => true, // Default aktif
            'noise_type_id' => NoiseType::factory(),
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