<?php

namespace Antoree\Http\Controllers\Auth;

use Antoree\Http\Controllers\ViewController;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\MailHelper;
use Antoree\Models\UserNotification;
use Antoree\Models\Role;
use Antoree\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends ViewController {

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath;
    protected $loginPath;
    protected $redirectAfterLogout;
    protected $socialRegisterPath;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->redirectPath = localizedPath('auth/inactive');
        $this->loginPath = localizedPath('auth/login');
        $this->redirectAfterLogout = homePath();
        $this->socialRegisterPath = localizedPath('auth/register/social');

        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function getLogin()
    {
        $this->theme->title(trans('pages.page_login_title'));

        return view($this->themePage('auth.login'));
    }

    public function getAutoLogin(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if($user){
            Auth::login($user);
            return redirect("/");
        }
        abort(404);
    }

    public function postLogin(Request $request)
    {
        if(!empty($request->input('email')) && !empty($request->input('password'))){
            $user = User::where('email','=',$request->input('email'))->first();
            if($user){
                if($user->active == 0 && $user->auto_create != 1){
                    $data = array();
                    $data['id'] = $user->id;
                    $data['name'] = $user->name;
                    $data['email'] = $user->email;
                    $data['password'] = '******';
                    $data['activation_code'] = $user->activation_code;

                    $this->sendWelcomeEmail($data);

                    if ($request->ajax()) {
                        return response('Unauthorized.', 401);
                    }

                    return redirect(localizedURL('auth/inactive'))->with('user', $user);
                }
            }
        }

        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
            ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {

            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }
        
        return redirect($this->loginPath())
        ->withInput($request->only($this->loginUsername(), 'remember'))
        ->withErrors([
            $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    protected function authenticated(Request $request, User $user)
    {
        return redirect(localizedURL('auth/inactive', [], $user->language));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'       => 'required|max:255',
            'email'      => 'required|email|max:255|unique:users',
            'phone_code' => 'required|in:' . implode(',', allCountryCodes()),
            'phone'      => 'required',
            'password'   => 'required|confirmed|min:6',
            'roles'      => 'required|array'
            ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorIsAutoCreate(array $data)
    {
        return Validator::make($data, [
            'name'       => 'required|max:255',
            'email'      => 'required|email|max:255',
            'phone_code' => 'required|in:' . implode(',', allCountryCodes()),
            'phone'      => 'required',
            'password'   => 'required| |min:6',
            'roles'      => 'required|array'
            ]);
    }

    /**
     * @param array $mail_data
     * @param bool $social
     */
    private function sendWelcomeEmail(array $mail_data, $social = false)
    {
        $mail_data['url_confirm'] = localizedURL('verify/{id}/{activation_code}',['id' => $mail_data['id'], 'activation_code' => $mail_data['activation_code']]);
        
        $global = $this->globalViewData;
        if($global['site_locale'] == 'vi'){
            $mail_data[MailHelper::EMAIL_SUBJECT] = 'Vui lòng xác nhận đăng ký';
        }else{
            $mail_data[MailHelper::EMAIL_SUBJECT] = 'Please confirm your email address';
        }

        // $mail_data[MailHelper::EMAIL_SUBJECT] = trans('label.welcome_to') . appName();
        $mail_data[MailHelper::EMAIL_TO] = $mail_data['email'];
        $mail_data[MailHelper::EMAIL_TO_NAME] = $mail_data['name'];
        if ($social)
        {
            $mail_data['provider'] = ucfirst($mail_data['provider']);
        }

        return MailHelper::sendTemplateNomal($social ? 'welcome_social.' : 'welcome.', array_merge($this->globalViewData, $mail_data));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data, $social = false)
    {
        $user = null;

        DB::beginTransaction();
        try
        {
            $user = User::advancedCreate([
                'email'           => $data['email'],
                'password'        => bcrypt($data['password']),
                'name'            => $data['name'],
                'skype'            => isset($data['skype']) ? $data['skype'] : '',
                'phone_code'      => $data['phone_code'],
                'phone'           => $data['phone'],
                'country'         => $data['phone_code'],
                'provider'        => isset($data['provider']) ? $data['provider'] : '',
                'provider_id'     => isset($data['provider_id']) ? $data['provider_id'] : '',
                'profile_picture' => isset($data['profile_picture']) ? $data['profile_picture'] : asset('storage/app/profile_pictures/default.png'),
                'activation_code' => str_random(32),
                'active'          => false
                ]);
            $slug = toSlug($data['name']);
            if (User::where('slug', $slug)->count() > 0)
            {
                $user->slug = $slug . '-' . $user->id;
            } else
            {
                $user->slug = $slug;
            }
            $user->save();

            $public_roles = Role::where('public', true)->get()->pluck('id')->all();
            foreach ($data['roles'] as $role_id)
            {
                if (in_array($role_id, $public_roles))
                {
                    $user->advancedAttachRole($role_id);
                }
            }

            if ($user->hasRole('teacher'))
            {
                UserNotification::createAndPushToUser($user, 'teacher/becoming', 'teacher_becoming_not_complete_registration', [], [], false);
            }

            DB::commit();
        } catch (\Exception $ex)
        {
            DB::rollBack();
        }

        if ($user)
        {
            if($user->hasRole('teacher')){
                $user->active = true;
                $user->save();
            }else{
                $data['id'] = $user->id;
                $data['activation_code'] = $user->activation_code;
                $this->sendWelcomeEmail($data, $social);
            }
        }

        return $user;
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function update(array $data, $social = false)
    {
        $user = null;

        DB::beginTransaction();
        try
        {
            $user = User::where('email','=',$data['email'])->first();
            if($user){

                $user->email = $data['email'];
                $user->password        = bcrypt($data['password']);
                $user->name            = $data['name'];
                $user->skype            = isset($data['skype']) ? $data['skype'] : '';
                $user->phone_code      = $data['phone_code'];
                $user->phone           = $data['phone'];
                $user->country        = $data['phone_code'];
                $user->auto_create        = 0;
                $user->provider        = isset($data['provider']) ? $data['provider'] : '';
                $user->provider_id     = isset($data['provider_id']) ? $data['provider_id'] : '';
                $user->profile_picture = isset($data['profile_picture']) ? $data['profile_picture'] : asset('storage/app/profile_pictures/default.png');
                $user->save();
            }

            $slug = toSlug($data['name']);
            if (User::where('slug', $slug)->count() > 0)
            {
                $user->slug = $slug . '-' . $user->id;
            } else
            {
                $user->slug = $slug;
            }
            $user->save();

            $public_roles = Role::where('public', true)->get()->pluck('id')->all();
            foreach ($data['roles'] as $role_id)
            {
                if (in_array($role_id, $public_roles))
                {
                    $user->advancedAttachRole($role_id);
                }
            }

            if ($user->hasRole('teacher'))
            {
                UserNotification::createAndPushToUser($user, 'teacher/becoming', 'teacher_becoming_not_complete_registration', [], [], false);
            }

            DB::commit();
        } catch (\Exception $ex)
        {
            DB::rollBack();
        }

        if ($user)
        {
            if($user->hasRole('teacher')){
                $user->active = true;
                $user->save();
            }else{
                $data['id'] = $user->id;
                $data['activation_code'] = $user->activation_code;
                $this->sendWelcomeEmail($data, $social);
            }
        }
        return $user;
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function getRegister(Request $request)
    {
        $title = "";
        $desc = "";
        
        if($request->has('selected_roles')){
            return redirect(localizedURL('auth/register-tutor'));
        }

        $selected_roles = $request->has('selected_roles') ? explode(',', $request->input('selected_roles')) : old('roles', ['student']);
        if ($request->has('selected_roles') && $request->get('selected_roles') == "teacher")
        {
            $title = trans('pages.page_register_tutor_title_meta');
            $desc = trans('pages.page_register_tutor_desc_meta');

        } else
        $this->theme->title(trans('pages.page_register_title'));
        if (session('freetest'))
        {
            return view($this->themePage('auth.register'), [
                'selected_roles'   => $selected_roles,
                'public_roles'     => Role::where('public', true)->get(),
                'session_freetest' => session('freetest'),
                'site_title' => "&raquo; ".$title,
                'site_desc' => $desc,
                ]);
        }

        return view($this->themePage('auth.register'), [
            'selected_roles' => $selected_roles,
            'public_roles'   => Role::where('public', true)->get(),
            'site_title' => "&raquo; ".$title,
            'site_desc' => $desc,
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function getRegisterTutor(Request $request)
    {
        $this->theme->title(trans('pages.page_register_tutor_title_meta'));
        $this->theme->description(trans('pages.page_register_tutor_desc_meta'));

        return view($this->themePage('auth.register_tutor'), [
            'hasFlat' => true,
            'selected_roles' => ['teacher'],
            'public_roles'   => Role::where('public', true)->get(),
            ]);
        
        // $title = trans('pages.page_register_tutor_title_meta');
        // $desc = trans('pages.page_register_tutor_desc_meta');
        
        // return view('admin_themes.admin_lte.pages.auth.register', [
        //     'hasFlat' => true,
        //     'selected_roles' => ['teacher'],
        //     'public_roles'   => Role::where('public', true)->get(),
        //     'site_title' => "&raquo; ".$title,
        //     'site_desc' => $desc,
        //     ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        Session::forget('freeError');

        //Check user auto create from register trial
        $flat = false;
        $user_delete = null;
        if(!empty($request->input('email'))){
            $user = User::where('email','=',$request->input('email'))->first();

            if($user && $user->auto_create == 1){
                $flat = true;
                $validator = $this->validatorIsAutoCreate($request->all());
            }else{
                //Check User Delete.
                $user_delete = User::withTrashed()
                ->where('email', $request->input('email'))
                ->first();
                // dd($user_delete->deleted_at);
                if($user_delete !== null && $user_delete->deleted_at !=null){
                    $validator = $this->validatorIsAutoCreate($request->all());
                    // dd('ok',$user_delete);
                    $user_delete->deleted_at = null;
                    $user_delete->save();
                    $new_user = $user_delete;
                }else{
                    $validator = $this->validator($request->all());
                }
            }

        }else{
            $validator = $this->validator($request->all());
        }
        //End check user auto create from register trial

        if ($validator->fails())
        {
            if ($request->get('session_freetest'))
            {
                session(['freeError' => $request->get('session_freetest')]);
            }

            $this->throwValidationException(
                $request, $validator
                );
        }

        //Check user auto create from register trial
        if($flat || $user_delete !== null){
            $stored_user = $this->update($request->all());
        }else{
            $stored_user = $this->create($request->all());
        }
        //End check user auto create from register trial
        
        if ($stored_user)
        {
            if($stored_user->hasRole('teacher')){

                Auth::login($stored_user);

                return redirect($this->redirectPath);
            }

            return view($this->themePage('auth.inactive'), ['resend' => true, 'user'=>$stored_user]);
            // Auth::login($stored_user);
        } else
        {
            return redirect(localizedURL('auth/register'))
            ->withInput()
            ->withErrors([trans('auth.register_failed_system_error')]);
        }

        if ($request->get('session_freetest'))
        {
            return redirect()->intended('http://antoree.com/freetest/id=' . $request->get('session_freetest'));
        }

        return redirect($this->redirectPath);
    }

    public function redirectToProvider(Request $request, $provider)
    {
        if (!config("services.$provider"))
        {
            abort(404);
        }

        if ($request->has('selected_roles'))
        {
            session([AppHelper::SESSION_SRS => $request->input('selected_roles')]);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        if (!config("services.$provider"))
        {
            abort(404);
        }

        try
        {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $ex)
        {
            return redirect($this->loginPath)
            ->withErrors([trans('auth.social_failed_get')]);
        }

        if ($authUser = User::fromSocial($socialUser->email, $provider, $socialUser->id)->first())
        {
            Auth::login($authUser);
            
            return redirect("/");
//            return redirect($this->redirectPath);
        }

        $selected_roles = $request->session()->pull(AppHelper::SESSION_SRS);

        return redirect(localizedURL('auth/register/social') . (empty($selected_roles) ? '' : '?selected_roles=' . $selected_roles))
        ->withInput([
            'provider'        => $provider,
            'provider_id'     => $socialUser->id,
            'profile_picture' => $socialUser->avatar,
            'name'            => $socialUser->name,
            'email'           => $socialUser->email,
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function getSocialRegister(Request $request)
    {
        $selected_roles = $request->has('selected_roles') ? explode(',', $request->input('selected_roles')) : ['teacher'];

        $this->theme->title(trans('pages.page_register_title'));

        return view($this->themePage('auth.register_social'), [
            'selected_roles' => $selected_roles,
            'public_roles'   => Role::where('public', true)->get()
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSocialRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
                );
        }

        $stored_user = $this->create($request->all(), true);
        if ($stored_user)
        {
            return view($this->themePage('auth.inactive'), ['resend' => true]);
            // Auth::login($stored_user);
        } else
        {
            return redirect(localizedURL('auth/register'))
            ->withInput()
            ->withErrors([trans('auth.register_failed_system_error')]);
        }

        return redirect($this->redirectPath);
    }

    public function getInactive(Request $request)
    {
        // if ($this->auth_user->active)
        // {
        //     return redirect(redirectUrlAfterLogin($this->auth_user));
        // }

        if(!empty(session('user'))){
            return view($this->themePage('auth.inactive'), ['resend' => false, 'user' => session('user')]);
        }else{
            return redirect(localizedPath('auth/login'));
        }
    }

    public function postInactive(Request $request)
    {

        $user = User::findOrFail($request->input('id'));
        // dd($user);
        if($user){
            $data = array();
            $data['id'] = $user->id;
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['password'] = '******';
            $data['activation_code'] = $user->activation_code;

            $this->sendWelcomeEmail($data);

            return view($this->themePage('auth.inactive'), ['resend' => true, 'user'=> $user]);
        }else{
            abort(404);
        }
    }

    public function getActivation($id, $activation_code)
    {
        $user = User::findOrFail($id);
        $active = $user->activation_code == $activation_code;
        if ($active)
        {
            $user->active = true;
            $user->save();
            $au = Auth::loginUsingId($id);
            
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

    public function getIsActivation($user_id)
    {
        $au = Auth::loginUsingId($user_id);
        return redirect(homeURL());
    }
}
