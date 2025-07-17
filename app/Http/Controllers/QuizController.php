<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
    // this one is for quiz to show in admin as Multiple Quiz
        public function adminIndex()
        {
            return Quiz::with(['category', 'difficultyLevel'])->get();
        }
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
        // this one is for quiz to show in admin as Multiple Quiz question section
        public function show($id)
        {
            $quiz = Quiz::with(['questions'])->findOrFail($id);
            return response()->json($quiz);
        }

}
