<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Noise;
use App\Models\NoiseType;
use App\Models\UseCase;

class NoiseSeeder extends Seeder
{
    public function run(): void
    {
        $whiteNoise = NoiseType::where('name', 'White Noise')->first();
        $pinkNoise = NoiseType::where('name', 'Pink Noise')->first();
        
        $tidur = UseCase::where('name', 'Tidur')->first();
        $fokus = UseCase::where('name', 'Fokus')->first();
        $relaksasi = UseCase::where('name', 'Relaksasi')->first();

        // Sample noise data
        $noises = [
            [
                'title' => 'Hujan Deras',
                'noise_type_id' => $whiteNoise->id,
                'description' => 'Suara hujan deras yang menenangkan',
                'duration' => 3600,
                'tags' => ['hujan', 'alam', 'tenang'],
            ],
            [
                'title' => 'Ombak Laut',
                'noise_type_id' => $pinkNoise->id,
                'description' => 'Suara ombak laut yang berirama',
                'duration' => 1800,
                'tags' => ['ombak', 'laut', 'pantai'],
            ],
        ];

        foreach ($noises as $noiseData) {
            $noise = Noise::create($noiseData);
            
            // Attach use cases
            if ($noiseData['title'] === 'Hujan Deras') {
                $noise->useCases()->attach([$tidur->id, $relaksasi->id]);
            } else {
                $noise->useCases()->attach([$fokus->id, $relaksasi->id]);
            }
        }
    }
}