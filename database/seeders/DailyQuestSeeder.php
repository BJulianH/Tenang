<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DailyQuest;

class DailyQuestSeeder extends Seeder
{
    public function run()
    {
        $quests = [
            // App Activity Quests
            [
                'title' => 'Tulis Journal Harian',
                'description' => 'Luangkan waktu 5 menit untuk menulis perasaan dan pikiranmu hari ini',
                'type' => 'app_activity',
                'category' => 'journaling',
                'points' => 15,
                'coins' => 10,
                'diamonds' => 2,
                'required_progress' => 1,
                'is_repeatable' => true,
            ],
            [
                'title' => 'Update Mood Tracker',
                'description' => 'Catat perasaanmu saat ini di mood tracker',
                'type' => 'app_activity',
                'category' => 'mood_tracking',
                'points' => 10,
                'coins' => 5,
                'diamonds' => 1,
                'required_progress' => 1,
                'is_repeatable' => true,
            ],
            [
                'title' => 'Berbagi di Komunitas',
                'description' => 'Bagikan pengalaman atau dukungan di forum komunitas',
                'type' => 'app_activity',
                'category' => 'community',
                'points' => 20,
                'coins' => 15,
                'diamonds' => 3,
                'required_progress' => 1,
                'is_repeatable' => true,
            ],

            // Daily Life Quests - Self Care
            [
                'title' => 'Gosok Gigi Pagi & Malam',
                'description' => 'Jaga kebersihan mulut dengan gosok gigi teratur',
                'type' => 'daily_life',
                'category' => 'self_care',
                'points' => 10,
                'coins' => 8,
                'diamonds' => 1,
                'required_progress' => 2,
                'is_repeatable' => true,
            ],
            [
                'title' => 'Cuci Muka Sebelum Tidur',
                'description' => 'Bersihkan wajah untuk kulit yang sehat dan tidur yang nyenyak',
                'type' => 'daily_life',
                'category' => 'self_care',
                'points' => 8,
                'coins' => 5,
                'diamonds' => 1,
                'required_progress' => 1,
                'is_repeatable' => true,
            ],
            [
                'title' => 'Minum 8 Gelas Air',
                'description' => 'Penuhi kebutuhan hidrasi tubuhmu hari ini',
                'type' => 'daily_life',
                'category' => 'physical_health',
                'points' => 12,
                'coins' => 10,
                'diamonds' => 2,
                'required_progress' => 8,
                'is_repeatable' => true,
            ],

            // Daily Life Quests - Mindfulness & Productivity
            [
                'title' => 'Baca Buku 15 Menit',
                'description' => 'Luangkan waktu untuk membaca buku favoritmu',
                'type' => 'daily_life',
                'category' => 'productivity',
                'points' => 15,
                'coins' => 12,
                'diamonds' => 2,
                'required_progress' => 1,
                'is_repeatable' => true,
            ],
            [
                'title' => 'Digital Detox 5 Menit',
                'description' => 'Matikan layar dan nikmati momen tanpa gangguan digital',
                'type' => 'daily_life',
                'category' => 'digital_wellbeing',
                'points' => 10,
                'coins' => 8,
                'diamonds' => 1,
                'required_progress' => 1,
                'is_repeatable' => true,
            ],
            [
                'title' => 'Meditasi 5 Menit',
                'description' => 'Tenangkan pikiran dengan meditasi singkat',
                'type' => 'daily_life',
                'category' => 'mindfulness',
                'points' => 15,
                'coins' => 10,
                'diamonds' => 2,
                'required_progress' => 1,
                'is_repeatable' => true,
            ],
            [
                'title' => 'Olahraga Ringan',
                'description' => 'Lakukan peregangan atau jalan kaki 10 menit',
                'type' => 'daily_life',
                'category' => 'physical_health',
                'points' => 20,
                'coins' => 15,
                'diamonds' => 3,
                'required_progress' => 1,
                'is_repeatable' => true,
            ],
            [
                'title' => 'Buat To-Do List',
                'description' => 'Rencanakan hari mu dengan menulis to-do list',
                'type' => 'daily_life',
                'category' => 'productivity',
                'points' => 10,
                'coins' => 5,
                'diamonds' => 1,
                'required_progress' => 1,
                'is_repeatable' => true,
            ],
            [
                'title' => 'Ucapkan Syukur',
                'description' => 'Tulis 3 hal yang kamu syukuri hari ini',
                'type' => 'daily_life',
                'category' => 'mindfulness',
                'points' => 12,
                'coins' => 8,
                'diamonds' => 2,
                'required_progress' => 3,
                'is_repeatable' => true,
            ],
        ];

        foreach ($quests as $quest) {
            DailyQuest::create($quest);
        }
    }
}