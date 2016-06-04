<?php

namespace Antoree\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class WorkingFields extends Model
{
    use Translatable;
    public $useTranslationFallback = true;

    protected $table = 'working_fields';
    protected $fillable = ['name', 'slug', 'description'];

    protected $translationForeignKey = 'fields_id';
    public $translatedAttributes = ['name', 'slug', 'description'];

    // public function courses()
    // {
    //     return $this->belongsToMany(Course::class, 'topics_courses', 'topic_id', 'course_id');
    // }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'working_fields_teachers', 'fields_id', 'teacher_id');
    }
}

class WorkingFieldsTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'working_fields_translations';
    protected $fillable = ['name', 'slug', 'description'];
}