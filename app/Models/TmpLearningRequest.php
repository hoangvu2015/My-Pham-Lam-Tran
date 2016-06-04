<?php

namespace Antoree\Models;

use Antoree\Models\Helpers\DateTimeHelper;
use Illuminate\Database\Eloquent\Model;

class TmpLearningRequest extends Model
{
    const SEXES = ['male', 'female'];
    const COUNT_SCHEDULES = [10, 20, 30, 40];
    const NEWLY = 'newly';
    const PROCESSED = 'process';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tmp_learning_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'student_id', 'teacher_id', 'user_id', 'locale', 'wizard_key',
    'name', 'email', 'phone',
    'facebook', 'voice', 'about_me', 'quick_test_time',
    'skype', 'course_expectation', 'goal',
    'count_schedules', 'duration', 'charge',
    'schedule_expectation', 'teacher_country', 'teacher_sex',
    'teacher_test_required', 'extra_information', 'status',
    'know_us_from','know_us_from_detail', 'purpose', 'teacher_like', 'teacher_like_orther',
    'exigency', 'how_before_learn', 'description_level', 'utm_source', 'utm_medium', 'utm_campaign', 'refererhostname', 
    'coupon_code', 'know_skype', 'coupon_code_offline','kid',
    'ip','browser','device','cancel','old','career','start_learn'
    ];

    public function getCreatedAtAttribute()
    {
        return DateTimeHelper::getInstance()->compound('shortDate', ' ', 'longTime', $this->attributes['created_at']);
    }

    public function scopeFilter($query, $startDate, $endDate, $status, $searchNameEmailCc = "", $user_id = "")
    {
        if (!empty($user_id)) {
            $query = $query->where('user_id','=',$user_id);
        }

        if ($startDate !== false) {
            $query = $query->where('created_at', '>=', $startDate);
        }
        if ($endDate !== false) {
            $query = $query->where('created_at', '<=', $endDate);
        }
        if (!empty($status)) {
            $query = $query->where('status', $status);
        }
        if (!empty($searchNameEmailCc)) {
            $query = $query->where('name', 'like', '%'.$searchNameEmailCc.'%')
            ->orWhere('email', 'like', '%'.$searchNameEmailCc.'%')
            ->orWhere('phone', 'like', '%'.$searchNameEmailCc.'%')
            ->orWhere('skype', 'like', '%'.$searchNameEmailCc.'%')
            ->orWhere('user_id', 'like', '%'.$searchNameEmailCc.'%')
            ->orWhere('id', 'like', '%'.$searchNameEmailCc.'%')
            ;
        }

        return $query;
    }

    public function userInfo()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function userProfile()
    {
        return $this->hasOne(User::class, 'id', 'teacher_id');
    }

    public function teacherProfile()
    {
        return $this->userProfile->teacherProfile;
    }

    public function deviceRequest($learningRequest)
    {
            $learningRequest->ip = get_client_ip();
            $learningRequest->browser = $_SERVER['HTTP_USER_AGENT'];
            if(isDesktopClient()){
                $learningRequest->device = 'Desktop';
            }
            if(isPhoneClient()){
                $learningRequest->device = 'Phone';
            }
            if(isMobileClient()){
                $learningRequest->device = 'Mobile';
            }
            if(isTabletClient()){
                $learningRequest->device = 'Tablet';
            }
            $learningRequest->save();

         return $learningRequest;
    }
}
