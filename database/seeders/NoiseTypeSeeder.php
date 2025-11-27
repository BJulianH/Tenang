<?php
// database/seeders/NoiseTypeSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NoiseType;

class NoiseTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'White Noise', 
                'color_code' => '#F3F4F6', 
                'description' => 'Suara statis dengan frekuensi merata, ideal untuk menutupi suara sekitar dan membantu fokus',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Pink Noise', 
                'color_code' => '#FBCFE8', 
                'description' => 'Suara yang lebih hangat dan lembut dari white noise, meniru suara alam seperti hujan ringan',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Brown Noise', 
                'color_code' => '#D97706', 
                'description' => 'Suara dalam dengan bass yang kuat, seperti gemuruh guntur atau air terjun besar',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Blue Noise', 
                'color_code' => '#93C5FD', 
                'description' => 'Suara yang lebih terang dan tajam dari white noise, cocok untuk fokus dan konsentrasi',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Violet Noise', 
                'color_code' => '#A855F7', 
                'description' => 'Suara dengan dominan frekuensi tinggi, sering digunakan untuk terapi tinnitus',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'name' => 'Grey Noise', 
                'color_code' => '#9CA3AF', 
                'description' => 'Suara yang disesuaikan dengan cara manusia mendengar, memberikan pengalaman yang lebih natural',
                'sort_order' => 6,
                'is_active' => true
            ],
            [
                'name' => 'Green Noise', 
                'color_code' => '#86EFAC', 
                'description' => 'Suara yang meniru alam tenang seperti hutan lembut atau sungai kecil',
                'sort_order' => 7,
                'is_active' => true
            ],
            [
                'name' => 'Black Noise', 
                'color_code' => '#000000', 
                'description' => 'Hampir tidak ada suara, hanya klik atau rumble sangat ringan untuk ketenangan total',
                'sort_order' => 8,
                'is_active' => true
            ],
            [
                'name' => 'Nature Sounds', 
                'color_code' => '#10B981', 
                'description' => 'Kumpulan suara alam seperti hujan, ombak, burung, dan angin',
                'sort_order' => 9,
                'is_active' => true
            ],
            [
                'name' => 'Ambient Sounds', 
                'color_code' => '#8B5CF6', 
                'description' => 'Suara lingkungan seperti kafe, perpustakaan, atau kota yang tenang',
                'sort_order' => 10,
                'is_active' => true
            ],
            [
                'name' => 'Binaural Beats', 
                'color_code' => '#EC4899', 
                'description' => 'Frekuensi khusus untuk meditasi, relaksasi, dan meningkatkan fokus',
                'sort_order' => 11,
                'is_active' => true
            ],
            [
                'name' => 'ASMR', 
                'color_code' => '#F59E0B', 
                'description' => 'Suara lembut yang memicu respons sensorik autonomous meridian',
                'sort_order' => 12,
                'is_active' => true
            ]
        ];

        foreach ($types as $type) {
            NoiseType::create($type);
        }

        $this->command->info('Successfully seeded ' . count($types) . ' noise types!');
    }
}