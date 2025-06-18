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
                'name' => 'Seeker of Legends',
                'image_path' => 'avatars/seeker of legends.jpeg',
                'description' => 'Unlocked after embarking on a journey through two legendary stories and earn the Seeker of Legends avatar by becoming the ultimate explorer!.',
                'unlock_condition' => 3,
            ],
            [
                'name' => 'Guardian of Tales',
                'description' => 'Unlocked after completing all five folklores and prove yourself as the ultimate Guardian of Tales, protector of these timeless legends!',
                'image_path' => 'avatars/guardian of tales.jpeg',
                'unlock_condition' => 5,
            ],

            [
                'name' => 'Prambanan Sacrifice',
                'image_path' => 'avatars/prambanan sacrifice.jpeg',
                'description' => 'Unlocked by becoming no. 1 in the Roro Jonggrang story means enduring sacrifice and strength in this tragic tale of love and betrayal!',
                'unlock_condition' => 'story_roro_jonggrang_1',
            ],
            [
                'name' => 'Furious Sangkuriang',
                'image_path' => 'avatars/furious sangkuriang.jpeg',
                'description' => 'Unlocked by becoming no. 1 in the Sangkuriang story means mastering the fury and passion of this legendary tale!',
                'unlock_condition' => 'story_sangkuriang_1',
            ],
            [
                'name' => 'Klenting Kuning Face Off',
                'image_path' => 'avatars/klenting kuning face off.jpeg',
                'description' => 'Unlocked by becoming no. 1 in the Ande Ande Lumut story means facing off against the legendary Klenting Kuning and proving your worth!',
                'unlock_condition' => 'story_ande_ande_lumut_1',
            ],
            [
                'name' => 'Cindelaras & Magi Rooster',
                'image_path' => 'avatars/cindelaras & magi rooster.jpeg',
                'description' => 'Unlocked by becoming no. 1 in the Cindelaras story means overcoming all obstacles with Cindelaras and the magical rooster by your side!',
                'unlock_condition' => 'story_cindelaras_1',
            ],
            [
                'name' => 'Born of Timun Mas',
                'image_path' => 'avatars/born of timun mas.jpeg',
                'description' => 'Unlocked by becoming no. 1 in the Timun Mas story means conquering giants and proving you are the ultimate hero!',
                'unlock_condition' => 'story_timun_mas_1',
            ],

        ];

        foreach ($avatars as $avatar) {
            Avatar::updateOrCreate(
                [ 'name' => $avatar['name']],
                $avatar
            );
        }
    }
}