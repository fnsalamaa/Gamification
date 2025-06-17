<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AvatarSeeder;
use Database\Seeders\BadgeSeeder;
use Database\Seeders\StageSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AvatarSeeder::class,
            BadgeSeeder::class,
            StageSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
