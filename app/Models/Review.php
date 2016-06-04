<?php

namespace Antoree\Models;

use Antoree\Models\Helpers\GravatarHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Review extends Model
{
    const MAX_RATE = 5;

    protected $table = 'reviews';

    protected $fillable = [
        'user_id', 'subject', 'content', 'rate',
        'name', 'email', 'website',
        'parent_id', 'approved', 'is_testimonial',
        'teaching_content', 'teaching_method', 'attitude_work', 'network_quality', 'value_received',
        'status_learn', 'learn_time', 'course','lesson_id', 'role_id','recomment','course_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_reviews', 'review_id', 'teacher_id');
    }

    public function scopeGetUserProfile($query)
    {
        return $query->addSelect(DB::raw('reviews.*,users.name,users.email'))
            ->leftjoin('users', 'users.id', '=', 'reviews.user_id');
    }

    public function isRegisteredUser()
    {
        return !empty($this->user_id);
    }

    public function getUserProfilePictureAttribute()
    {
        if ($this->isRegisteredUser()) {
            return $this->user->profile_picture;
        }
        return GravatarHelper::produce($this->email, 50, GravatarHelper::SET_IDENTICON);
    }

    public function getUserNameAttribute()
    {
        if ($this->isRegisteredUser()) {
            return $this->user->name;
        }
        return $this->name;
    }

    public function getUserUrlAttribute()
    {
        if ($this->isRegisteredUser()) {
            return 'mailto:' . $this->user->email;
        }

        if (empty($this->attributes['website'])) {
            return 'mailto:' . $this->attributes['email'];
        }

        return $this->attributes['website'];
    }

    // public function getContentAttribute()
    // {
    //     if (empty($this->attributes['content'])) {
    //         return '';
    //     }
    //     return '<p>' . implode('</p><p>', explode(PHP_EOL, $this->attributes['content'])) . '</p>';
    // }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }
}
