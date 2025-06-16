<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Badge;
class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'name' => '🎓 Folklore Master',
                'icon' => 'badges/badge-1.png',
                'description' => 'You’ve completed all the folktales on the platform. You’re a true master of legends!',

            ],
            [
                'name' => '⚡ Fast Learner',
                'icon' => 'badges/badge-2.png',
                'description' => 'You answered all the questions correctly on your first try. Impressive comprehension skills!',
    
            ],
            [
                'name' => '🏅 The Climber',
                'icon' => 'badges/badge-3.png',
                'description' => 'You made it into the Top 10! Your hard work and dedication put you ahead of the game. Keep it up!',

            ],
            [
                'name' => '👋 Welcome Aboard',
                'icon' => 'badges/badge-4.png',
                'description' => 'Thanks for joining! Start your journey and explore the world of folklore.',
          
            ],
            [
                'name' => '👣 First Step',
                'icon' => 'badges/badge-5.png',
                'description' => 'Great start! You’ve read your very first story.',
                
               
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
