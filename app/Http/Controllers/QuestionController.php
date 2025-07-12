<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    // Admin adds a question to quiz
    public function store(Request $request, $quizId)
    {
        $request->validate([
            'question_text' => 'required|string',
        ]);

        $question = Question::create([
            'quiz_id' => $quizId,
            'question_text' => $request->question_text,
        ]);

        return response()->json($question, 201);
    }

    // (Optional) View questions for a quiz
    public function index($quizId)
    {
        return Question::where('quiz_id', $quizId)->get();
    }
}

