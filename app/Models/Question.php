<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    const STATUS_PRIVATE = 0;
    const STATUS_PUBLISHED = 1;

    protected $table = 'questions';
    protected $fillable = ['content', 'user_id', 'parent_id', 'status', 'audio'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'tests_questions', 'question_id', 'test_id');
    }

    public function parent()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id')->orderBy('order', 'asc');
    }
}
