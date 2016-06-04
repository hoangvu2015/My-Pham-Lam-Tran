<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
    'user_id','approver_id', 'count_register'
    ];

    public function getAll(){
        $data = self::with('userProfile')->orderBy('created_at', 'desc')->get();
        return $data;
    }

    public function userProfile()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function TmpLearningRequests()
    {
        return $this->hasOne(TmpLearningRequest::class, 'user_id', 'id');
    }

    public function scopeFilter($query, $searchNameEmailCc = '')
    {
        if (!empty($searchNameEmailCc)) {
            $query->addSelect(DB::raw('students.id as student_id, students.count_register as student_count_register, users.name, users.email,users.created_at'))
            ->leftjoin('users', 'students.user_id', '=', 'users.id')

            ->leftjoin('tmp_learning_requests', 'tmp_learning_requests.user_id', '=', 'students.user_id')

            ->where('users.name', 'like', '%'.$searchNameEmailCc.'%')
            ->orWhere('users.email', 'like', '%'.$searchNameEmailCc.'%')
            ->orWhere('users.phone', 'like', '%'.$searchNameEmailCc.'%')
            ->orWhere('users.skype', 'like', '%'.$searchNameEmailCc.'%')
            ->groupBy('students.user_id');
        }else{
            $query->addSelect(DB::raw('students.id as student_id, students.count_register, users.name, users.email,users.created_at'))

            ->leftjoin('users', 'students.user_id', '=', 'users.id')
            ->leftjoin('tmp_learning_requests', 'tmp_learning_requests.user_id', '=', 'students.user_id')
            ->groupBy('students.user_id');
        }

        return $query;
    }
}
