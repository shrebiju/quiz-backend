<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;

class AnswerController extends Controller
{

    public function index($questionId)
    {
        $answers = Answer::where('question_id', $questionId)->get();
        return response()->json($answers);
    }

    public function store(Request $request, $questionId)
    {
        $request->validate([
            'answer_text' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);
    
        // If is_correct is true, ensure no other correct answer exists for this question
        if ($request->is_correct) {
            $existingCorrect = Answer::where('question_id', $questionId)
                                    ->where('is_correct', true)
                                    ->first();
    
            if ($existingCorrect) {
                return response()->json([
                    'message' => 'Only one correct answer is allowed per question.'
                ], 400);
            }
        }
    
        $answer = Answer::create([
            'question_id' => $questionId,
            'answer_text' => $request->answer_text,
            'is_correct' => $request->is_correct,
        ]);
    
        return response()->json($answer, 201);
    }
    

    public function update(Request $request, $id)
    {
        $answer = Answer::findOrFail($id);
        $request->validate([
            'answer_text' => 'string',
            'is_correct' => 'boolean',
        ]);

        $answer->update($request->all());

        return response()->json($answer);
    }

    public function destroy($id)
    {
        Answer::destroy($id);

        return response()->json(['message' => 'Answer deleted']);
    }
    // DELETE /api/admin/answers/{id} 
    // public function destroy($id)
    // {
    //     Answer::findOrFail($id)->delete();
    //     return response()->noContent();
    // }
}
