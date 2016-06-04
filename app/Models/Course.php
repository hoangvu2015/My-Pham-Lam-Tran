<?php

namespace Antoree\Models;

use Antoree\Models\Helpers\AppHelper;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Antoree\Models\User;

class Course extends Model
{
    const STATUS_PRIVATE = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_REQUESTED = 2;
    const STATUS_REJECTED = 3;

    const STATUS_REAL = 0;
    const STATUS_TRIAL = 1;

    // use Translatable;
    protected $table = 'courses';
    protected $fillable = [
    'user_id', 'learning_hours', 'price', 'status', 'name', 'description', 'image_url', 'slug', 'content',
    'start_date','end_date','note','status_trial','salary_hour','title','des','is_close','date_close','current_paid',
    'current_paid_tutor','learner_salary_hour'
    ];

    // public $useTranslationFallback = true;
    // protected $translationForeignKey = 'course_id';
    // public $translatedAttributes = ['name', 'description', 'content', 'slug'];


    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'topics_courses', 'course_id', 'topic_id');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'courses_lessons', 'course_id', 'lesson_id')
        ->withPivot('order')->orderBy('order', 'desc');
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'courses_tests', 'course_id', 'test_id')
        ->withPivot('order')->orderBy('order', 'desc');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reviews()
    {
        return $this->belongsToMany(Review::class, 'course_reviews', 'course_id', 'review_id');
    }

    public function getPointedAverageRateAttribute()
    {
        return round($this->reviews()->approved()->avg('rate'), 2);
    }

    public function getAverageRateAttribute()
    {
        return (int)round($this->reviews()->approved()->avg('rate'));
    }

    public function scopePublished($query)
    {
        return $query->where('status', $this::STATUS_PUBLISHED);
    }

    public function lessonTime($month,$year)
    {
        return DB::table('courses')
        ->join('courses_lessons','courses.id','=','courses_lessons.course_id')
        ->join('courses_users_roles','courses_lessons.course_id','=','courses_users_roles.course_id')
        ->join('lessons','lessons.id','=','courses_lessons.lesson_id')
        ->join('users','users.id','=','courses_users_roles.user_id')
        ->whereMonth('lessons.learn_date','=',$month)->whereYear('lessons.learn_date','=',$year)
        ->where('courses_users_roles.role_id','=',7)
        ->addSelect(DB::raw('users.id as tutor_id, users.name as tutor_name, courses.id as course_id,
            courses.title as courses_name,
            courses.id as courses_id,
            courses.slug as courses_slug,
            sum(lessons.duration) as total_hour,
            courses.salary_hour as price_course,
            sum(lessons.duration) * courses.salary_hour as total_money'))
        ->groupBy('courses_users_roles.course_id')->orderBy('users.id','asc')
        ->get();
    }

    public function scopeListForUser($query, User $user)
    {
        if ($user->hasRole('learning-editor')) {
            return $query->where(function ($query) use ($user) {
                $query->where('status', $this::STATUS_PUBLISHED)
                ->orWhere('status', $this::STATUS_REQUESTED)
                ->orWhere('user_id', $user->id);
            });
        }
        return $query->where(function ($query) use ($user) {
            $query->where('status', $this::STATUS_PUBLISHED)
            ->orWhere('user_id', $user->id);
        });
    }

    public function isPublished()
    {
        return $this->status == $this::STATUS_PUBLISHED;
    }

    /**
     * @return array
     */
    public function getCurriculumItems()
    {
        $curriculum_items = [];
        foreach ($this->lessons as $lesson) {
            $trans_lesson = $lesson->translate(AppHelper::INTERNATIONAL_LOCALE_CODE);
            $curriculum_items[] = [
            'order' => $lesson->pivot->order,
            'id' => $lesson->id,
            'name' => $trans_lesson->name,
            'description' => $trans_lesson->description,
            'created_at' => $lesson->created_at,
            'type' => 'lesson',
            ];
        }
        foreach ($this->tests as $test) {
            $curriculum_items[] = [
            'order' => $test->pivot->order,
            'id' => $test->id,
            'name' => $test->name,
            'description' => $test->description,
            'created_at' => $test->created_at,
            'type' => 'test',
            ];
        }
        $curriculum_items = collect($curriculum_items)->sortByDesc('order')->values()->all();

        return $curriculum_items;
    }

    /**
     * Delete Course VS Lessons
     */
    public function deleteAdvancedCourse($id)
    {
        $course = self::find($id);
        if($course){
            $course_lesson = $course->lessons()->get();
            if($course_lesson){
                foreach ($course_lesson as $key => $value) {
                    $value->deleteReview($value->id);
                    $value->delete();
                }
            }
        }
        return $course->delete();
    }

    public function searchNameEmail($text)
    {
        return DB::table('courses')
        ->join('courses_users_roles','courses.course_id','=','courses_users_roles.course_id')
        ->join('users','users.id','=','courses_users_roles.user_id')
        ->where('courses_users_roles.role_id','=',7)
        ->get();
    }
}

class CourseTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'course_translations';
    protected $fillable = ['name', 'description', 'content', 'slug'];
}
