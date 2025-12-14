<?php
// database/seeders/CommunitySeeder.php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        // Komunitas utama (seperti Facebook feed utama)
        $mainCommunity = Community::create([
            'name' => 'Global Community',
            'slug' => 'global',
            'description' => 'The main community for all users',
            'type' => 'public',
            'creator_id' => $users->first()->id,
            'is_main' => true,
        ]);

        // Tambahkan semua user ke komunitas utama
        foreach ($users as $user) {
            $mainCommunity->members()->attach($user->id, [
                'role' => 'member',
                'status' => 'approved'
            ]);
        }

        // Sub-komunitas (grup-grup)
        $subCommunities = [
            [
                'name' => 'Mental Health Support',
                'slug' => 'mental-health-support',
                'description' => 'Tempat berbagi dan mendukung perjalanan kesehatan mental',
                'type' => 'public',
                'creator_id' => $users->first()->id,
            ],
            [
                'name' => 'Mindfulness & Meditation',
                'slug' => 'mindfulness-meditation',
                'description' => 'Praktik mindfulness, meditasi, dan hidup sadar penuh',
                'type' => 'public',
                'creator_id' => $users->get(1)->id,
            ],
            [
                'name' => 'Coping Strategies',
                'slug' => 'coping-strategies',
                'description' => 'Berbagi strategi mengatasi stres, kecemasan, dan tantangan mental',
                'type' => 'public',
                'creator_id' => $users->get(2)->id,
            ],
            [
                'name' => 'Professional Support Group',
                'slug' => 'professional-support',
                'description' => 'Grup privat untuk diskusi dengan terapis dan profesional kesehatan mental',
                'type' => 'private',
                'creator_id' => $users->get(3)->id,
            ],
        ];

        foreach ($subCommunities as $subCommunity) {
            $community = Community::create($subCommunity);
            
            // Tambahkan creator sebagai admin
            $community->members()->attach($subCommunity['creator_id'], [
                'role' => 'admin',
                'status' => 'approved'
            ]);

            // Tambahkan beberapa member secara acak
            $randomMembers = $users->random(3);
            foreach ($randomMembers as $member) {
                if ($member->id != $subCommunity['creator_id']) {
                    $community->members()->attach($member->id, [
                        'role' => 'member',
                        'status' => 'approved'
                    ]);
                }
            }
        }
    }
}