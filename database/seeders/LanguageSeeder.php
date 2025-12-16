<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default English language
        Language::firstOrCreate(
            ['code' => 'en'],
            [
                'name' => 'English',
                'native_name' => 'English',
                'is_active' => true,
                'is_default' => true,
                'sort_order' => 0,
            ]
        );

        // Create Hindi language
        Language::firstOrCreate(
            ['code' => 'hi'],
            [
                'name' => 'Hindi',
                'native_name' => 'हिंदी',
                'is_active' => true,
                'is_default' => false,
                'sort_order' => 1,
            ]
        );
    }
}
