<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    const RIGHT_STATUS = 1;
    const WRONG_STATUS = 0;

    const VALUE_UNSET = 2;
    const VALUE_CORRECT = 1;
    const VALUE_INCORRECT = 0;

    protected $table = 'answers';
    protected $fillable = ['content', 'question_id', 'correct', 'order', 'status'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
}

