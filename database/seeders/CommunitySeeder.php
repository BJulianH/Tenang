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
                'name' => 'Programming Discussion',
                'slug' => 'programming',
                'description' => 'Discuss all things programming',
                'type' => 'public',
                'creator_id' => $users->first()->id,
            ],
            [
                'name' => 'Laravel Enthusiasts',
                'slug' => 'laravel',
                'description' => 'Everything about Laravel framework',
                'type' => 'public',
                'creator_id' => $users->get(1)->id,
            ],
            [
                'name' => 'JavaScript Developers',
                'slug' => 'javascript',
                'description' => 'JavaScript and frontend development',
                'type' => 'public',
                'creator_id' => $users->get(2)->id,
            ],
            [
                'name' => 'Private Study Group',
                'slug' => 'study-group',
                'description' => 'Private study group for members only',
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