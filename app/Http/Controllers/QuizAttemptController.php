<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizAttempt; 


class QuizAttemptController extends Controller
{
    public function index(Request $request)
    {
        $query = QuizAttempt::with(['user', 'quiz'])
            ->latest();
        
        // Filter by quiz
        if ($request->has('quiz_id')) {
            $query->where('quiz_id', $request->quiz_id);
        }
        
        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by date range
        if ($request->has(['start_date', 'end_date'])) {
            $query->whereBetween('completed_at', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $attempts = $query->paginate(10);

        return response()->json($attempts);
    }
}
