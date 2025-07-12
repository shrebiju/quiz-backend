<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//has model aaslo ahas bwfdjebfhvehvdhvfhdbvf
use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserAnswers;



class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_questions',
        'started_at',
        'completed_at'
    ];

    protected $dates = [
        'started_at',
        'completed_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz() 
    {
        return $this->belongsTo(Quiz::class)->with('category');
    }

    public function userAnswers()
    {
        //return $this->hasMany(UserAnswer::class);
         return $this->hasMany(UserAnswer::class, 'attempt_id');
    }
}
