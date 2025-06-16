<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Avatar;

class AvatarSeeder extends Seeder
{
    public function run(): void
    {
        $avatars = [
            [
                'name' => 'Basic Avatar 1',
                'image_path' => 'avatars/basic-1.jpg',
                'description' => 'Basic avatar for new players.',
                'unlock_condition' => 0,
            ],
            [
                'name' => 'Basic Avatar 2',
                'image_path' => 'avatars/basic-2.jpg',
                'description' => 'Basic avatar for new players.',
                'unlock_condition' => 0,
            ],
            [
                'name' => 'Basic Avatar 3',
                'image_path' => 'avatars/basic-3.jpg',
                'description' => 'Basic avatar for new players.',
                'unlock_condition' => 0,
            ],
            [
                'name' => 'Basic Avatar 4',
                'image_path' => 'avatars/basic-4.jpg',
                'description' => 'Basic avatar for new players.',
                'unlock_condition' => 0,
            ],
            [
                'name' => 'Improved Avatar',
                'image_path' => 'avatars/improved.jpg',
                'description' => 'Unlocked after completing 3 folklore stories.',
                'unlock_condition' => 3,
            ],
            [
                'name' => 'Special Avatar',
                'description' => 'Unlocked after completing 6 folklore stories.',
                'image_path' => 'avatars/special.jpg',
                'unlock_condition' => 6,
            ],
        ];

        foreach ($avatars as $avatar) {
            Avatar::create($avatar);
        }
    }
}
