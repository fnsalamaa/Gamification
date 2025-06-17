<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'profile_photo_path' => 'avatars/basic-1.jpg',
        ]);
        $adminUser->assignRole('admin');

        $teacherUser = User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'profile_photo_path' => 'avatars/basic-1.jpg',
        ]);
        $teacherUser->assignRole('teacher');

        $studentUser = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'profile_photo_path' => 'avatars/basic-1.jpg', 
        ]);
        $studentUser->assignRole('student');

        Student::create([
            'user_id' => $studentUser->id,  // Associate with the user
            'class' => 'Grade 10',  // You can set any class here, or make it dynamic
            'total_score' => 0,  // Default score
            'weekly_score' => 0,  // Default weekly score
        ]);
    }
}
