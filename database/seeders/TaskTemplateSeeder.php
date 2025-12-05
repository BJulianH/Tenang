<?php
// database/seeders/TaskTemplateSeeder.php

namespace Database\Seeders;

use App\Models\TaskTemplate;
use Illuminate\Database\Seeder;

class TaskTemplateSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            [
                'name' => 'Minum Obat Pagi',
                'category' => 'medication',
                'priority' => 'high',
                'estimated_duration' => 5,
                'difficulty_level' => 1,
                'is_important' => true,
                'is_urgent' => true,
                'tags' => ['kesehatan', 'rutin'],
                'is_public' => true,
            ],
            [
                'name' => 'Meditasi 10 Menit',
                'category' => 'mindfulness',
                'priority' => 'medium',
                'estimated_duration' => 10,
                'difficulty_level' => 2,
                'is_important' => true,
                'is_urgent' => false,
                'tags' => ['relaksasi', 'mental'],
                'is_public' => true,
            ],
            [
                'name' => 'Olahraga Ringan',
                'category' => 'exercise',
                'priority' => 'medium',
                'estimated_duration' => 30,
                'difficulty_level' => 3,
                'is_important' => true,
                'is_urgent' => false,
                'tags' => ['fisik', 'kesehatan'],
                'is_public' => true,
            ],
            [
                'name' => 'Journaling',
                'category' => 'self_care',
                'priority' => 'medium',
                'estimated_duration' => 15,
                'difficulty_level' => 2,
                'is_important' => true,
                'is_urgent' => false,
                'tags' => ['refleksi', 'mental'],
                'is_public' => true,
            ],
            [
                'name' => 'Minum Air 8 Gelas',
                'category' => 'self_care',
                'priority' => 'medium',
                'estimated_duration' => 1,
                'difficulty_level' => 1,
                'is_important' => true,
                'is_urgent' => false,
                'is_recurring' => true,
                'recurring_pattern' => 'daily',
                'tags' => ['hidrasi', 'kesehatan'],
                'is_public' => true,
            ],
        ];
        
        foreach ($templates as $template) {
            TaskTemplate::create($template);
        }
    }
}