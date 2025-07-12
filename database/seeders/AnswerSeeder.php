<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
// database/seeders/AnswerSeeder.php
use App\Models\Question;


class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $question = Question::first();
        
        if (!$question) {
            $question = Question::create([
                'quiz_id' => 1, // Ensure quiz_id=1 exists
                'question_text' => 'Sample Question'
            ]);
        }
    
        DB::table('answers')->insert([
            [
                'question_id' => $question->id,
                'answer_text' => 'Answer A',
                'is_correct' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ... other answers
        ]);
    }
}
// public function run(): void
// {
//     DB::table('answers')->insert([
//         [
//             'question_id' => 1,
//             'answer_text' => 'Answer A',
//             'is_correct' => false,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ],
//         [
//             'question_id' => 1,
//             'answer_text' => 'Answer B',
//             'is_correct' => true,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ],
//         // Add more answers here...
//     ]);
// }