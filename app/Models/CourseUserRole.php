<?php

namespace Antoree\Models;

use Antoree\Models\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Antoree\Models\User;
use Antoree\Models\Lesson;

class CourseUserRole extends Model
{
    const ROLE_CUS_CARE  = 10;
    const ROLE_TEACHER = 7;
    const ROLE_STUDENT = 6;

    public $timestamps = false;

    protected $table = 'courses_users_roles';
    protected $fillable = ['course_id', 'user_id', 'role_id'];

    /**
     * Get list Courses of User
     */
    public function scopeGetCoursesOfUser($query, User $user)
    {
        return $query
        ->where('user_id','=',$user->id)
        ->groupBy('courses_users_roles.course_id')
        ;

        return $query;
    }

    /**
     * Get list User Role of Course
     */
    protected function getUserRoleOfCourse($course_id, $role_id)
    {
        $row  = self::where('course_id',$course_id)->where('role_id',$role_id)->first();
        if($row){
            $user = User::find($row->user_id);

            return $user;
        }
        return null;
    }

    protected function getLessonOfCourse($course_id)
    {
        $lesson = Lesson::join('courses_lessons','courses_lessons.lesson_id','=','lessons.id')
        ->where('courses_lessons.course_id',$course_id)
        ->where('lessons.learn_date','>=',date('Y-m-d H:i:s'))
        ->orderBy('lessons.learn_date','asc')
        ->addSelect(DB::raw('lessons.learn_date as learn_date'))
        ->first();
        // dd(date('Y-m-d H:i:s'));
        return $lesson;
    }

    /**
     * Advanced Create
     */
    protected function addvancedCreate($data)
    {
        $cur = self::where('course_id', '=', $data['course_id'])
        ->where('user_id', '=', $data['user_id'])
        ->where('role_id', '=', $data['role_id'])
        ->first();
        if($cur) return false;

        return self::create($data);
    }

    /**
     * Get all user_id of couser with role.
     */
    protected function getUserIDRoles($id,$role)
    {
        $data = [];
        $course_role = self::where('course_id', '=', $id)
        ->where('role_id', '=', $role)
        ->get();
        foreach ($course_role as $key => $value) {
            array_push($data, $value['user_id']);
        }
        return $data;
    }

    /**
     * Sync role for user (Course)
     */
    protected function syncCouserRoleUser(array $listUser, $course_id ,$role)
    {
        $course_role = self::where('course_id', '=', $course_id)
        ->where('role_id', '=', $role)
        ->get();

        //delete not user in course_role_user
        foreach ($course_role as $key => $value) {
            if(!in_array($value->user_id, $listUser)){
                DB::table('courses_users_roles')->where('course_id', '=', $course_id)
                ->where('user_id', '=', $value->user_id)
                ->where('role_id', '=', $role)
                ->delete();
            }
        }

        //add user in course_role_user
        foreach ($listUser as $key => $value) {
            $tmp = DB::table('courses_users_roles')->where('course_id', '=', $course_id)
            ->where('user_id', '=', $value)
            ->where('role_id', '=', $role)->first();
            if (!$tmp) {
                self::addvancedCreate([
                    'course_id'=>$course_id,
                    'user_id'=>$value,
                    'role_id'=>$role
                    ]);
            }
        }
    }
}
