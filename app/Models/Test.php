<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    const PUBLIC_STATUS = 1;
    const PRIVATE_STATUS = 0;

    protected $table = 'tests';
    protected $fillable = ['name', 'slug', 'description', 'content', 'user_id', 'status', 'minute'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lessons_tests', 'test_id', 'lesson_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'tests_questions', 'test_id', 'question_id')
            ->withPivot('order')->orderBy('order', 'desc');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_tests', 'test_id', 'course_id');
    }
}
