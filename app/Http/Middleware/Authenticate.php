<?php

namespace Antoree\Http\Middleware;

use Antoree\Models\Helpers\AppHelper;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }

            session([AppHelper::SESSION_RDR => $request->fullUrl()]);
            return redirect()->guest('auth/login');
        }
        
        // if ($this->auth->user()->active != 1) {
        //     if ($request->ajax()) {
        //         return response('Unauthorized.', 401);
        //     }

        //     $activatePath = localizedPath('auth/activate');
        //     $inactivePath = localizedPath('auth/inactive');
        //     if (!$request->is($activatePath . '/*') && !$request->is($inactivePath)) {
                
        //         return redirect($inactivePath);
        //     }
        // }

        return $next($request);
    }
}
