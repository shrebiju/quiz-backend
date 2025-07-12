<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\QuizAttempt;
use App\Models\{ User, Quiz};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizAttempt>
 */
class QuizAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = QuizAttempt::class;
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'quiz_id' => Quiz::factory(),
            'score' => $this->faker->numberBetween(0, 100),
            // 'total_questions' => 5,
            'total_questions' => $this->faker->numberBetween(5, 20),
            'started_at' => now(),
            'completed_at' => now()->addMinutes($this->faker->numberBetween(5, 60)),
            // 'completed_at' => now()->addMinutes(10)
        ];
    }
}
