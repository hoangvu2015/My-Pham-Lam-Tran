<?php

namespace Antoree\Models;

use Antoree\Models\Helpers\DateTimeHelper;
use Illuminate\Database\Eloquent\Model;

class UserWork extends Model
{
    protected $table = 'user_works';

    protected $fillable = ['user_id', 'company', 'position', 'description', 'start', 'end', 'current'];

    public function getStartAttribute()
    {
        return empty($this->attributes['start']) || $this->attributes['start'] == '0000-00-00 00:00:00' ? '' : DateTimeHelper::getInstance()->shortDate($this->attributes['start']);
    }

    public function getEndAttribute()
    {
        return empty($this->attributes['end']) || $this->attributes['end'] == '0000-00-00 00:00:00' ? '' : DateTimeHelper::getInstance()->shortDate($this->attributes['end']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
