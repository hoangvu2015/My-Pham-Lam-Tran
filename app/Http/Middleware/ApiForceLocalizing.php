<?php

namespace Antoree\Http\Middleware;

use Antoree\Models\Helpers\AppHelper;
use Closure;

class ApiForceLocalizing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $force_lang = config('app.locale');
        if ($request->has(AppHelper::QPR_FORCE_LANG)) {
            $force_lang = $request->input(AppHelper::QPR_FORCE_LANG);
        } elseif ($request->session()->has('localization.language')) {
            $force_lang = $request->session()->get('localization.language');
        } elseif ($request->hasCookie('localization_language')) {
            $force_lang = $request->cookie('localization_language');
        }

        setCurrentLocale($force_lang);

        return $next($request);
    }
}
