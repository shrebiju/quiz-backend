<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QuizController extends Controller
{
    // List all available quizzes
    public function index()
    {
        $quizzes = Quiz::with(['category', 'difficultyLevel'])
            // ->where('is_published', true)
            ->get();

        return response()->json([
            'quizzes' => $quizzes
        ]);
    }
    
    public function startQuiz($id)
{
    $quiz = Quiz::with(['category', 'difficultyLevel', 'questions.answers'])->findOrFail($id);

    $user = auth()->user();

    // Create quiz attempt
    $attempt = QuizAttempt::create([
        'user_id' => $user->id,
        'quiz_id' => $quiz->id,
        'score' => 0,
        'total_questions' => $quiz->questions->count(),
        'started_at' => now(),
    ]);

    return response()->json([
        'attempt_id' => $attempt->id,
        'quiz' => $quiz,
    ]);
}


    // Submit quiz answers
    public function submitQuiz(Request $request, $quizId)
    {
        $request->validate([
            'answers' => 'required|array|size:5',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer_id' => 'required|exists:answers,id',
        ]);
        $quiz = Quiz::findOrFail($quizId);
        $attempt = QuizAttempt::where('id', $request->attempt_id)
            ->where('user_id', Auth::id())
            ->whereNull('completed_at')
            ->firstOrFail();

        $score = 0;
        $userAnswers = [];

        foreach ($request->answers as $answer) {
            $question = Question::find($answer['question_id']);
            $selectedAnswer = $question->answers()->find($answer['answer_id']);
            
            $isCorrect = $selectedAnswer ? $selectedAnswer->is_correct : false;
            if ($isCorrect) {
                $score++;
            }

            $userAnswers[] = [
                'attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'answer_id' => $selectedAnswer->id,
                'is_correct' => $isCorrect,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Bulk insert user answers
        UserAnswer::insert($userAnswers);

        // Update attempt with score and completion time
        $attempt->update([
            'score' => $score,
            'completed_at' => Carbon::now()
        ]);

        return response()->json([
            'message' => 'Quiz submitted successfully',
            'score' => $score,
            'total_questions' => $attempt->total_questions
        ]);
    }

    // Get user's quiz attempts history
    public function myAttempts()
    {
        $attempts = QuizAttempt::with(['quiz.category', 'quiz.difficultyLevel'])
            ->where('user_id', Auth::id())
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'desc')
            ->get();

        return response()->json([
            'attempts' => $attempts
        ]);
    }
}
