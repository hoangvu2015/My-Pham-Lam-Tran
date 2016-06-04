<?php

namespace Antoree\Models;

use Antoree\Models\Helpers\DateTimeHelper;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait, SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'provider', 'provider_id',
        'profile_picture', 'name', 'slug', 'channel_id',
        'phone_code', 'phone', 'phone_verified', 'skype', 'facebook',
        'gender', 'date_of_birth', 'voice', 'interests',
        'address', 'city', 'country', 'fastest_contact_ways',
        'bio', 'language', 'timezone',
        'first_day_of_week',
        'long_date_format',
        'short_date_format',
        'short_time_format',
        'activation_code', 'active', 'remember_token', 'auto_create','conn_facebook_id',
        'nationality'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
        'deleted_at', 'created_at', 'updated_at',
        'active', 'activation_code', 'phone_verified',
        'provider', 'provider_id',
    ];

    protected $idle;

    public function getOwnDirectoryAttribute()
    {
        return 'user_' . $this->id;
    }

    public function getDateOfBirthAttribute()
    {
        return empty($this->attributes['date_of_birth']) || $this->attributes['date_of_birth'] == '0000-00-00 00:00:00' ? '' : DateTimeHelper::getInstance()->shortDate($this->attributes['date_of_birth']);
    }

    public function getAgeAttribute()
    {
        if (empty($this->attributes['date_of_birth']) || $this->attributes['date_of_birth'] == '0000-00-00 00:00:00') {
            return '';
        }

        return DateTimeHelper::diffYear($this->attributes['date_of_birth']);
    }

    public function getMemberSinceAttribute()
    {
        return DateTimeHelper::getInstance()->shortDate($this->attributes['created_at']);
    }

    public function getMemberDaysAttribute()
    {
        return DateTimeHelper::diffDay($this->attributes['created_at']);
    }

//    public function roles()
//    {
//        return $this->belongsToMany(Role::class,'role_user', 'user_id', 'role_id');
//    }

    /**
     * @return Teacher
     */
    public function teacherProfile()
    {
        return $this->hasOne(Teacher::class, 'user_id', 'id');
    }

    /**
     * @return Student
     */
    public function studentProfile()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    public function notificationChannel()
    {
        return $this->hasOne(RealtimeChannel::class, 'id', 'channel_id');
    }

    public function channels()
    {
        return $this->belongsToMany(RealtimeChannel::class, 'realtime_subscribers', 'user_id', 'channel_id');
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class, 'user_id', 'id');
    }

    public function sessions()
    {
        return $this->belongsTo(UserSession::class, 'id', 'user_id');
    }

    public function works()
    {
        return $this->hasMany(UserWork::class, 'user_id', 'id');
    }

    public function educations()
    {
        return $this->hasMany(UserEducation::class, 'user_id', 'id');
    }

    public function records()
    {
        return $this->hasMany(UserRecord::class, 'user_id', 'id');
    }

    public function articles()
    {
        return $this->hasMany(BlogArticle::class, 'auth_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'user_id', 'id');
    }

    public function isOnline()
    {
        $sessions = $this->sessions();
        if ($sessions->count() > 0) {
            $last_session = $sessions->orderBy('last_activity', 'desc')->first();
            $this->idle = (time() - $last_session->last_activity) / 60 > config('session.switch_to_idle');
            return true;
        }
        return false;
    }

    public function isIdle()
    {
        return $this->idle;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCustomercare($query)
    {
        return $query->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('role_user')
                ->whereRaw('role_user.user_id = users.id and role_user.role_id = 10');
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTeacherRole($query)
    {
        return $query->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('role_user')
                ->whereRaw('role_user.user_id = users.id and role_user.role_id = 7');
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStudentRole($query)
    {
        return $query->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('role_user')
                ->whereRaw('role_user.user_id = users.id and role_user.role_id = 6');
        });
    }

    public function scopeFilter($query, $searchNameEmailCc)
    {
        if (!empty($searchNameEmailCc)) {
            $query
            ->where('name', 'like', '%'.$searchNameEmailCc.'%')
            ->orWhere('phone', 'like', '%'.$searchNameEmailCc.'%')
            ->orWhere('email', 'like', '%'.$searchNameEmailCc.'%')
            ->orWhere('skype', 'like', '%'.$searchNameEmailCc.'%');
            // dd('search',$query->get());
        }else{
            $query->addSelect(DB::raw('*'));
        }

        return $query;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnline($query)
    {
        return $query->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('sessions')
                ->whereRaw('sessions.user_id = users.id');
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOffline($query)
    {
        return $query->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('sessions')
                ->whereRaw('sessions.user_id = users.id');
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $email
     * @param string $provider
     * @param string $provider_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFromSocial($query, $email, $provider, $provider_id)
    {
        return $query->where('email', $email)->orWhere(function ($query) use ($provider, $provider_id) {
            $query->where('provider', $provider)
                ->where('provider_id', $provider_id);
        });
    }

    public function advancedAttachRole($role)
    {
        $role_object = $role;
        if (is_object($role)) {
            $role = $role->getKey();
        } elseif (is_array($role)) {
            $role = $role['id'];
            $role_object = Role::findOrFail($role);
        } else {
            $role_object = Role::findOrFail($role);
        }
        switch ($role_object->name) {
            case 'teacher':
                Teacher::create([
                    'user_id' => $this->id,
                    'status' => Teacher::CREATED
                ]);
                break;
            case 'student':
                Student::create([
                    'user_id' => $this->id,
                ]);
                break;
            default:
                break;
        }
        $this->attachRole($role);
    }

    public static function advancedCreate(array $attributes = [])
    {
        $channel = RealtimeChannel::create([
            'secret' => RealtimeChannel::generateKey('nt_'),
            'type' => 'notification'
        ]);
        $attributes['channel_id'] = $channel->id;
        return self::create($attributes);
    }

    public static function checkTrashedRestoreWithEmail($email)
    {
        //Check User Delete.
        $user_delete = self::withTrashed()
        ->where('email', $email)
        ->first();

        if($user_delete){
            $user_delete->restore();

            return $user_delete;
        }

        return false;
    }
}
