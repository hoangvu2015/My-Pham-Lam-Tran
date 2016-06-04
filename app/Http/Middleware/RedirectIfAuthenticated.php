<?php

namespace Antoree\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfAuthenticated
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
        if ($this->auth->check()) {
            $user = $this->auth->user();

            session([
                'localization.country' => $user->country,
                'localization.language' => $user->language,
                'localization.timezone' => $user->timezone,
                'localization.first_day_of_week' => $user->first_day_of_week,
                'localization.long_date_format' => $user->long_date_format,
                'localization.short_date_format' => $user->short_date_format,
                'localization.long_time_format' => $user->long_time_format,
                'localization.short_time_format' => $user->short_time_format,
            ]);

            $activatePath = localizedPath('auth/activate', $user->language);
            $inactivePath = localizedPath('auth/inactive', $user->language);
            $redirect_url = homeURL($user->language);
            if (!$user->active) {
                if (!$request->is($activatePath . '/*') && !$request->is($inactivePath)) {
                    $redirect_url = $inactivePath;
                }
            } else {
                $redirect_url = redirectUrlAfterLogin($user);
            }

            return redirect($redirect_url)->withCookies([
                cookie()->forever('localization_country', $user->country),
                cookie()->forever('localization_language', $user->language),
                cookie()->forever('localization_timezone', $user->timezone),
                cookie()->forever('localization_first_day_of_week', $user->first_day_of_week),
                cookie()->forever('localization_long_date_format', $user->long_date_format),
                cookie()->forever('localization_short_date_format', $user->short_date_format),
                cookie()->forever('localization_long_time_format', $user->long_time_format),
                cookie()->forever('localization_short_time_format', $user->short_time_format),
            ]);
        }

        return $next($request);
    }
}
