<?php

namespace Antoree\Http\Controllers\Auth;

use Antoree\Http\Controllers\ViewController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends ViewController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $subject;
    protected $redirectPath;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->subject = trans('auth.forgot_subject', array('name' => appName()));
        $this->redirectPath = localizedPath('auth/inactive');

        $this->middleware('guest');
    }

    public function getEmail()
    {
        $this->theme->title(trans('auth.password'));
        return view($this->themePage('auth.password'));
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEmailApi(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        return response()->json(['success'=>true]);
    }

    public function getReset(Request $request, $token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        $this->theme->title(trans('auth.reset'));

        return view('admin_themes.admin_lte.pages.auth.reset')->with('token', $token)->with('email', $request->get('email'));
        // return view($this->themePage('auth.reset'))->with('token', $token);
    }
    //======================overide function====================

    protected function getEmailSubject()
    {
        return property_exists($this, 'subject') ? 'Antoree Reset Password' : 'Antoree Reset Password';
    }
}
