<?php

namespace Antoree\Http\Controllers\Pages;

use Antoree\Http\Controllers\ViewController;
use Antoree\Models\Helpers\AppOptionHelper;
use Illuminate\Http\Request;

use Antoree\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class HomeController extends ViewController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        // $view = AppOptionHelper::get('homepage_view', 'cover');

        $this->theme->title([trans('pages.page_home_title_meta')],false);
        $this->theme->description(trans('pages.page_home_desc_meta'));

        return view($this->themePage('home'),[
             'session_popup' => session('popup'),
            ]);

        // if ($view == 'slideshow') {
        //     $slidePictures = AppOptionHelper::get('homepage_slide_picture', [], $this->locale, true);
        //     $slideContents = AppOptionHelper::get('homepage_slide_content', [], $this->locale, true);
        //     $slidePictures = array_values($slidePictures);
        //     $slideContents = array_values($slideContents);
        //     $max_slides = max(count($slidePictures), count($slideContents));
        //     $slides = [];
        //     for ($i = 0; $i < $max_slides; ++$i) {
        //         if (!empty($slidePictures[$i]) && !empty($slideContents[$i])) {
        //             $slides[] = [
        //             'picture' => $slidePictures[$i],
        //             'content' => str_replace('{!! csrf_field() !!}', csrf_field(), $slideContents[$i]),
        //             ];
        //         }
        //     }
        //     return view($this->themePage('home_slideshow'), [
        //         'slides' => $slides
        //         ]);
        // }

        // return view($this->themePage('home_cover'), [
        //     'cover_picture' => AppOptionHelper::get('homepage_cover_picture',
        //         $this->theme->imageAsset('photodune-4161018-group-of-students-m.jpg'), $this->locale),
        //     'cover_heading' => AppOptionHelper::get('homepage_cover_heading',
        //         appName(), $this->locale),
        //     'cover_subheading' => AppOptionHelper::get('homepage_cover_subheading',
        //         appDescription(), $this->locale),
        //     ]);
    }

    public function getLocalizationSetting(Request $request)
    {
        $this->theme->title(trans('pages.page_localization_settings_title'));
        $this->theme->description(trans('pages.page_localization_settings_desc'));

        return view($this->themePage('localization_settings'));
    }

    public function postLocalizationSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required|in:' . implode(',', allCountryCodes()),
            'language' => 'required|in:' . implode(',', allSupportedLocaleCodes()),
            'timezone' => 'required',
            'first_day_of_week' => 'required|integer|min:0|max:6',
            'long_date_format' => 'required|integer|min:0|max:3',
            'short_date_format' => 'required|integer|min:0|max:3',
            'long_time_format' => 'required|integer|min:0|max:4',
            'short_time_format' => 'required|integer|min:0|max:4',
            ]);

        if ($validator->fails()) {
            return redirect(localizedURL('localization-settings'))
            ->withErrors($validator);
        }

        session([
            'localization.country' => $request->input('country'),
            'localization.language' => $request->input('language'),
            'localization.timezone' => $request->input('timezone'),
            'localization.first_day_of_week' => $request->input('first_day_of_week'),
            'localization.long_date_format' => $request->input('long_date_format'),
            'localization.short_date_format' => $request->input('short_date_format'),
            'localization.long_time_format' => $request->input('long_time_format'),
            'localization.short_time_format' => $request->input('short_time_format'),
            ]);

        if ($this->is_auth) {
            $this->auth_user->country = $request->input('country');
            $this->auth_user->language = $request->input('language');
            $this->auth_user->timezone = $request->input('timezone');
            $this->auth_user->first_day_of_week = $request->input('first_day_of_week');
            $this->auth_user->long_date_format = $request->input('long_date_format');
            $this->auth_user->short_date_format = $request->input('short_date_format');
            $this->auth_user->long_time_format = $request->input('long_time_format');
            $this->auth_user->short_time_format = $request->input('short_time_format');
            $this->auth_user->save();
        }

        return redirect(localizedURL('localization-settings', [], session('localization.language')))
        ->withCookies([
            cookie()->forever('localization_country', $request->input('country')),
            cookie()->forever('localization_language', $request->input('language')),
            cookie()->forever('localization_timezone', $request->input('timezone')),
            cookie()->forever('localization_first_day_of_week', $request->input('first_day_of_week')),
            cookie()->forever('localization_long_date_format', $request->input('long_date_format')),
            cookie()->forever('localization_short_date_format', $request->input('short_date_format')),
            cookie()->forever('localization_long_time_format', $request->input('long_time_format')),
            cookie()->forever('localization_short_time_format', $request->input('short_time_format')),
            ]);
    }
}
