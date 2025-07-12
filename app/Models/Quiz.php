<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\DifficultyLevel;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;


use App\Models\QuizAttempt;


class Quiz extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'category_id',
        'difficulty_level_id',
        'time_limit_minutes',
        'created_by',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function difficultyLevel()
    {
        return $this->belongsTo(DifficultyLevel::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
