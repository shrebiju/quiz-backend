<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\UserAnswer;
use App\Models\Answer;
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

// public function startQuiz($id)
// {
//     $quiz = Quiz::with(['category', 'difficultyLevel', 'questions.answers'])
//         ->findOrFail($id);
//     if ($quiz->questions->count() !== 5) {
//         return response()->json([
//             'message' => 'Quiz must have exactly 5 questions'
//         ], 422);
//     }

//     $attempt = QuizAttempt::create([
//         'user_id' => auth()->id(),
//         'quiz_id' => $quiz->id,
//         'score' => 0,
//         'total_questions' => 5, 
//         'started_at' => now(),
//     ]);

//     return response()->json([
//         'attempt_id' => $attempt->id,
//         'quiz' => $quiz,
//     ]);
// }
// public function startQuiz($id)
// {
//     $quiz = Quiz::with(['questions.answers'])
//         ->findOrFail($id);

//     // Validate all questions have answers
//     foreach ($quiz->questions as $question) {
//         if ($question->answers->isEmpty()) {
//             return response()->json([
//                 'message' => 'All questions must have at least one answer and atleast five question'
//             ], 422);
//         }
//     }
//         // Filter only questions with answers
//     $validQuestions = $quiz->questions->filter(function ($question) {
//         return $question->answers->isNotEmpty();
//      });
//     $selectedQuestions = $validQuestions->random(5)->values();
//     $quiz->setRelation('questions', $selectedQuestions);

//     // Rest of your existing start quiz logic...
//     $user = auth()->user();
//     $attempt = QuizAttempt::create([
//         'user_id' => $user->id,
//         'quiz_id' => $quiz->id,
//         'score' => 0,
//         'total_questions' => 5,
//         'started_at' => now(),
//     ]);

//     return response()->json([
//         'attempt_id' => $attempt->id,
//         'quiz' => $quiz,
//     ]);
// }

public function startQuiz($id)
{
    $quiz = Quiz::with(['questions.answers'])->findOrFail($id);

    // Filter only questions with answers
    $validQuestions = $quiz->questions->filter(function ($question) {
        return $question->answers->isNotEmpty();
    });

    // Check for minimum 5 questions
    if ($validQuestions->count() < 5) {
        return response()->json([
            'message' => 'Quiz must have at least 5 questions with at least one answer each.'
        ], 422);
    }

    // Randomly select 5 questions
    $selectedQuestions = $validQuestions->random(5)->values();
    $selectedQuestions = $validQuestions->shuffle()->take(5)->values();
    // Overwrite questions with selected ones
    $quiz->setRelation('questions', $selectedQuestions);

    // Create quiz attempt
    $user = auth()->user();
    $attempt = QuizAttempt::create([
        'user_id' => $user->id,
        'quiz_id' => $quiz->id,
        'score' => 0,
        'total_questions' => 5,
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
            'attempt_id' => 'required|exists:quiz_attempts,id,user_id,'.Auth::id(),
            'answers' => 'required|array|size:5',
            'answers.*.question_id' => 'required|exists:questions,id,quiz_id,'.$quizId,
        ]);
    
        $attempt = QuizAttempt::where('id', $request->attempt_id)
            ->where('user_id', Auth::id())
            ->whereNull('completed_at')
            ->firstOrFail();
    
        $score = 0;
        $userAnswers = [];
    
        foreach ($request->answers as $answer) {
            $isCorrect = false;
            $answerId = null;
    
            if ($answer['answer_id']) {
                $answerId = $answer['answer_id'];
                $correctAnswer = Answer::where('id', $answerId)
                    ->where('is_correct', true)
                    ->exists();
                
                $isCorrect = $correctAnswer;
                if ($isCorrect) {
                    $score++;
                }
            }
    
            $userAnswers[] = [
                'attempt_id' => $attempt->id,
                'question_id' => $answer['question_id'],
                'answer_id' => $answerId,
                'is_correct' => $isCorrect,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
    
        UserAnswer::insert($userAnswers);
    
        $attempt->update([
            'score' => $score,
            'completed_at' => now()
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
