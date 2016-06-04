<?php

namespace Antoree\Http\Controllers\Admin;

use Antoree\Http\Controllers\ViewController;
use Antoree\Models\Helpers\DateTimeHelper;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\MailHelper;
use Antoree\Models\Helpers\PaginationHelper;
use Antoree\Models\Helpers\QueryStringBuilder;
use Antoree\Models\RealtimeChannel;
use Antoree\Models\Role;
use Antoree\Models\User;
use Antoree\Models\Student;
use Antoree\Models\Teacher;
use Antoree\Models\UserRecord;
use Illuminate\Http\Request;

use Antoree\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class UserController extends ViewController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $searchNameEmailCc = $request->input('searchNameEmailCc', null);
        $users = User::filter($searchNameEmailCc)->orderBy('created_at', 'desc')->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE); // Helper::DEFAULT_ITEMS_PER_PAGE items per page
        $users_query = new QueryStringBuilder([
            'page' => $users->currentPage()
            ], localizedAdminURL('users'));
        
        //Clear data has Delete
        if($request->input('searchNameEmailCc')){
            foreach ($users as $key => $value) {
                if($value->deleted_at){
                    unset($users[$key]);
                }
            }
        }

        return view($this->themePage('user.list'), [
            'searchNameEmailCc'=>$searchNameEmailCc,
            'users' => $users,
            'users_query' => $users_query,
            'page_helper' => new PaginationHelper($users->lastPage(), $users->currentPage(), $users->perPage()),
            'rdr_param' => rdrQueryParam($request->fullUrl()),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view($this->themePage('user.add'), [
            'roles' => Role::all(),
            'date_js_format' => DateTimeHelper::shortDatePickerJsFormat(),
            ]);
    }

    /**
     * @param array $mail_data
     * @param bool $social
     */
    private function sendWelcomeEmail(array $mail_data, $locale)
    {
        $mail_data[MailHelper::EMAIL_SUBJECT] = trans('label.welcome_to') . appName();
        $mail_data[MailHelper::EMAIL_TO] = $mail_data['email'];
        $mail_data[MailHelper::EMAIL_TO_NAME] = $mail_data['name'];
        return MailHelper::sendTemplate('welcome', array_merge($this->globalViewData, $mail_data), $locale);
    }

    protected function validator(array $data, array $extra_rules = [])
    {
        return Validator::make($data, array_merge([
            'name' => 'required|max:255',
            // 'email' => 'required|email|max:255|unique:users',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
            'phone_code' => 'required|in:' . implode(',', allCountryCodes()),
            'phone' => 'required|max:255',
            'skype' => 'sometimes|max:255',
            'date_of_birth' => 'sometimes|date_format:' . DateTimeHelper::shortDateFormat(),
            'gender' => 'required|in:' . implode(',', allGenders()),
            'address' => 'sometimes|max:255',
            'city' => 'sometimes|max:255',
            'country' => 'required|in:--,' . implode(',', allCountryCodes()),
            'language' => 'required|in:' . implode(',', allSupportedLocaleCodes()),
            'roles' => 'required|array|exists:roles,id',
            ], $extra_rules));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect(localizedAdminURL('users/add'))
            ->withInput()
            ->withErrors($validator);
        }
        DB::beginTransaction();
        try {
            $email = strtolower($request->input('email'));
            $check_email = User::onlyTrashed()->where('email',$email)->first();

            if($check_email == null){
                $user = array(
                    'name' => $request->input('name'),
                    'email' => $email,
                    'password' => bcrypt($request->input('password')),
                    'phone_code' => $request->input('phone_code'),
                    'phone' => $request->input('phone'),
                    'skype' => $request->input('skype'),
                    'date_of_birth' => toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('date_of_birth'), true),
                    'gender' => $request->input('gender'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'country' => $request->input('country'),
                    'language' => $request->input('language'),
                    'slug' => toSlug($request->input('name')),

                    'activation_code' => str_random(32),
                    'active' => true
                );
                $user = User::advancedCreate($user);
                $user->save();
            }
            else{
                $user = $check_email;
                $user->restore();

                $user->name = $request->input('name');
                $user->email = $email;
                $user->password = bcrypt($request->input('password'));
                $user->phone_code = $request->input('phone_code');
                $user->phone = $request->input('phone');
                $user->skype = $request->input('skype');
                $user->date_of_birth = toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('date_of_birth'), true);
                $user->gender = $request->input('gender');
                $user->address = $request->input('address');
                $user->city = $request->input('city');
                $user->country = $request->input('country');
                $user->language = $request->input('language');
                $user->slug = toSlug($request->input('name'));
                $user->save();
            }
            $user->attachRoles($request->input('roles'));
            if($user->hasRole('student')){
                Student::create([
                    'user_id' => $user->id,
                    ]);
            }
            if($user->hasRole('teacher')){
                Teacher::create([
                    'user_id' => $user->id,
                    'status' => Teacher::CREATED
                    ]);
            }

            $this->sendWelcomeEmail($request->all(), $user->language);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect(localizedAdminURL('users/add'))
            ->withInput()
            ->withErrors([trans('error.database_insert') . ' (' . $ex->getMessage() . ')']);
        }

        return redirect(localizedAdminURL('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        return view($this->themePage('user.edit'), [
            'max_upload_filesize'        => maxUploadFileSize(),
            'max_size'                   => asKb(maxUploadFileSize()),
            'user' => $user,
            'user_roles' => $user->roles,
            'roles' => Role::all(),//Role::where('public', false)->get(),
            'date_js_format' => DateTimeHelper::shortDatePickerJsFormat(),
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        $validator = $this->validator($request->all(), [
            'password' => 'sometimes|min:6',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            ]);
        if ($validator->fails()) {
            return redirect(localizedAdminURL('users/{id}/edit', ['id' => $user->id]))
            ->withErrors($validator);
        }
        DB::beginTransaction();
        try {
            $user->name = $request->input('name');
            $slug = toSlug($request->input('name'));
            if (User::where('slug', $slug)->where('id', '<>', $user->id)->count() > 0) {
                $user->slug = $slug . '-' . $user->id;
            } else {
                $user->slug = $slug;
            }
            $user->email = strtolower($request->input('email'));
            if (!empty($request->input('password', ''))) {
                $user->password = bcrypt($request->input('password'));
            }
            $user->phone_code = $request->input('phone_code');
            $user->phone = $request->input('phone');
            $user->skype = $request->input('skype');
            $user->date_of_birth = toDatabaseTime(DateTimeHelper::shortDateFormat(), $request->input('date_of_birth'), true);
            $user->gender = $request->input('gender');
            $user->address = $request->input('address', '');
            $user->city = $request->input('city', '');
            $user->country = $request->input('country');
            $user->language = $request->input('language');
            $user->active = $request->input('active');
            $user->save();

            $selected_roles = $request->input('roles', []);
            if (count($selected_roles) > 0) {
                $user->roles()->sync($selected_roles);
            } else {
                $user->roles()->detach();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(localizedAdminURL('users/{id}/edit', ['id' => $user->id]))
            ->withInput()
            ->withErrors([trans('error.database_update') . ' (' . $e->getMessage() . ')']);
        }

        return redirect(localizedAdminURL('users/{id}/edit', ['id' => $user->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $redirect_url = localizedAdminURL('users');
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }

        return $user->delete() === true ? redirect($redirect_url) : redirect($redirect_url)->withErrors([trans('error.database_delete')]);
    }

    public function listVerifyingCertificates(Request $request)
    {
        $certificates = UserRecord::ofCertificate()->requested()->paginate(AppHelper::DEFAULT_ITEMS_PER_PAGE);
        $query = new QueryStringBuilder([
            'page' => $certificates->currentPage()
            ], localizedAdminURL('users/verifying-certificates'));
        return view($this->themePage('user.verifying_certificates'), [
            'certificates' => $certificates,
            'query' => $query,
            'page_helper' => new PaginationHelper($certificates->lastPage(), $certificates->currentPage(), $certificates->perPage()),
            'rdr_param' => rdrQueryParam($request->fullUrl()),
            ]);
    }
    
    public function verifyCertificate(Request $request, $id)
    {
        $record = UserRecord::ofCertificate()->where('id', $id)->firstOrFail();
        $record->status = UserRecord::STATUS_VERIFIED;

        $redirect_url = localizedAdminURL('users/verifying-certificates');
        $rdr = $request->session()->pull(AppHelper::SESSION_RDR, '');
        if (!empty($rdr)) {
            $redirect_url = $rdr;
        }

        return $record->save() === true ? redirect($redirect_url) : redirect($redirect_url)->withErrors([trans('error.database_update')]);
    }

    /**
     *  Link Verify Email Register User 
     */
    public function getActivation($id, $activation_code)
    {
        $user = User::findOrFail($id);
        $active = $user->activation_code == $activation_code;
        if ($active)
        {            
            $user->active = true;
            $user->save();

            if(!Auth::check()){
                $au = Auth::loginUsingId($id);
            }else{
                $au = $this->auth_user;
            }

            if(Auth::check()){
                return view('admin_themes.admin_lte.pages.auth.activate', [
                    'user' => $au,
                    'active' => $active,
                    'url'    => localizedURL('auth/login'),
                    'urlHome' => localizedURL('auth/is-activate/{user_id}',['user_id'=>$user->id]),
                    'name'   => trans('pages.page_login_title')
                    ]);
            }else{
                abort(404);
            }
            
        }else{
            abort(404);
        }
    }
}
