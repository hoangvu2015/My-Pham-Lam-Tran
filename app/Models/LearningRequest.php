<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class LearningRequest extends Model
{
    const APPLY = 'apply';
    const CANCEL = 'cancel';
    const AWAITING = 'awaiting';
    const TRIAL = 'trial';
    const READY = 'ready';

    public $table = 'learning_requests';

    protected $fillable = ['channel_id','student_id', 'teacher_id', 'course_id', 'status'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function channel()
    {
        return $this->hasOne(RealtimeChannel::class, 'id', 'channel_id');
    }

    public static function sstart($key)
    {
        if (!self::sexist($key)) {
            self::sstop();
            Session::put('learning_request.req_session', $key);
        }
    }

    public static function supdateTopic($topic)
    {
        Session::put('learning_request.topic', $topic);
    }

    public static function supdateCourse($course)
    {
        Session::put('learning_request.course', $course);
    }

    public static function supdateTeacher($teacher)
    {
        Session::put('learning_request.teacher', $teacher);
    }

    public static function stopic()
    {
        return Session::get('learning_request.topic');
    }

    public static function scourse()
    {
        return Session::get('learning_request.course');
    }

    public static function steacher()
    {
        return Session::get('learning_request.teacher');
    }

    public static function sexist($key = '')
    {
        return Session::has('learning_request') && (!empty($key) && Session::get('learning_request.req_session') == $key);
    }

    public static function sstop()
    {
        Session::forget('learning_request');
    }
}
