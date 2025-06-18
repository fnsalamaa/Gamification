<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'name' => '👋 Welcome Aboard',
                'icon' => 'badges/welcome aboard.jpeg',
                'description' => 'Thanks for joining! Start your journey and explore the world of folklore.',
                'unlock_condition' => 'first_login',
            ],
            [
                'name' => '🎓 Folklores Master',
                'icon' => 'badges/folklores master.jpeg',
                'description' => 'You’ve completed all the folktales on the platform. You’re a true master of legends!',
                'unlock_condition' => 'complete_all_stories',
            ],
            [
                'name' => '⚡ Fast Learner',
                'icon' => 'badges/fast learner.jpeg',
                'description' => 'You answered all the questions correctly on your first try. Impressive comprehension skills!',
                'unlock_condition' => 'answer_all_correct_first_try',
            ],
            [
                'name' => '🏅 The Climber',
                'icon' => 'badges/the climber.jpeg',
                'description' => 'You made it into the Top 10! Your hard work and dedication put you ahead of the game. Keep it up!',
                'unlock_condition' => 'reach_top_10',
            ],
            [
                'name' => '👣 First Step',
                'icon' => 'badges/first step.png',
                'description' => 'Great start! You’ve read your very first story.',
                'unlock_condition' => 'read_first_story',
            ],
            [
                'name' => '🧿 Chooser of the Worthy',
                'icon' => 'badges/chooser of the worthy.jpeg',
                'description' => 'Earn 100 points by completing the Ande Ande Lumut story and prove you have the guts to choose your fate. Or will you fall short?',
                'unlock_condition' => 'score_100_ande_ande_lumut',
            ],
            [
                'name' => '🔥 Fated Rebellion',
                'icon' => 'badges/fated rebellion.jpeg',
                'description' => 'Earn 100 points by completing the Sangkuriang story and defy the odds. Can you rewrite destiny, or will you be crushed by it?',
                'unlock_condition' => 'score_100_sangkuriang',
            ],
            [
                'name' => '🍈 Golden Escape',
                'icon' => 'badges/golden escape.jpeg',
                'description' => 'Earn 100 points by completing the Timun Mas story and escape danger like no one else. Do you have the nerve to make it out alive?',
                'unlock_condition' => 'score_100_timun_mas',
            ],
            [
                'name' => '🗿 Statue of Sacrifice',
                'icon' => 'badges/statue of sacrifice.jpeg',
                'description' => 'Earn 100 points by completing the Roro Jonggrang story and cement your place in history. Will your sacrifice be enough to etch your name forever?',
                'unlock_condition' => 'score_100_roro_jonggrang',
            ],
            [
                'name' => '🦅 Voice of the Truth',
                'icon' => 'badges/voice of the truth.jpeg',
                'description' => 'Earn 100 points by completing the Cindelaras story and let the truth resonate. Are you brave enough to speak it when no one else will?',
                'unlock_condition' => 'score_100_cindelaras',
            ],
            [
                'name' => '👑 The Chosen One',
                'icon' => 'badges/the chosen one.jpeg',
                'description' => 'Top the all folklores leaderboard and claim your spot as the ultimate champion!',
                'unlock_condition' => 'rank_1_all_stories',
            ],
            [
                'name' => '🥇 Unrivaled Tales Master',
                'icon' => 'badges/unrivaled tales master.jpeg',
                'description' => 'Rank 1 in the final leaderboard, show the world no one can outdo you!',
                'unlock_condition' => 'rank_1_final',
            ],
            [
                'name' => '🥈 Shadow of the Light',
                'icon' => 'badges/shadow of the light.jpeg',
                'description' => 'Rank 2 in the final leaderboard. Close, but not quite. Can you do more?',
                'unlock_condition' => 'rank_2_final',
            ],
            [
                'name' => '🥉 Keris Master',
                'icon' => 'badges/keris master.jpeg',
                'description' => 'Rank 3 in the final leaderboard. You’ve got the skill, but is it enough?',
                'unlock_condition' => 'rank_3_final',
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(
                ['name' => $badge['name']], 
                $badge                      
            );
        }

    }
}
