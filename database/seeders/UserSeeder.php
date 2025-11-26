<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@community.com',
            'password' => Hash::make('password'),
            'bio' => 'System Administrator',
            'role' => 'admin',
            'account_type' => 'business',
            'is_verified' => true,
            'email_verified_at' => now(),
            'last_login_at' => now(),
            'notification_settings' => json_encode([
                'email' => [
                    'new_follower' => true,
                    'new_message' => true,
                    'community_updates' => true,
                ],
                'push' => [
                    'new_follower' => true,
                    'new_message' => true,
                ]
            ]),
        ]);

        // Moderator User
        User::create([
            'name' => 'Community Moderator',
            'username' => 'moderator',
            'email' => 'moderator@community.com',
            'password' => Hash::make('password'),
            'bio' => 'Community Moderator',
            'role' => 'moderator',
            'is_verified' => true,
            'email_verified_at' => now(),
            'last_login_at' => now(),
            'profile_visibility' => 'public',
        ]);

        // Regular Users
        $users = [
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Web Developer passionate about Laravel and Vue.js',
                'location' => 'Jakarta, Indonesia',
                'website' => 'https://johndoe.dev',
                'github_url' => 'https://github.com/johndoe',
                'date_of_birth' => '1990-05-15',
                'gender' => 'male',
                'is_verified' => true,
            ],
            [
                'name' => 'Jane Smith',
                'username' => 'janesmith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'bio' => 'UI/UX Designer & Frontend Developer',
                'location' => 'Bandung, Indonesia',
                'instagram_url' => 'https://instagram.com/janesmith',
                'date_of_birth' => '1992-08-22',
                'gender' => 'female',
                'account_type' => 'creator',
            ],
            [
                'name' => 'Mike Johnson',
                'username' => 'mikej',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Full-stack developer specializing in JavaScript',
                'website' => 'https://mikejohnson.com',
                'linkedin_url' => 'https://linkedin.com/in/mikejohnson',
                'date_of_birth' => '1988-12-10',
                'gender' => 'male',
            ],
            [
                'name' => 'Sarah Wilson',
                'username' => 'sarahw',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Digital marketer and community manager',
                'location' => 'Surabaya, Indonesia',
                'twitter_url' => 'https://twitter.com/sarahwilson',
                'date_of_birth' => '1991-03-30',
                'gender' => 'female',
                'profile_visibility' => 'friends_only',
            ],
        ];

        foreach ($users as $user) {
            User::create(array_merge($user, [
                'email_verified_at' => now(),
                'last_login_at' => now()->subDays(rand(1, 30)),
            ]));
        }

        // Generate additional random users
        User::factory(15)->create();
    }
}