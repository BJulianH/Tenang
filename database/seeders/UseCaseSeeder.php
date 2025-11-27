<?php
// database/seeders/UseCaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UseCase;

class UseCaseSeeder extends Seeder
{
    public function run(): void
    {
        $useCases = [
            [
                'name' => 'Tidur',
                'slug' => 'sleep',
                'icon' => '💤',
                'description' => 'Suara yang membantu tidur lebih cepat dan nyenyak',
                'sort_order' => 1
            ],
            [
                'name' => 'Fokus',
                'slug' => 'focus',
                'icon' => '🎯',
                'description' => 'Suara untuk meningkatkan konsentrasi dan produktivitas',
                'sort_order' => 2
            ],
            [
                'name' => 'Relaksasi',
                'slug' => 'relaxation',
                'icon' => '😌',
                'description' => 'Suara yang menenangkan pikiran dan mengurangi stres',
                'sort_order' => 3
            ],
            [
                'name' => 'Meditasi',
                'slug' => 'meditation',
                'icon' => '🧘‍♀️',
                'description' => 'Suara pendukung praktik meditasi dan mindfulness',
                'sort_order' => 4
            ],
            [
                'name' => 'Membaca',
                'slug' => 'reading',
                'icon' => '📖',
                'description' => 'Suara yang cocok untuk aktivitas membaca yang tenang',
                'sort_order' => 5
            ],
            [
                'name' => 'Bekerja',
                'slug' => 'working',
                'icon' => '💼',
                'description' => 'Suara untuk menciptakan lingkungan kerja yang produktif',
                'sort_order' => 6
            ],
            [
                'name' => 'Studi',
                'slug' => 'studying',
                'icon' => '📚',
                'description' => 'Suara yang membantu proses belajar dan menghafal',
                'sort_order' => 7
            ],
            [
                'name' => 'Yoga',
                'slug' => 'yoga',
                'icon' => '🧘‍♂️',
                'description' => 'Suara yang mendukung praktik yoga dan peregangan',
                'sort_order' => 8
            ],
            [
                'name' => 'Healing',
                'slug' => 'healing',
                'icon' => '🌿',
                'description' => 'Suara untuk proses pemulihan dan penyembuhan mental',
                'sort_order' => 9
            ],
            [
                'name' => 'Anxiety Relief',
                'slug' => 'anxiety-relief',
                'icon' => '🌈',
                'description' => 'Suara yang membantu meredakan kecemasan dan panic attack',
                'sort_order' => 10
            ]
        ];

        foreach ($useCases as $useCase) {
            UseCase::create($useCase);
        }

        $this->command->info('Successfully seeded ' . count($useCases) . ' use cases!');
    }
}