<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SubscriptionPlanSeeder::class,
            AcademicSessionSeeder::class,
            ExamSeeder::class,
            ExamScheduleSeeder::class,
            ResultSeeder::class,
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => \Str::random(10),
        ]);
    }
}
