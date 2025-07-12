<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\UserAnswer;


class Question extends Model
{
    protected $fillable = [
        'quiz_id',
        'question_text',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

}

