<?php
// database/seeders/PostSeeder.php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $communities = Community::all();
        $users = User::all();

        $posts = [
            [
                'title' => 'Selamat Datang di Komunitas Kami!',
                'content' => 'Ini adalah postingan pertama di komunitas yang luar biasa ini. Silakan perkenalkan diri Anda!',
                'user_id' => $users->first()->id,
                'community_id' => $communities->first()->id,
            ],
            [
                'title' => 'Dukungan untuk Kesehatan Mental',
                'content' => 'Hari ini saya ingin berbagi pengalaman perjalanan kesehatan mental saya. Mari saling mendukung!',
                'user_id' => $users->get(1)->id,
                'community_id' => $communities->where('slug', 'mental-health-support')->first()->id,
            ],
            [
                'title' => 'Teknik Mindfulness untuk Pemula',
                'content' => 'Apa teknik mindfulness yang paling efektif untuk pemula? Bagikan pengalaman Anda!',
                'user_id' => $users->get(2)->id,
                'community_id' => $communities->where('slug', 'mindfulness-meditation')->first()->id,
            ],
            [
                'title' => 'Strategi Mengatasi Stres',
                'content' => 'Bagikan strategi terbaik Anda untuk mengatasi stres sehari-hari!',
                'user_id' => $users->get(3)->id,
                'community_id' => $communities->where('slug', 'coping-strategies')->first()->id,
            ],
            [
                'title' => 'Tips Mencari Bantuan Profesional',
                'content' => 'Bagaimana cara menemukan terapis atau profesional kesehatan mental yang tepat?',
                'user_id' => $users->get(4)->id ?? $users->first()->id,
                'community_id' => $communities->where('slug', 'professional-support')->first()->id,
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }

        // Buat beberapa post tambahan
        Post::factory(20)->create([
            'user_id' => fn() => $users->random()->id,
            'community_id' => fn() => $communities->random()->id,
        ]);
    }
}