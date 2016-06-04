<?php

namespace Antoree\Models;

use Antoree\Models\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

use Antoree\Http\Requests;
class Teacher extends Model
{
    const REQUESTED = 0;
    const APPROVED = 1;
    const VERIFIED = 2;
    const REJECTED = 4;
    const CREATED = 5;

    const NOT_VERIFY = 0;
    const STATUS_APPROVER = 1;
    const STATUS_DENY = 2;

    const CLOSE_NOT_VERIFY = 0;
    const CLOSE_NO = 1;
    const CLOSE_YES = 2;

    protected $table = 'teachers';

    protected $fillable = [
    'user_id', 'approver_id', 'short_description',
    'status', 'rank', 'youtube',
    'languages', 'available_times', 'paid_per_hour',
    'certificates', 'about_me', 'methodology',
    'target_help', 'target_students', 'target_student_achievements',
    'experience', 'know_us_from', 'know_us_from_detail', 'tagline',
    'teaching_status', 'available_status', 'note', 'schedule_time','publish_status', 'approver_status','close_noti','order',
    ];

    public function getAll(){
        $data = self::addSelect(DB::raw('teachers.created_at as created_at_tutor'))
        ->with('userProfile')->with('topics')->notSoftDeleted()->orderBy('teachers.created_at', 'desc');
        // $data->with('topics');
        // dd($data);
        // $data =DB::table('teachers')
        //                 ->select('teachers.id as teacher_id', 'user_id', 'teaching_status', 'available_status',  'note', 'schedule_time',
        //                 'users.skype as user_skype', 'users.facebook as user_facebook', 'users.gender as user_gender', 'users.name as user_name', 'users.email as user_email', 'users.phone as user_phone', 'users.country as user_country')
        //                 ->leftJoin('users', 'teachers.user_id', '=', 'users.id')
        //                 ->get();
        return $data;
    }

    public function scopePublicizableListTeach($query)
    {
        return $query->addSelect(DB::raw('teachers.id,teachers.about_me,teachers.tagline, count(review_id) as total_review,SUM(reviews.rate) as sum, AVG(reviews.rate) as average, teachers.created_at as created_at_tutor'))
        ->leftjoin('teacher_reviews', 'teachers.id', '=', 'teacher_reviews.teacher_id')
        ->leftjoin('reviews', 'reviews.id', '=', 'teacher_reviews.review_id')
        ->groupBy('teachers.id')
        // ->orderBy('average', 'desc')
        ->orderBy('teachers.created_at', 'desc');
    }

    public function scopePublicizableListTeachApprover($query)
    {
        return $query->where('approver_status','=',self::STATUS_APPROVER)
        ->orderBy('teachers.created_at', 'desc');
    }

    public function scopePublicizableListTeachNotApprover($query)
    {
        return $query->where('approver_status','<>',self::STATUS_APPROVER)
        ->orderBy('teachers.created_at', 'desc');
    }

    public function getLanguagesAttribute()
    {
        if (empty($this->attributes['languages'])) {
            return [];
        }
        return explode(',', $this->attributes['languages']);
    }

    public function getHtmlAboutMeAttribute()
    {
        if (empty($this->attributes['about_me'])) {
            return '';
        }
        return '<p>' . implode('</p><p>', explode(PHP_EOL, htmlspecialchars($this->attributes['about_me']))) . '</p>';
    }

    public function getLanguageNamesAttribute()
    {
        if (empty($this->attributes['languages'])) {
            return [];
        }

        $languages = explode(',', $this->attributes['languages']);
        $locales = allLocales();
        foreach ($languages as &$language) {
            $language = $locales[$language]['native'];
        }
        return $languages;
    }

    public function getYoutubeVideoIdAttribute()
    {
        if (empty($this->attributes['youtube'])) return null;
        preg_match(AppHelper::REGEX_YOUTUBE_URL, $this->youtube, $matches);
        return $matches[4];
    }

    public function userProfile()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userProfileAdmin()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function scopeNotSoftDeleted($query){
        $query->addSelect(DB::raw('teachers.id as userid,teachers.*,users.*'));
        $query->join('users', 'teachers.user_id', '=', 'users.id');
        return $query->whereNull('users.deleted_at')->orderBy('teachers.created_at', 'desc');
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'topics_teachers', 'teacher_id', 'topic_id');
    }

    public function fields()
    {
        return $this->belongsToMany(Topic::class, 'working_fields_teachers', 'teacher_id', 'fields_id');
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'id', 'teacher_id');
    }

    public function reviews()
    {
        return $this->belongsToMany(Review::class, 'teacher_reviews', 'teacher_id', 'review_id');
    }

    public function getPointedAverageRateAttribute()
    {
        return round($this->reviews()->approved()->avg('rate'), 2);
    }

    public function getAverageRateAttribute()
    {
        return (int)round($this->reviews()->approved()->avg('rate'));
    }

    public function getTeachingHoursAttribute()
    {
        return 0;
    }

    public function scopeApproved($query)
    {
        return $query->where('status', Teacher::APPROVED);
    }

    public function isPublicizable()
    {
        return $this->teaching_status > 0 && $this->publish_status == 1;
        // return $this->status == self::VERIFIED || $this->status == self::APPROVED;
    }

    public function scopePublicizable($query)
    {
        return $query->where(function ($query) {
            $query->where('teaching_status', '>' ,0);
                // ->where('status', Teacher::APPROVED)
                // ->orWhere('status', Teacher::VERIFIED);
        });
        // dd($query->get()->toArray());
    }

    public function scopePublicizableList($query)
    {
        $data = Cache::rememberForever('tutors', function() use ($query)
        {
            return $query->addSelect(DB::raw('teachers.id,teachers.about_me,teachers.tagline, count(review_id) as total_review,SUM(reviews.rate) as sum, AVG(reviews.rate) as average, users.name, users.gender, users.profile_picture, users.voice, users.country, users.nationality'))
            ->leftjoin('teacher_reviews', 'teachers.id', '=', 'teacher_reviews.teacher_id')
            ->leftjoin('reviews', 'reviews.id', '=', 'teacher_reviews.review_id')
            ->leftjoin('users', 'teachers.user_id', '=', 'users.id')
            ->whereRaw('teachers.teaching_status > 0 and teachers.publish_status = 1')
            ->groupBy('teachers.id')
            ->orderBy('teachers.order','desc')
            ->orderBy('total_review', 'desc')
            ->orderBy('average', 'desc')
            ->with('topics')->get();
            // return $query;
        });
        return $data;
    }

    public function scopeOnline($query)
    {
        return $query->whereExists(function ($query) {
            $query->select(DB::raw(1))
            ->from('sessions')
            ->whereRaw('sessions.user_id = teachers.user_id');
        });
    }

    public function scopePublicFilter($query, $gender, $country, $online)
    {
        if (!empty($gender) || !empty($country)) {
            $query->join('users', 'teachers.user_id', '=', 'users.id');
            // $query->select('teachers.*');
        }

        if (!empty($gender)) {
            $query->where('users.gender', $gender);
        }

        if (!empty($country)) {
            if ($country == 'international') {
                $query->whereNotIn('users.country', ['VN', 'US', 'GB', 'AU']);
            } elseif ($country == 'native_countries') {
                $query->whereIn('users.country', ['US', 'GB', 'AU']);
            } else {
                $query->where('users.country', $country);
            }
        }

        if ($online) {
            $query->whereExists(function ($query) {
                $query->select(DB::raw(1))
                ->from('sessions')
                ->whereRaw('sessions.user_id = teachers.user_id');
            });
        }

        return $query;
    }

    //Filter Teacher
    public function scopeTeacherFilter($query, Request $request, $startDate, $endDate)
    {
        if ($startDate !== false) {
            $query = $query->where('teachers.created_at', '>=', $startDate);
        }

        if ($endDate !== false) {
            $query = $query->where('teachers.created_at', '<=', $endDate);
        }

        if($request->get('user_gender')){
            if($request->get('user_gender') == 'fe'){
                $query = $query->where('gender', 'female');
            }
            else{
                $query = $query->where('gender', $request->get('user_gender'));
            }
        }

        if($request->get('user_country')){
            $query = $query->where('country', $request->get('user_country'));
        }

        if($request->get('teaching_status') || $request->get('teaching_status') == '0'){
            $query = $query->where('teaching_status', $request->get('teaching_status'));
        }

        if($request->get('available_status') || $request->get('available_status') == '0'){
            $query = $query->where('available_status', $request->get('available_status'));
        }

        if($request->get('publish_status') || $request->get('publish_status') == '0'){
            $query = $query->where('publish_status', $request->get('publish_status'));
        }

        if($request->get('approver_status') || $request->get('approver_status') == '0'){
            $query = $query->where('approver_status', $request->get('approver_status'));
        }

        return $query;
    }
}
