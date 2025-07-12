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
    

    // Start a quiz - get random questions
    // public function startQuiz($id)
    // {
    //     $quiz = Quiz::findOrFail($id);
        
    //     // Get 5 random questions for this quiz
    //     $questions = Question::where('quiz_id', $quiz->id)
    //         ->inRandomOrder()
    //         ->limit(5)
    //         ->with(['answers' => function($query) {
    //             $query->inRandomOrder(); // Shuffle answers too
    //         }])
    //         ->get();

    //     // Create a new quiz attempt
    //     $attempt = QuizAttempt::create([
    //         'user_id' => Auth::id(),
    //         'quiz_id' => $quiz->id,
    //         'started_at' => Carbon::now(),
    //         'total_questions' => $questions->count()
    //     ]);

    //     return response()->json([
    //         'quiz' => $quiz,
    //         'questions' => $questions,
    //         'attempt_id' => $attempt->id
    //     ]);
    // }
    //     public function startQuiz($id)
    // {
    //     $quiz = Quiz::with(['category', 'difficultyLevel'])->findOrFail($id);

    //     // Get 5 random questions with their answers
    //     $questions = $quiz->questions()->with('answers')->inRandomOrder()->limit(5)->get();

    //     return response()->json([
    //         'quiz' => [
    //             'id' => $quiz->id,
    //             'title' => $quiz->title,
    //             'category' => $quiz->category,
    //             'attempt_id' => $quiz->id,
    //             'difficulty_level' => $quiz->difficultyLevel,
    //             'time_limit_minutes' => $quiz->time_limit_minutes,
    //             'questions' => $questions->map(function ($question) {
    //                 return [
    //                     'id' => $question->id,
    //                     'question_text' => $question->question_text,
    //                     'answers' => $question->answers->map(function ($answer) {
    //                         return [
    //                             'id' => $answer->id,
    //                             'answer_text' => $answer->answer_text
    //                             // Do NOT return is_correct
    //                         ];
    //                     }),
    //                 ];
    //             }),
    //         ]
    //     ]);
    // }

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
        
        // $request->validate([
        //     'attempt_id' => 'required|exists:quiz_attempts,id,user_id,'.Auth::id(),
        //     'answers' => 'required|array',
        //     'answers.*.question_id' => 'required|exists:questions,id',
        //     'answers.*.answer_id' => 'required|exists:answers,id',
        // ]);

        $quiz = Quiz::findOrFail($quizId);
        // $attempt = QuizAttempt::findOrFail($request->attempt_id);

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
