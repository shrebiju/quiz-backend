<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DifficultyLevel;

class DifficultyLevelController extends Controller
{
    public function index()
    {
        return DifficultyLevel::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:difficulty_levels'
        ]);
        
        return DifficultyLevel::create($validated);
    }

    public function update(Request $request, DifficultyLevel $difficulty_level)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:difficulty_levels,name,'.$difficulty_level->id
        ]);
        
        $difficulty_level->update($validated);
        return $difficulty_level;
    }
    
    public function destroy(DifficultyLevel $difficulty_level)
    {
        $difficulty_level->delete();
        return response()->noContent();
    }
}
