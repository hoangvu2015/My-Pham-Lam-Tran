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
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class AuthApiController extends ViewController {

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
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data["email"] = strtolower($data["email"]);
        return Validator::make($data, [
            'name'       => 'required|max:255',
            'email'      => 'required|email|max:255|unique:users',
            'phone_code' => 'required|in:' . implode(',', allCountryCodes()),
            'phone'      => 'required',
            // 'password'   => 'required|confirmed|min:6',
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
        $data["email"] = strtolower($data["email"]);
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
                'email'           => strtolower($data['email']),
                'password'        => bcrypt($data['password']),
                'name'            => $data['name'],
                'skype'            => !empty($data['skype']) ? $data['skype'] : '',
                'phone_code'      => $data['phone_code'],
                'phone'           => $data['phone'],
                'country'         => $data['phone_code'],
                'provider'        => !empty($data['provider']) ? $data['provider'] : '',
                'provider_id'     => !empty($data['provider_id']) ? $data['provider_id'] : '',
                'profile_picture' => !empty($data['profile_picture']) ? $data['profile_picture'] : asset('storage/app/profile_pictures/default.png'),
                'activation_code' => str_random(32),
                'active'          => false
                ]);
            $slug = toSlug($data['name']);
            $user->slug = $slug;
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

                $user->email = strtolower($data['email']);
                $user->password        = bcrypt($data['password']);
                $user->name            = $data['name'];
                $user->skype            = !empty($data['skype']) ? $data['skype'] : '';
                $user->phone_code      = $data['phone_code'];
                $user->phone           = $data['phone'];
                $user->country        = $data['phone_code'];
                $user->auto_create        = 0;
                $user->provider        = !empty($data['provider']) ? $data['provider'] : '';
                $user->provider_id     = !empty($data['provider_id']) ? $data['provider_id'] : '';
                $user->profile_picture = !empty($data['profile_picture']) ? $data['profile_picture'] : asset('storage/app/profile_pictures/default.png');
                $user->save();
            }

            $slug = toSlug($data['name']);
            $user->slug = $slug;
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

    //============================Auth API=================================
    public function postSendMailWelcomeApi(Request $request)
    {
        $user = User::findOrFail($request->get('id'));
        $data = array();
        $data['id'] =  $user->id;
        $data['name'] =  $user->name;
        $data['email'] =  $user->email;
        $data['password'] = '******';
        $data['activation_code'] =  $user->activation_code;

        $this->sendWelcomeEmail($data);

        return response()->json([
            'success'=>true
            ]);
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = app(RateLimiter::class)->availableIn(
            $request->input($this->loginUsername()).$request->ip()
            );

        return $seconds;
    }

    public function postLoginApi(Request $request)
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

                    return response()->json([
                        'success'=>false,
                        'confirm'=>false,
                        'user'=>$user
                        ]);
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
            $seconds = $this->sendLockoutResponse($request);
            return response()->json([
                'success'=>false,
                'lockout_time' => true,
                'message_lockout_time' => $this->getLockoutErrorMessage($seconds)
                ]);
        }

        $credentials = $this->getCredentials($request);

        $remember = $request->get('remember') == true ? true:false;
        if (Auth::attempt($credentials, $remember)) {
            return response()->json([
                'success'=>true,
                ]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return response()->json([
            'success'=>false
            ]);
    }

    public function postLoginSocialApi(Request $request)
    {
        if(!empty($request->input('email'))){

            //Check delete
            $user_delete = User::checkTrashedRestoreWithEmail($request->input('email'));
            if($user_delete){
                $this->updateLoginUserSocial($request,$user_delete);
                Auth::login($user_delete);

                return response()->json([
                    'success'=>true,
                    ]);
            }
            //End Check delete

            $user = User::where('email','=',$request->input('email'))->first();
            if($user){
                $this->updateLoginUserSocial($request,$user);
                Auth::login($user);

                return response()->json([
                    'success'=>true,
                    ]);
            }else{
                //Not User, need create
                $request->merge(['roles' => [6]]);
                $validator = Validator::make($request->all(), [
                    'name'       => 'required|max:255',
                    'email'      => 'required|email|max:255|unique:users',
                    ]);
                if ($validator->fails()){
                    return response()->json([
                        'success'=>false,
                        'error'=>'notEmail'
                        ]);
                }

                DB::beginTransaction();
                try
                {
                    $user = null;
                    $data = $request->all();
                    $user = User::advancedCreate([
                        'email'           => $data['email'],
                        'name'            => $data['name'],
                        'provider'        => !empty($data['type']) ? $data['type'] : '',
                        'provider_id'     => !empty($data['id']) ? $data['id'] : '',
                        'profile_picture' => !empty($data['profile_picture']) ? $data['profile_picture'] : asset('storage/app/profile_pictures/default.png'),
                        'activation_code' => str_random(32),
                        'active'          => true
                        ]);
                    $slug = toSlug($data['name']);
                    $user->slug = $slug;
                    $user->save();

                    $public_roles = Role::where('public', true)->get()->pluck('id')->all();
                    foreach ($data['roles'] as $role_id)
                    {
                        if (in_array($role_id, $public_roles))
                        {
                            $user->advancedAttachRole($role_id);
                        }
                    }
                    Auth::login($user);

                    DB::commit();
                } catch (\Exception $ex)
                {
                    DB::rollBack();
                }

                return response()->json([
                    'success'=>true,
                    ]);
            }
        }

        return response()->json([
            'success'=>false,
            'error'=>'notEmail'
            ]);
    }

    public function updateLoginUserSocial(Request $request,$user)
    {
        $user->active = 1;
        $user->provider = $request->input('type');
        $user->provider_id = $request->input('id');
        if($user->profile_picture == env('APP_HOME_URL').'/'.env('APP_DEFAULT_USER_PICTURE')){
            $user->profile_picture = $request->input('profile_picture');
        }
        $user->save();
    }

    public function postRegisterApi(Request $request)
    {
        $request->merge(['roles' => [6]]);
        // dd($request->all());

        //Check user auto create from register trial
        $flat = false;
        $user_delete = null;
        $email = strtolower($request->input('email'));
        if(!empty($email)){
            $user = User::where('email','=',$email)->first();
            if($user && $user->auto_create == 1){
                $flat = true;
                $validator = $this->validatorIsAutoCreate($request->all());
            }else{
                //Check User Delete.
                $user_delete = User::withTrashed()
                ->where('email', $email)
                ->first();

                if($user_delete !== null && $user_delete->deleted_at !=null){
                    $validator = $this->validatorIsAutoCreate($request->all());
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

        if ($validator->fails()){
            return response()->json([
                'success'=>false,
                'errors'=>$validator->errors()
                ]);
        }

        //Check user auto create from register trial
        if($flat || $user_delete !== null){
            $stored_user = $this->update($request->all());
            Auth::login($stored_user);
        }else{
            $stored_user = $this->create($request->all());
            Auth::login($stored_user);
        }
        //End check user auto create from register trial

        if ($stored_user){
            return response()->json([
                'success'=>true,
                'notConfirm'=>true,
                'user'=>$stored_user
                ]);
        }else{
            return response()->json([
                'success'=>false,
                'errors'=>[trans('auth.register_failed_system_error')]
                ]);
        }
    }
}
