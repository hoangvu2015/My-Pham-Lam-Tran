<?php

namespace Antoree\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use Translatable;
    public $useTranslationFallback = true;

    protected $table = 'topics';
    protected $fillable = ['name', 'slug', 'description'];

    protected $translationForeignKey = 'topic_id';
    public $translatedAttributes = ['name', 'slug', 'description'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'topics_courses', 'topic_id', 'course_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'topics_teachers', 'topic_id', 'teacher_id');
    }
}

class TopicTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'topic_translations';
    protected $fillable = ['name', 'slug', 'description'];
}