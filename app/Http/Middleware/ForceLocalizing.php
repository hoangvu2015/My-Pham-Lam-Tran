<?php

namespace Antoree\Http\Middleware;

use Antoree\Models\Helpers\AppHelper;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class ForceLocalizing
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * @var array
     */
    private $cookies;

    private $forceLang;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->cookies = [];
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has(AppHelper::SESSION_RDR)) {
            session([AppHelper::SESSION_RDR => $request->input(AppHelper::SESSION_RDR)]);
        }

        $this->checkIfForceLang($request);
        $this->checkIfFreshSession($request);

        $redirect = $this->checkIfRedirect($request);
        if ($redirect !== false) {
            return $redirect;
        }

        $this->applySessionLanguage($request);

        $response = $next($request);
        foreach ($this->cookies as $cookie) {
            $response = $response->withCookie($cookie);
        }

        return $response;
    }

    private function checkIfForceLang(Request $request)
    {
        $this->forceLang = currentBrowserLocale();
        if ($request->has(AppHelper::QPR_FORCE_LANG)) {
            $this->forceLang = $request->input(AppHelper::QPR_FORCE_LANG);
        } else {
            if(!isDirectLocale()) {
                if (!$request->session()->has('localization.language')) {
                    if ($request->hasCookie('localization_language')) {
                        $this->forceLang = $request->cookie('localization_language');
                    }
                }
            }
        }
    }

    private function checkIfRedirect(Request $request)
    {
        if (in_array($this->forceLang, allSupportedLocaleCodes()) && $this->forceLang != currentLocale()) {
            $this->applySessionLanguage($request);

            return redirect(currentURL($this->forceLang))
                ->withCookies($this->cookies);
        }

        return false;
    }

    private function checkIfFreshSession(Request $request)
    {
        if (!$request->session()->has('localization')) {
            $country = $request->cookie('localization_country', 'VN');
            $timezone = $request->cookie('localization_timezone', 'UTC+7');
            $first_day_of_week = $request->cookie('localization_first_day_of_week', 0);
            $long_date_format = $request->cookie('localization_long_date_format', 0);
            $short_date_format = $request->cookie('localization_short_date_format', 0);
            $long_time_format = $request->cookie('localization_long_time_format', 0);
            $short_time_format = $request->cookie('localization_short_time_format', 0);

            if (!$request->hasCookie('localization_country')) {
                $this->cookies[] = cookie()->forever('localization_country', $country);
            }
            if (!$request->hasCookie('localization_timezone')) {
                $this->cookies[] = cookie()->forever('localization_timezone', $timezone);
            }
            if (!$request->hasCookie('localization_first_day_of_week')) {
                $this->cookies[] = cookie()->forever('localization_first_day_of_week', $first_day_of_week);
            }
            if (!$request->hasCookie('localization_long_date_format')) {
                $this->cookies[] = cookie()->forever('localization_long_date_format', $long_date_format);
            }
            if (!$request->hasCookie('localization_short_date_format')) {
                $this->cookies[] = cookie()->forever('localization_short_date_format', $short_date_format);
            }
            if (!$request->hasCookie('localization_long_time_format')) {
                $this->cookies[] = cookie()->forever('localization_long_time_format', $long_time_format);
            }
            if (!$request->hasCookie('localization_short_time_format')) {
                $this->cookies[] = cookie()->forever('localization_short_time_format', $short_time_format);
            }

            session([
                'localization.country' => $country,
                'localization.timezone' => $timezone,
                'localization.first_day_of_week' => $first_day_of_week,
                'localization.long_date_format' => $long_date_format,
                'localization.short_date_format' => $short_date_format,
                'localization.long_time_format' => $long_time_format,
                'localization.short_time_format' => $short_time_format,
            ]);
        }
    }

    private function applySessionLanguage(Request $request)
    {
        if ($this->auth->check()) {
            $user = $this->auth->user();
            if ($this->forceLang != $user->language) {
                $user->language = $this->forceLang;
                $user->save();
            }
        }

        session([
            'localization.language' => $this->forceLang,
        ]);
        if ($request->cookie('localization_language') != $this->forceLang) {
            $this->cookies[] = cookie()->forever('localization_language', $this->forceLang);
        }
    }
}
