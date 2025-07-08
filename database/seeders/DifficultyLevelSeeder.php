<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DifficultyLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('difficulty_levels')->insert([
            ['name' => 'Beginner', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Intermediate', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Advanced', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
