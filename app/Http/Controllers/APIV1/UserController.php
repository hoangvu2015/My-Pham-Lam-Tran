<?php

namespace Antoree\Http\Controllers\APIV1;

use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\CallableObject;
use Antoree\Models\Helpers\DateTimeHelper;
use Antoree\Models\Themes\LmsThemeFacade;
use Antoree\Models\User;
use Antoree\Models\UserEducation;
use Antoree\Models\UserRecord;
use Antoree\Models\UserWork;
use Antoree\Models\Helpers\StoredAudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Antoree\Http\Requests;
use Antoree\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function getUserCurrentAuth()
    {
        return response()->json(['is_auth'=>$this->is_auth,'user'=>$this->auth_user]);
    }

    public function getBadge(Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        if ($request->has('html')) {
            return $this->htmlBadge($user);
        }

        return $this->jsonBadge($user);
    }

    protected function htmlBadge(User $user)
    {
        return response(view()->make(LmsThemeFacade::page('user.badge'), [
            'is_owner' => $this->is_auth && $this->auth_user->id == $user->id,
            'user_profile' => $user,
            'user_url' => localizedURL('user/{id?}', ['id' => $user->id]),
            ])->render(), 200, [
        'Content-Type' => 'text/html;charset=UTF-8'
        ]);
    }

    protected function jsonBadge(User $user)
    {
        return response()->json([
            'profile_picture' => $user->profile_picture,
            'name' => $user->name,
            'member_since' => $user->memberSince,
            'member_days' => $user->memberDays,
            'roles' => $user->roles->pluck('name')->all(),
            ]);
    }

    //SOCIAL
    protected function connectFacebook(Request $request)
    {
        $user = $this->auth_user;
        $nameUserPic = last(explode('/', $user->profile_picture));
        
        $user->conn_facebook_id = $request->get('id');
        if($nameUserPic == 'default.png'){
            $user->profile_picture = 'https://graph.facebook.com/'.$request->get('id').'/picture?width=200&height=200';
        }
        $user->save();

        return response()->json([
            'success' => true,
            'data' =>$user
            ]);
    }

    protected function disconnectFacebook(Request $request)
    {
        $user = $this->auth_user;
        $user->conn_facebook_id = null;
        $user->save();

        return response()->json([
            'success' => true,
            'data' =>$user
            ]);
    }

    protected function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'   => 'required|confirmed|min:6',
            ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => true,
                'data' => $validator->errors()
                ]);
        }

        $user = $this->auth_user;

        if($user){

            $user->password = bcrypt($request->get('password'));
            
            $user->save();

            return response()->json([
                'success' => true,
                'data' =>$request->all()
                ]);
        }

        return response()->json([
            'error' => true,
            ]);
    }

    protected function updateInfoUser(Request $request)
    {
        $user = $this->auth_user;

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'date_of_birth' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            'gender' => 'required|in:' . implode(',', allGenders()),
            'phone_code' => 'required|in:' . implode(',', allCountryCodes()),
            'phone' => 'required|max:255',
            'address' => 'sometimes|required|max:255',
            'city' => 'sometimes|max:255',
            'country' => 'required|in:--,' . implode(',', allCountryCodes()),
            ]);

        if ($validator->fails())
        {
            return response()->json([
                'errors' => true,
                'data' => $validator->errors()
                ]);
        }

        DB::beginTransaction();
        try {
            $user->name = $request->get('name');
            $slug = toSlug($user->name);
            if (User::where('slug', $slug)->count() > 0) {
                $user->slug = $slug . '-' . $user->id;
            } else {
                $user->slug = $slug;
            }
            $user->phone_code = $request->get('phone_code', '');
            $user->phone = $request->get('phone');
            $user->date_of_birth = toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->get('date_of_birth'), true);
            $user->gender = $request->get('gender');
            $user->address = $request->get('address', '');
            $user->city = $request->get('city', '');
            $user->country = $request->get('country');
            $user->nationality = $request->get('nationality');
            $user->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'error_db' => true,
                'data' => [trans('error.database_insert') . ' (' . $ex->getMessage() . ')']
                ]);
        }

        return response()->json([
            'success' => true,
            'data' =>$user
            ]);
    }

// User Work =========================
    protected function addUserWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company' => 'required|max:255',
            'position' => 'sometimes|max:255',
            'start' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            'end' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => true,
                'data' => $validator->errors()
                ]);
        }

        $work = UserWork::create([
            'user_id' => $this->auth_user->id,
            'company' => $request->get('company'),
            'position' => $request->get('position', ''),
            'description' => $request->get('description', ''),
            'start' => $request->has('start') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->get('start')) : null,
            'end' => $request->has('end') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->get('end')) : null,
            ]);
        if($work){
            return response()->json([
                'success' => true,
                'data' =>$work
                ]);
        }

        return response()->json([
            'error' => true,
            ]);
    }

    protected function updateUserWork(Request $request)
    {
        if ($request->has('id')) {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:user_works,id',
                'company' => 'required|max:255',
                'position' => 'sometimes|max:255',
                'start' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
                'end' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
                ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => true,
                    'data' => $validator->errors()
                    ]);
            }

            $work = UserWork::findOrFail($request->get('id'));
            $work->company = $request->get('company');
            $work->position = $request->get('position', '');
            $work->description = $request->get('description', '');
            $work->start = $request->has('start') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->get('start')) : null;
            $work->end = $request->has('end') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->get('end')) : null;
            $work->current = $request->has('current');
            $work->save();

            return response()->json([
                'success' => true,
                'data' =>$work
                ]);
        }

        return response()->json([
            'error' => true,
            ]);
    }

    protected function deleteUserWork(Request $request)
    {
        if ($request->has('id')) {

            $work = UserWork::findOrFail($request->get('id'));
            $work->delete();

            return response()->json([
                'success' => true,
                'data' =>$work
                ]);
        }

        return response()->json([
            'error' => true,
            ]);
    }

// User Edu =========================
    protected function updateUserEdu(Request $request)
    {
        if ($request->has('id')) {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:user_educations,id',
                'school' => 'required|max:255',
                'field' => 'sometimes|max:255',
                'start' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
                'end' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
                ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => true,
                    'data' => $validator->errors()
                    ]);
            }

            $education = UserEducation::findOrFail($request->get('id'));
            $education->school = $request->get('school');
            $education->field = $request->get('field', '');
            $education->description = $request->get('description', '');
            $education->start = $request->has('start') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->get('start')) : null;
            $education->end = $request->has('end') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->get('end')) : null;
            $education->save();

            return response()->json([
                'success' => true,
                'data' =>$education
                ]);
        }

        return response()->json([
            'error' => true,
            ]);
    }

    protected function addUserEdu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school' => 'required|max:255',
            'field' => 'sometimes|max:255',
            'start' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            'end' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => true,
                'data' => $validator->errors()
                ]);
        }

        $education = UserEducation::create([
            'user_id' => $this->auth_user->id,
            'school' => $request->get('school'),
            'field' => $request->get('field', ''),
            'description' => $request->get('description', ''),
            'start' => $request->has('start') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->get('start')) : null,
            'end' => $request->has('end') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->get('end')) : null
            ]);

        if($education){
            return response()->json([
                'success' => true,
                'data' =>$education
                ]);
        }

        return response()->json([
            'error' => true,
            ]);
    }

    protected function deleteUserEdu(Request $request)
    {
        if ($request->has('id')) {

            $education = UserEducation::findOrFail($request->get('id'));
            $education->delete();

            return response()->json([
                'success' => true,
                'data' =>$education
                ]);
        }

        return response()->json([
            'error' => true,
            ]);
    }
// User Cer =========================
    protected function addUserCer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'recorded_at' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            'organization' => 'sometimes|max:255',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => true,
                'data' => $validator->errors()
                ]);
        }

        $record = UserRecord::create([
            'user_id' => $this->auth_user->id,
            'name' => $request->get('name'),
            'description' => $request->get('description', ''),
            'recorded_at' => $request->has('recorded_at') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->get('recorded_at')) : null,
            'organization' => $request->get('organization', ''),
            'type' => UserRecord::CERTIFICATE
            ]);

        if($record){
            return response()->json([
                'success' => true,
                'data' =>$record
                ]);
        }

        return response()->json([
            'error' => true,
            ]);
    }

    protected function updateUserCer(Request $request)
    {
        if ($request->has('id')) {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:user_records,id,type,' . UserRecord::CERTIFICATE,
                'name' => 'required|max:255',
                'recorded_at' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
                'organization' => 'sometimes|max:255',
                ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => true,
                    'data' => $validator->errors()
                    ]);
            }

            $record = UserRecord::findOrFail($request->get('id'));
            $record->name = $request->get('name');
            $record->description = $request->get('description', '');
            $record->recorded_at = $request->has('recorded_at') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->get('recorded_at')) : null;
            $record->organization = $request->get('organization', '');
            $record->save();

            return response()->json([
                'success' => true,
                'data' =>$record
                ]);
        }

        return response()->json([
            'error' => true,
            ]);
    }

    protected function deleteUserCer(Request $request)
    {
        if ($request->has('id')) {

            $record = UserRecord::findOrFail($request->get('id'));
            $record->delete();

            return response()->json([
                'success' => true,
                'data' =>$record
                ]);
        }

        return response()->json([
            'error' => true,
            ]);
    }

    protected function updateAudio(Request $request)
    {
        // dd('ok',$request->file('file'));
        $user = User::findOrFail($request->get('user_id'));

        if($user){
            if (!empty($request->file('file')))
            {
                $audio = new StoredAudio();

                if ($user->voice)
                {
                    $arr = explode("/", $user->voice);
                    $voice_name = last($arr);
                    $audio->deleteVoiceTeacher($voice_name, $user);
                }
                $file = $request->file('file');
                $audio = $audio->fromUploadedDataVoiceTeacher($file[0], $user);
                // dd('ok');
                $user->voice = $audio->targetFileAsset;
            }

            $user->save();

            return response()->json([
                'success' => true,
                'user' =>$user
                ]);
        }

        return response()->json([
            'error' => true,
            ]);
        
    }
}
