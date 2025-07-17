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
        //Auto generate admin and user  
        User::factory()->create([ 
            'name' => 'Admin User',
            'email' => 'admin01@admin.com',
            'password' => bcrypt('password'), 
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user01@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
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


