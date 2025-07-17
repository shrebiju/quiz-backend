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
        User::factory()->create([ 
            'name' => 'Admin User',
            'email' => 'admin01@admin.com',
            'password' => bcrypt('password'), 
            'role' => 'admin',
        ]);
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


