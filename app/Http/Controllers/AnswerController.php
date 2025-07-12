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
        $validated = $request->validate([
            'answer_text' => [
                'required',
                'string',
                'max:255',
                // Rule::unique('answers')->where('question_id', $questionId)
            ],
            'is_correct' => 'required|boolean'
        ]);
        // public function store(Request $request, $questionId)
        // {
        //     $validated = $request->validate([
        //         'answer_text' => 'required|string|max:255',
        //         'is_correct' => 'required|boolean',
        //     ]);
        
        //     // If a new correct answer is being added, mark all others as incorrect
        //     if ($validated['is_correct']) {
        //         Answer::where('question_id', $questionId)->update(['is_correct' => false]);
        //     }
        
        //     $answer = Answer::create([
        //         'question_id' => $questionId,
        //         'answer_text' => $validated['answer_text'],
        //         'is_correct' => $validated['is_correct'],
        //     ]);
        
        //     return response()->json($answer, 201);
        // }
        
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
