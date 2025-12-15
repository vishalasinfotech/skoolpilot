<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
        ]);

        // Super Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' => 'super_admin',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ]);

        // School Admin
        User::create([
            'name' => 'School Admin',
            'email' => 'schooladmin@gmail.com',
            'role' => 'school-admin',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ]);

        // Teacher
        User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@gmail.com',
            'role' => 'teacher',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ]);

        // Student
        User::create([
            'name' => 'Student User',
            'email' => 'student@gmail.com',
            'role' => 'student',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ]);

        // Parent
        User::create([
            'name' => 'Parent User',
            'email' => 'parent@gmail.com',
            'role' => 'parent',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ]);

        // Staff
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@gmail.com',
            'role' => 'staff',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ]);
    }
}
