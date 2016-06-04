<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomUser extends Model
{
    protected $table = 'classrooms_users';

    protected $fillable = [
        'user_id','classroom_id','role_id'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class,'classrooms' ,'id', 'classroom_id');
    }
}
