<?php

namespace Antoree\Models;

use Antoree\Models\Helpers\DateTimeHelper;
use Illuminate\Database\Eloquent\Model;

class UserRecord extends Model
{
    const CERTIFICATE = 0;
    const REWARD = 1;
    const ACHIEVEMENT = 2;

    const STATUS_NOT_VERIFIED = 0;
    const STATUS_VERIFIED = 1;
    const STATUS_REQUESTED = 2;
    const STATUS_REJECTED = 3;

    protected $table = 'user_records';

    protected $fillable = [
        'user_id', 'name', 'description', 'image', 'source', 'organization', 'recorded_at',
        'verified_image_1', 'verified_image_2', 'verified_image_3', 'verified_image_4', 'verified_image_5', 'status', 'type'
    ];

    public function getRecordedAtAttribute()
    {
        return empty($this->attributes['recorded_at']) || $this->attributes['recorded_at'] == '0000-00-00 00:00:00' ? '' : DateTimeHelper::getInstance()->shortDate($this->attributes['recorded_at']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeOfCertificate($query)
    {
        return $query->where('type', $this::CERTIFICATE);
    }

    public function scopeOfReward($query)
    {
        return $query->where('type', $this::REWARD);
    }

    public function scopeOfAchievement($query)
    {
        return $query->where('type', $this::ACHIEVEMENT);
    }

    public function scopeVerified($query)
    {
        return $query->where('status', $this::STATUS_VERIFIED);
    }

    public function scopeNotVerified($query)
    {
        return $query->where('status', $this::STATUS_NOT_VERIFIED);
    }

    public function scopeRequested($query)
    {
        return $query->where('status', $this::STATUS_REQUESTED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', $this::STATUS_REJECTED);
    }
}
