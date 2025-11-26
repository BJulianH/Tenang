<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UseCase;

class UseCaseSeeder extends Seeder
{
    public function run(): void
    {
        $useCases = [
            ['name' => 'Tidur', 'icon' => '💤', 'sort_order' => 1],
            ['name' => 'Fokus', 'icon' => '🎯', 'sort_order' => 2],
            ['name' => 'Relaksasi', 'icon' => '😌', 'sort_order' => 3],
            ['name' => 'Meditasi', 'icon' => '🧘', 'sort_order' => 4],
            ['name' => 'Membaca', 'icon' => '📖', 'sort_order' => 5],
            ['name' => 'Bekerja', 'icon' => '💼', 'sort_order' => 6],
        ];

        foreach ($useCases as $useCase) {
            UseCase::create($useCase);
        }
    }
}