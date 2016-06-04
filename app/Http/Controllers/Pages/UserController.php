<?php

namespace Antoree\Http\Controllers\Pages;

use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\CallableObject;
use Antoree\Models\Helpers\DateTimeHelper;
use Antoree\Models\User;
use Antoree\Models\UserEducation;
use Antoree\Models\UserRecord;
use Antoree\Models\UserWork;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Antoree\Http\Requests;
use Antoree\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends ViewController
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return view($this->themePage('user.edit'), [
            'max_upload_filesize' => maxUploadFileSize(),
            'user_profile' => $this->auth_user,
            'user_works' => $this->auth_user->works,
            'user_educations' => $this->auth_user->educations,
            'user_certificates' => $this->auth_user->records()->ofCertificate()->get(),
            'date_js_format' => DateTimeHelper::shortDatePickerJsFormat(),
            'record_status_not_verified' => UserRecord::STATUS_NOT_VERIFIED,
            'record_status_verified' => UserRecord::STATUS_VERIFIED,
            'record_status_requested' => UserRecord::STATUS_REQUESTED,
            'record_status_rejected' => UserRecord::STATUS_REJECTED,
            'is_owner' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $this->auth_user;

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'date_of_birth' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            'gender' => 'required|in:' . implode(',', allGenders()),
            'phone_code' => 'required|in:' . implode(',', allCountryCodes()),
            'phone' => 'required|max:255',
            'skype' => 'sometimes|max:255',
            'facebook' => 'sometimes|url',
            'address' => 'sometimes|max:255',
            'city' => 'sometimes|max:255',
            'country' => 'required|in:--,' . implode(',', allCountryCodes()),
            'language' => 'required|in:' . implode(',', allSupportedLocaleCodes()),
        ]);

        $redirect = redirect(localizedURL('user/edit'));

        if ($validator->fails()) {
            return $redirect->withInput()->withErrors($validator, 'account');
        }

        DB::beginTransaction();
        try {
            $user->name = $request->input('name');
            $slug = toSlug($user->name);
            if (User::where('slug', $slug)->count() > 0) {
                $user->slug = $slug . '-' . $user->id;
            } else {
                $user->slug = $slug;
            }
            $user->phone_code = $request->input('phone_code', '');
            $user->phone = $request->input('phone');
            $user->skype = $request->input('skype', '');
            $user->facebook = $request->input('facebook', '');
            $user->date_of_birth = toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('date_of_birth'), true);
            $user->gender = $request->input('gender');
            $user->address = $request->input('address', '');
            $user->city = $request->input('city', '');
            $user->country = $request->input('country');
            $user->language = $request->input('language');
            $user->interests = $request->input('interests', '');
            $user->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return $redirect->withErrors([trans('error.database_insert') . ' (' . $ex->getMessage() . ')']);
        }

        return $redirect;
    }

    public function updateSecurity(Request $request)
    {
        $user = $this->auth_user;

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|confirmed|min:6',
            'current_password' => 'required|password'
        ]);

        $redirect = redirect(localizedURL('user/edit') . '#secure');

        if ($validator->fails()) {
            return $redirect->withErrors($validator, 'security');
        }
        $user->email = $request->input('email');
        $must_login = false;
        if (!empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
            $must_login = true;
        }
        $user->save();

        if ($must_login) {
            Auth::login($user);
        }

        return $redirect;
    }

    public function updateWork(Request $request)
    {
        if (!$request->has('id')) {
            return $this->createWork($request);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:user_works,id',
            'company' => 'required|max:255',
            'position' => 'sometimes|max:255',
            'start' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            'end' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
        ]);

        $redirect = redirect(localizedURL('user/edit') . '#work-and-education');

        if ($validator->fails()) {
            return $redirect->withErrors($validator, 'work_' . $request->input('id'));
        }

        $work = UserWork::findOrFail($request->input('id'));
        $work->company = $request->input('company');
        $work->position = $request->input('position', '');
        $work->description = $request->input('description', '');
        $work->start = $request->has('start') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('start')) : null;
        $work->end = $request->has('end') && !$request->has('current') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('end')) : null;
        $work->current = $request->has('current');
        $work->save();

        return $redirect;
    }

    protected function createWork(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fresh_company' => 'required|max:255',
            'fresh_position' => 'sometimes|max:255',
            'fresh_start' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            'fresh_end' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
        ]);

        $redirect = redirect(localizedURL('user/edit') . '#work-and-education');

        if ($validator->fails()) {
            return $redirect->withInput()->withErrors($validator, 'work');
        }

        $work = UserWork::create([
            'user_id' => $this->auth_user->id,
            'company' => $request->input('fresh_company'),
            'position' => $request->input('fresh_position', ''),
            'description' => $request->input('fresh_description', ''),
            'start' => $request->has('fresh_start') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('fresh_start')) : null,
            'end' => $request->has('fresh_end') && !$request->has('fresh_current') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('fresh_end')) : null,
            'current' => $request->has('fresh_current')
        ]);

        return $redirect;
    }

    public function updateEducation(Request $request)
    {
        if (!$request->has('id')) {
            return $this->createEducation($request);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:user_educations,id',
            'school' => 'required|max:255',
            'field' => 'sometimes|max:255',
            'start' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            'end' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
        ]);

        $redirect = redirect(localizedURL('user/edit') . '#work-and-education');
        if ($validator->fails()) {
            return $redirect->withErrors($validator, 'education_' . $request->input('id'));
        }

        $education = UserEducation::findOrFail($request->input('id'));
        $education->school = $request->input('school');
        $education->field = $request->input('field', '');
        $education->description = $request->input('description', '');
        $education->start = $request->has('start') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('start')) : null;
        $education->end = $request->has('end') && !$request->has('current') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('end')) : null;
        $education->current = $request->has('current');
        $education->save();

        return $redirect;
    }

    protected function createEducation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fresh_school' => 'required|max:255',
            'fresh_field' => 'sometimes|max:255',
            'fresh_start' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            'fresh_end' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
        ]);

        $redirect = redirect(localizedURL('user/edit') . '#work-and-education');

        if ($validator->fails()) {
            return $redirect->withInput()->withErrors($validator, 'education');
        }

        $education = UserEducation::create([
            'user_id' => $this->auth_user->id,
            'school' => $request->input('fresh_school'),
            'field' => $request->input('fresh_field', ''),
            'description' => $request->input('fresh_description', ''),
            'start' => $request->has('fresh_start') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('fresh_start')) : null,
            'end' => $request->has('fresh_end') && !$request->has('fresh_current') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('fresh_end')) : null,
            'current' => $request->has('fresh_current')
        ]);

        return $redirect;
    }

    public function updateCertificate(Request $request)
    {
        if (!$request->has('id')) {
            return $this->createCertificate($request);
        }

        $redirect = redirect(localizedURL('user/edit') . '#certificates');

        if ($request->has('acquire')) {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:user_records,id,type,' . UserRecord::CERTIFICATE,
                'verified_image_1' => 'required|url',
                'verified_image_2' => 'sometimes|url',
            ]);

            if ($validator->fails()) {
                return $redirect->withErrors($validator, 'certificate_' . $request->input('id'));
            }

            $record = UserRecord::findOrFail($request->input('id'));
            $record->verified_image_1 = $request->input('verified_image_1', '');
            $record->verified_image_2 = $request->input('verified_image_2', '');
            $record->status = UserRecord::STATUS_REQUESTED;
            $record->save();
        } else {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:user_records,id,type,' . UserRecord::CERTIFICATE,
                'name' => 'required|max:255',
                'source' => 'sometimes|url',
                'image' => 'sometimes|url',
                'recorded_at' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
                'organization' => 'sometimes|max:255',
            ]);

            if ($validator->fails()) {
                return $redirect->withErrors($validator, 'certificate_' . $request->input('id'));
            }

            $record = UserRecord::findOrFail($request->input('id'));
            $record->name = $request->input('name');
            $record->description = $request->input('description', '');
            $record->source = $request->input('source', '');
            $record->image = $request->input('image', '');
            $record->recorded_at = $request->has('recorded_at') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('recorded_at')) : null;
            $record->organization = $request->input('organization', '');
            $record->save();
        }

        return $redirect;
    }

    protected function createCertificate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fresh_name' => 'required|max:255',
            'fresh_source' => 'sometimes|url',
            'fresh_image' => 'sometimes|url',
            'fresh_recorded_at' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            'fresh_organization' => 'sometimes|max:255',
        ]);

        $redirect = redirect(localizedURL('user/edit') . '#certificates');
        if ($validator->fails()) {
            return $redirect->withInput()->withErrors($validator, 'certificate');
        }

        $record = UserRecord::create([
            'user_id' => $this->auth_user->id,
            'name' => $request->input('fresh_name'),
            'description' => $request->input('fresh_description', ''),
            'source' => $request->input('fresh_source', ''),
            'image' => $request->input('fresh_image', ''),
            'fresh_recorded_at' => $request->has('fresh_recorded_at') ? toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('fresh_recorded_at')) : null,
            'organization' => $request->input('fresh_organization', ''),
            'type' => UserRecord::CERTIFICATE
        ]);

        return $redirect;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
    }

    public function layoutSingle(Request $request, $id = null)
    {
        $auth_id = $this->is_auth ? $this->auth_user->id : null;

        if (empty($auth_id) && empty($id)) {
            abort(404);
        }
        $user = empty($id) ? User::findOrFail($auth_id) : User::findOrFail($id);
        $is_owner = $auth_id == $user->id;

        $this->theme->title([trans('pages.page_users_title'), $user->name]);
        $this->theme->description(trans('pages.page_users_desc'));

        add_filter('open_graph_tags_before_render', new CallableObject(function ($data) use ($user) {
            $data['og:image'] = $user->profile_picture;
            return $data;
        }));

        $user_articles = $user->articles()
            ->ofBlog()->published()->translatedIn($this->locale)
            ->orderBy('created_at', 'desc')->take(4)->get();

        return view($this->themePage('user.profile'), [
            'user_profile' => $user,
            'user_works' => $user->works,
            'user_educations' => $user->educations,
            'user_articles' => $user_articles,
            'article_shorten_length' => AppHelper::BLOG_ARTICLE_SHORTEN_LENGTH,
            'is_owner' => $is_owner,
        ]);
    }

    public function layoutDocuments(Request $request)
    {
        $this->makeDirectory();

        return view($this->themePage('user.documents'), [
            'user_profile' => $this->auth_user,
            'is_owner' => true,
            'dateFormat' => DateTimeHelper::shortDateFormat(),
            'timeFormat' => DateTimeHelper::shortTimeFormat(),
        ]);
    }

    protected function makeDirectory()
    {
        $own_directory = $this->auth_user->ownDirectory;
        $storage = Storage::disk('file_manager');
        if (!$storage->exists($own_directory)) {
            $storage->makeDirectory($own_directory);
        }
    }
}
