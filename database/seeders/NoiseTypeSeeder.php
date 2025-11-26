<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NoiseType;

class NoiseTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'White Noise', 'color_code' => '#F3F4F6', 'sort_order' => 1],
            ['name' => 'Pink Noise', 'color_code' => '#FBCFE8', 'sort_order' => 2],
            ['name' => 'Brown Noise', 'color_code' => '#D97706', 'sort_order' => 3],
            ['name' => 'Blue Noise', 'color_code' => '#93C5FD', 'sort_order' => 4],
            ['name' => 'Green Noise', 'color_code' => '#86EFAC', 'sort_order' => 5],
            ['name' => 'Grey Noise', 'color_code' => '#9CA3AF', 'sort_order' => 6],
        ];

        foreach ($types as $type) {
            NoiseType::create($type);
        }
    }
}