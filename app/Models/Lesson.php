<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Antoree\Models\Helpers\DateTimeHelper;

use Antoree\Models\Review;
use Antoree\Models\Course;

class Lesson extends Model
{
    const STATUS_PRIVATE = 0;
    const STATUS_PUBLISHED = 1;

    const STATUS_REAL = 0;
    const STATUS_TRIAL = 1;

    // use Translatable;
    // public $useTranslationFallback = true;

    protected $table = 'lessons';
    protected $fillable = [
    'parent_id', 'user_id', 'name', 'slug', 'description', 'content', 'level', 'status',
    'title', 'des','slug', 'duration', 'learn_date', 'status_trial', 
    ];

    // protected $translationForeignKey = 'lesson_id';
    // public $translatedAttributes = ['name', 'slug', 'description', 'content'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne(Lesson::class, 'id', 'parent_id');
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'lessons_tests', 'lesson_id', 'test_id')
        ->withPivot('order');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_lessons', 'lesson_id', 'course_id');
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'topics_lessons', 'lesson_id', 'topic_id');
    }

    public function getLearnDatetribute()
    {
        return DateTimeHelper::getInstance()->compound('shortDate', ' ', 'longTime', $this->attributes['learn_date']);
    }

    public function deleteReview($lesson_id)
    {
        $review = Review::where('lesson_id','=',$lesson_id)->get();
        foreach ($review as $key => $value) {
            $value->delete();
        }

        return true;
    }

    public function getLessonCourseId($course_id)
    {
        
    }
}

class LessonTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'lesson_translations';
    protected $fillable = ['name', 'slug', 'description', 'content'];
}