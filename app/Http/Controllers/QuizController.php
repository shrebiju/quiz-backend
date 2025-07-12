<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
        // Admin view of quizzes
        public function adminIndex()
        {
            return Quiz::with(['category', 'difficultyLevel'])->get();
        }
    
        // Create quiz
        public function store(Request $request)
        {
            // dd($request);
            $request->validate([
                'title' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'difficulty_level_id' => 'required|exists:difficulty_levels,id',
                'time_limit_minutes' => 'required|integer|min:1',
            ]);
    
            $quiz = Quiz::create([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'difficulty_level_id' => $request->difficulty_level_id,
                'time_limit_minutes' => $request->time_limit_minutes,
                'created_by' => auth()->id(),
            ]);
    
            return response()->json($quiz, 201);
        }
    
        // Admin get one quiz (optional)
        public function show($id)
        {
            return Quiz::with(['category', 'difficultyLevel'])->findOrFail($id);
        }
}
