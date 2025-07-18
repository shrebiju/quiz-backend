<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\DifficultyLevel;

class DifficultyLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = ['Beginner', 'Intermediate', 'Advanced'];
        //EASY HAS BEEN ADDED BY POSTMAN FOR TEST PURPOSE
        //FOR UPDATE TEST I HAVE CHANGE BEGINNER TO Novice
        //At laast Easy has been deleted for test purpose

        foreach ($levels as $name) {
            DifficultyLevel::create(['name' => $name]);
        }
    }
}

