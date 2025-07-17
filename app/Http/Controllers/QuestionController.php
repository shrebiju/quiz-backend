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

    // public function destroy($quizId)
    // {
    //     $question = Question::findOrFail($quizId);
    //     $question->delete();
    //     return response()->json(['message' => 'Question deleted successfully']);
    // }
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        
        // Optional: Verify the question belongs to admin's quiz
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    
        $question->delete();
        
        return response()->json([
            'message' => 'Question deleted successfully'
        ]);
    
}
}

