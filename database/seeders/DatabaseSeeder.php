<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // // Create a test user
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // User::firstOrCreate(
        //     ['email' => 'test@example.com'],
        //     [
        //         'name' => 'Test User',
        //         'password' => bcrypt('password'), 
        //     ]
        // );
        User::factory()->create([ 
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'), 
            'role' => 'admin',
        ]);

        // Call other seeders here
        $this->call([
            CategorySeeder::class,
            DifficultyLevelSeeder::class,
            QuizSeeder::class,
            AnswerSeeder::class,
            QuizAttemptSeeder::class,
            UserAnswerSeeder::class,
        ]);
    }
}


