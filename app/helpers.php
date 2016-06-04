<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-10-28
 * Time: 07:33
 */
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Helpers\AppOptionHelper;
use Antoree\Models\Helpers\DateTimeHelper;
use Antoree\Models\Helpers\ORTC\PushClient;
use Antoree\Models\RealtimeChannel;
use Antoree\Models\Themes\Theme;
use Antoree\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Antoree\Models\Themes\WidgetsFacade;
use Antoree\Models\Themes\LmsThemeFacade;
use Jenssegers\Agent\Facades\Agent;
use Antoree\Models\Helpers\Hook;
use Antoree\Models\Themes\ContentFilter;
use Antoree\Models\Themes\ContentPlace;
use Antoree\Models\Helpers\CallableObject;
use Antoree\Models\Themes\ExtensionsFacade;


#region Getting Referer Hostname

function gettingUtmAndRefererHostname(Request $request){
    session_start();

    $allparams = $request->all();


    if(isset($allparams['utm_source'])){
        Session::set('refererhostname', null);
        Session::set('utm_source', $allparams['utm_source']);
    }else

    if(isset($_SESSION['utm_source'])){
        Session::set('refererhostname', null);
        Session::set('utm_source', $_SESSION['utm_source']);
    }

    if(isset($allparams['utm_medium'])){
        Session::set('refererhostname', null);
        Session::set('utm_medium', $allparams['utm_medium']);
    }else

    if(isset($_SESSION['utm_medium'])){
        Session::set('refererhostname', null);
        Session::set('utm_medium', $_SESSION['utm_medium']);
    }

    if(isset($allparams['utm_campaign'])){
        Session::set('refererhostname', null);
        Session::set('utm_campaign', $allparams['utm_campaign']);
    }else

    if(isset($_SESSION['utm_campaign'])){
        Session::set('refererhostname', null);
        Session::set('utm_campaign', $_SESSION['utm_campaign']);
    }

    if(!Session::get('refererhostname') && isset($_SERVER['HTTP_REFERER'])){
        $hostname = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        Session::set('refererhostname', $hostname);
    }else
    if(!Session::get('refererhostname') && isset($_SESSION['refererhostname'])){
        Session::set('refererhostname', $_SESSION['refererhostname']);
    }

//    echo "Campaign ".Session::get('utm_campaign');exit;
//    dd(Session::get('utm_source'));
}

function getTrackingUtmOrHostname($type){
    return Session::get($type) ? Session::get($type) : "n/a";
}

function clearTrackingUtmOrHostname(){
    Session::set('utm_source',null);
    Session::set('utm_medium',null);
    Session::set('utm_campaign',null);
    Session::set('refererhostname',null);
}


#endregion

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

#region Detect Client
function isPhoneClient()
{
    return Agent::isPhone();
}

function isDesktopClient()
{
    return Agent::isDesktop();
}

function isMobileClient()
{
    return Agent::isMobile();
}

function isTabletClient()
{
    return Agent::isTablet();
}

#endregion

#region Generate
/**
 * @param string $file_path
 * @return string
 */
function libraryAsset($file_path = '')
{
    return Theme::libraryAsset($file_path);
}

function cdataOpen()
{
    return '//<![CDATA[';
}

function cdataClose()
{
    return '//]]>';
}

function widget($placeholder, $before = '', $after = '')
{
    return WidgetsFacade::display($placeholder, $before, $after);
}

function theme_title($titles = '', $use_root = true, $separator = '&raquo;')
{
    return LmsThemeFacade::title($titles, $use_root, $separator);
}

function theme_description($description = '')
{
    return LmsThemeFacade::description($description);
}

function theme_author($author = '')
{
    return LmsThemeFacade::author($author);
}

function theme_application_name($applicationName = '')
{
    return LmsThemeFacade::applicationName($applicationName);
}

function theme_generator($generator = '')
{
    return LmsThemeFacade::generator($generator);
}

function theme_keywords($keywords = '')
{
    return LmsThemeFacade::keywords($keywords);
}

/**
 * @param string|CallableObject $output
 * @param string|integer|null $key
 */
function enqueue_theme_header($output, $key = null)
{
    return LmsThemeFacade::addHeader($output, $key);
}

function dequeue_theme_header($key)
{
    return LmsThemeFacade::removeHeader($key);
}

function theme_header()
{
    return LmsThemeFacade::getHeader();
}

/**
 * @param string|CallableObject $output
 * @param string|integer|null $key
 */
function enqueue_theme_footer($output, $key = null)
{
    return LmsThemeFacade::addFooter($output, $key);
}

function dequeue_theme_footer($key)
{
    return LmsThemeFacade::removeFooter($key);
}

function theme_footer()
{
    return LmsThemeFacade::getFooter();
}

function t_js($src, $async = false)
{
    return '<script' . ($async ? ' async' : '') . ' src="' . $src . '"></script>';
}

function t_metaProperty($property, $content)
{
    return '<meta property="' . $property . '" content="' . $content . '">';
}

function t_metaName($name, $content)
{
    return '<meta name="' . $name . '" content="' . $content . '">';
}

function t_metaItemProp($name, $content)
{
    return '<meta itemprop="' . $name . '" content="' . $content . '">';
}



function t_title($title)
{
    return '<title>' . $title . '</title>';
}

function flagNameFromLanguage($locale = '')
{
    if (empty($locale)) {
        $locale = currentLocale();
    }
    return strtoupper(allSupportedLocale($locale, 'country'));
}

function flagAssetFromLanguage($locale = '', $size = 16)
{
    return flagAsset(flagNameFromLanguage($locale), $size);
}

function flagAsset($name, $size = 16)
{
    return libraryAsset('flags/' . $size . '/' . $name . '.png');
}

function extractImageUrls($fromString)
{
    if (preg_match_all('/https?:\/\/[^ ]+?(?:\.jpg|\.png|\.gif)/', $fromString, $urls) !== false) {
        return $urls[0];
    }
    return [];
}

/**
 * @param string $name
 * @return string
 */
function wizardKey($name = '')
{
    return Hash::make($name . appRequestKey());
}

/**
 * @param string $key
 * @param string $name
 * @return bool
 */
function isValidWizardKey($key, $name = '')
{
    return Hash::check($name . appRequestKey(), $key);
}


function rdrQueryParam($url)
{
    return AppHelper::SESSION_RDR . '=' . $url;
}

function supportKey($supporter_id = '')
{
    if (!session()->has('support_key')) {
        session(['support_key' => RealtimeChannel::generateKey('mod_sp_')]);
    }
    return session('support_key') . '_' . $supporter_id;
}

function isMatchedUserPassword($value, User $user = null)
{
    if (empty($user)) {
        if (isAuth()) {
            $user = authUser();
        }
    }
    return empty($user) ? false : Hash::check($value, $user->password);
}

#endregion

#region String Functions
/**
 * @param string $input
 * @param int $length
 * @return string
 */
function shorten($input, $length = AppHelper::DEFAULT_SHORTEN_TEXT_LENGTH)
{
    return htmlspecialchars(trim(str_replace(["&nbsp;", "\r\n", "\n", "\r"], ' ', Str::limit($input, $length))), ENT_QUOTES);
}

function htmlShorten($input, $length = AppHelper::DEFAULT_SHORTEN_TEXT_LENGTH)
{
    return htmlspecialchars(trim(str_replace(["&nbsp;", "\r\n", "\n", "\r"], ' ', Str::limit(strip_tags($input), $length))), ENT_QUOTES);
}

function extractLocalizedString($fromString, $locale = null)
{
    static $locales, $fallbackLocale, $currentLocale;
    if (!isset($locales)) {
        $locales = allLocaleCodes();
    }
    if (!isset($fallbackLocale)) {
        $fallbackLocale = config('app.fallback_locale');
    }
    if (!isset($currentLocale)) {
        $currentLocale = currentLocale();
    }

    $fromString = trim($fromString);
    if (empty($fromString)) return '';

    if (empty($locale)) {
        $locale = $currentLocale;
    }

    $fromLength = mb_strlen($fromString);
    if ($fromString{0} == '{' && $fromString{$fromLength - 1} == '}') {
        $fromStrings = explode(',', mb_substr($fromString, 1, $fromLength - 2));
        $strings = [];
        $currentTran = '';
        foreach ($fromStrings as $string) {
            $trans = explode(':', $string);
            $tran = array_shift($trans);
            if (in_array($tran, $locales)) {
                $strings[$tran] = implode(':', $trans);
                $currentTran = $tran;
            } elseif (!empty($currentTran)) {
                $strings[$currentTran] .= ',' . $string;
            }
        }

        if (isset($strings[$locale])) {
            return $strings[$locale];
        } elseif (isset($strings[$fallbackLocale])) {
            return $strings[$fallbackLocale];
        } elseif (!empty($strings)) {
            return '';
        }
    }

    return $fromString;
}

/**
 * @param string $input
 * @param string $append
 * @param string $prepend
 * @return string
 */
function toSlug($input, $append = '', $prepend = '')
{
    $slug = Str::slug($input);
    if (!empty($append)) {
        $slug .= '-' . Str::slug($append);
    }
    if (!empty($prepend)) {
        $slug = Str::slug($prepend) . '-' . $slug;
    }
    return $slug;
}

/**
 * @param string $haystack
 * @param array|string $needle
 * @return bool
 */
function startWith($haystack, $needle)
{
    return Str::startsWith($haystack, $needle);
}

#endregion

#region Transformation
/**
 * @param mixed $var
 * @return bool
 */
function isEmptyAll($var)
{
    $empty = empty($var);
    if (!$empty) {
        if (is_array($var)) {
            $empty = true;
            foreach ($var as $item) {
                if (!isEmptyAll($item)) {
                    $empty = false;
                    break;
                }
            }
        }
    }

    return $empty;
}

/**
 * @param int $input
 * @param int $min_length
 * @return string
 */
function toDigits($input, $min_length = 2)
{
    $max = pow(10, $min_length - 1);
    return $input < $max ? str_repeat('0', $min_length - 1) . $input : $input;
}

/**
 * @param array $params
 * @param string $hash
 * @return string
 */
function toUrlQuery(array $params, $hash = '')
{
    $q = [];
    foreach ($params as $key => $value) {
        $q[] = $key . '=' . $value;
    }
    $q = implode('&', $q);
    if (!empty($q)) {
        $q = '?' . $q;
    }
    if (!empty($hash)) {
        $q .= '#' . $hash;
    }
    return $q;
}

/**
 * @param string|array $input
 * @return string
 */
function escHtml($input)
{
    if (is_array($input)) {
        foreach ($input as &$item) {
            $item = escHtml($item);
        }
        return $input;
    }
    return htmlspecialchars(str_replace(['&nbsp;', "\r\n", "\n", "\r"], ' ', strip_tags($input)), ENT_QUOTES);
}

/**
 * @param mixed $input
 * @param string $type
 * @return string
 */
function escObject($input, &$type)
{
    $type = 'string';
    if (empty($input)) return '';

    if ($input instanceof Arrayable && !$input instanceof \JsonSerializable) {
        $input = $input->toArray();
    } elseif ($input instanceof Jsonable) {
        $type = 'array';
        $input = $input->toJson();
    }
    if (is_array($input)) {
        $type = 'array';
        return json_encode($input);
    } elseif (is_bool($input)) {
        $type = 'bool';
        $input = $input ? '1' : '0';
    } elseif (is_float($input)) {
        $type = 'float';
    } elseif (is_int($input)) {
        $type = 'int';
    }

    return !is_string($input) ? (string)$input : $input;
}

function defPr($value, $default)
{
    return empty($value) ? $default : $value;
}

#endregion

#region Runtime
/**
 * @param string $key
 * @param mixed $default
 * @param string $locale
 * @param bool $assoc
 * @return array|string
 */
function appOption($key, $default = '', $locale = '', $assoc = false)
{
    return AppOptionHelper::get($key, $default, $locale, $assoc);
}

/**
 * @param string $key
 * @param mixed $value
 * @param string $locale
 * @param bool $assoc
 * @return bool
 */
function setAppOption($key, $value, $locale = '', $assoc = false)
{
    return AppOptionHelper::set($key, $value, $locale, $assoc);
}

/**
 * @param string $key
 * @param string $locale
 * @param bool $reload
 * @return bool
 */
function unsetAppOption($key, $locale = '', $reload = false)
{
    return AppOptionHelper::un_set($key, $locale, $reload);
}

/**
 * @return \Illuminate\Database\Eloquent\Collection
 */
function loadAppOption($reload = true)
{
    if ($reload) {
        AppOptionHelper::reload();
    }
    return AppOptionHelper::all();
}

function activatedExtensions()
{
    return ExtensionsFacade::activated();
}

function isActivatedExtension($extension)
{
    return ExtensionsFacade::isActivated($extension);
}

function isStaticExtension($extension)
{
    return ExtensionsFacade::isStatic($extension);
}

function versionJs()
{
    return env('VERSION_JS',3.5);
}

function appName()
{
    return env('APP_NAME');
}

function appDescription()
{
    return env('APP_DESCRIPTION');
}

function appKeywords()
{
    return env('APP_KEYWORDS');
}

function appShortName()
{
    return env('APP_SHORT_NAME');
}

function appVersion()
{
    return env('APP_VERSION');
}

function frameworkVersion()
{
    return 'Laravel ' . \Illuminate\Foundation\Application::VERSION;
}

function appAuthor()
{
    return env('APP_AUTHOR');
}

function appEmail()
{
    return env('APP_EMAIL');
}

function appDomain()
{
    static $domain;
    if (!isset($domain)) {
        $parsedUrl = parse_url(appHomeUrl());
        $domain = $parsedUrl['host'];
    }
    return $domain;
}

function appHomeUrl()
{
    static $url;
    if (!isset($url)) {
        $url = url();
    }
    return $url;
}

function appLogo()
{
    return appHomeUrl() . '/' . env('APP_LOGO');
}

function appDefaultUserProfilePicture()
{
    return appHomeUrl() . '/' . env('APP_DEFAULT_USER_PICTURE');
}

function appRequestKey()
{
    return env('APP_REQUEST_KEY');
}

function appOrtcServer()
{
    return env('ORTC_SERVER');
}

function appOrtcClientKey()
{
    return env('ORTC_CLIENT_KEY');
}

function appOrtcClientSecrent()
{
    return env('ORTC_CLIENT_SECRET');
}

function appOrtcClientToken()
{
    return env('ORTC_CLIENT_TOKEN');
}

function isAuth()
{
    static $is_auth;
    if (!isset($is_auth)) {
        $is_auth = Auth::check();
    }
    return $is_auth;
}

function authUser()
{
    static $auth_user;
    if (!isset($auth_user)) {
        $auth_user = isAuth() ? Auth::user() : false;
    }
    return $auth_user;
}

/**
 * @return array
 */
function allCountries()
{
    return config('laravellocalization.countries');
}

/**
 * @return array
 */
function allNationalites()
{
    return config('laravellocalization.nationality');
}

/**
 * @return array
 */
function allCountryCodes()
{
    return array_keys(config('laravellocalization.countries'));
}

/**
 * @return array
 */
function allCountry($code, $property = '')
{
    if ($code == AppHelper::INTERNATIONAL_COUNTRY_CODE) return trans('nation.international');
    static $countries;
    if (!isset($countries)) {
        $countries = allCountries();
    }
    if (empty($countries[$code])) return null;
    return empty($property) ? $countries[$code] : $countries[$code][$property];
}

/**
 * @return array
 */
function allNationality($code, $property = '')
{
    if ($code == AppHelper::INTERNATIONAL_COUNTRY_CODE) return trans('nation.nationality');
    static $countries;
    if (!isset($countries)) {
        $countries = allNationalites();
    }
    if (empty($countries[$code])) return null;
    return empty($property) ? $countries[$code] : $countries[$code][$property];
}

/**
 * @return array
 */
function fullCurrentLocale()
{
    return currentLocale() . '_' . allSupportedLocale(currentLocale(), 'country');
}

function currentLocale()
{
    static $locale;
    if (!isset($locale)) {
        $locale = App::getLocale();
    }
    return $locale;
}

function currentBrowserLocale()
{
    return LaravelLocalization::getCurrentBrowserLocale();
}

function isDirectLocale()
{
    return LaravelLocalization::isDirectLocale();
}

function setCurrentLocale($locale)
{
    LaravelLocalization::setLocale($locale);
}

/**
 * @return array
 */
function allLocaleCodes()
{
    return array_keys(config('laravellocalization.languages'));
}

/**
 * @return array
 */
function allLocales()
{
    return config('laravellocalization.languages');
}

/**
 * @param string $locale
 * @param string $property
 * @return array|string|null
 */
function allLocale($locale, $property = '')
{
    static $locales;
    if (!isset($locales)) {
        $locales = allLocales();
    }
    if (empty($locales[$locale])) return null;
    return empty($property) ? $locales[$locale] : $locales[$locale][$property];
}

/**
 * @return array
 */
function allSupportedLocaleCodes()
{
    return array_keys(config('laravellocalization.supportedLocales'));
}

/**
 * @return array
 */
function allFullSupportedLocaleCodes()
{
    $allFbLocales = []; // zz anh ko the dat ten no popular hon a, sao lai spe vao thang fb the @@
    $allLocaleCodes = allSupportedLocaleCodes();
    for ($i = 0; $i < count($allLocaleCodes); $i++) {
        $allFbLocales[$i] = $allLocaleCodes[$i] . '_' . allSupportedLocale($allLocaleCodes[$i], 'country');
    }
    return $allFbLocales;
}

/**
 * @return array
 */
function allSupportedLocales()
{
    return config('laravellocalization.supportedLocales');
}

/**
 * @param string $locale
 * @param string $property
 * @return array|string|null
 */
function allSupportedLocale($locale, $property = '')
{
    static $locales;
    if (!isset($locales)) {
        $locales = allSupportedLocales();
    }
    if (empty($locales[$locale])) return null;
    return empty($property) ? $locales[$locale] : $locales[$locale][$property];
}

function currentLocaleNativeReading()
{
    static $localeNativeReading;
    if (!isset($localeNativeReading)) {
        $localeNativeReading = LaravelLocalization::getCurrentLocaleNativeReading();
    }
    return $localeNativeReading;
}

/**
 * @return array
 */
function allGenders()
{
    return config('laravellocalization.genders');
}

function countriesAsOptions($selected_country = 'VN', $required = false)
{
    if($required){
        $options = '<option value="">' . trans('nation.international') . '</option>';
    }else{
        $options = '<option value="' . AppHelper::INTERNATIONAL_COUNTRY_CODE . '">' . trans('nation.international') . '</option>';
    }

    foreach (config('laravellocalization.countries') as $code => $properties) {
        $options .= '<option value="' . $code . '"' . ($selected_country == $code ? ' selected' : '') . '>' . $properties['name'] . '</option>';
    }
    return $options;
}

function nationalityAsOptions($selected_nationality = 'VN', $required = false)
{
    if($required){
        $options = '<option value="">' . trans('nation.nationality') . '</option>';
    }else{
        $options = '<option value="' . AppHelper::INTERNATIONAL_COUNTRY_CODE . '">' . trans('nation.nationality') . '</option>';
    }
    
    foreach (config('laravellocalization.nationality') as $code => $properties) {
        $options .= '<option value="' . $code . '"' . ($selected_nationality == $code ? ' selected' : '') . '>' . $properties['name'] . '</option>';
    }
    return $options;
}

function callingCodesAsOptions($selected_country = 'VN')
{
    $options = '<option value="' . AppHelper::INTERNATIONAL_COUNTRY_CODE . '">' . trans('nation.international') . '</option>';
    foreach (config('laravellocalization.countries') as $code => $properties) {
        $options .= '<option value="' . $code . '"' . ($selected_country == $code ? ' selected' : '') . '>(+' . $properties['calling_code'] . ') ' . $properties['name'] . '</option>';
    }
    return $options;
}

function groupNationAsOption($selected_nationality = 'VN', $required = false)
{
    if($required){
        $options = '<option value="">' . trans('nation.nationality') . '</option>';
    }else{
        $options = '<option value="' . AppHelper::INTERNATIONAL_COUNTRY_CODE . '">' . trans('nation.nationality') . '</option>';
    }
    foreach (config('laravellocalization.countries') as $code => $properties) {
        $options .= '<option value="' . $code . '"' . ($selected_nationality == $code ? ' selected' : '') . ' href="'.$properties['group'].'" >' . $properties['name'] . '</option>';
    }
    return $options;
}

function timeZoneListAsOptions($selected)
{
    return DateTimeHelper::getTimeZoneListAsOptions($selected);
}

function daysOfWeekAsOptions($selected)
{
    return DateTimeHelper::getDaysOfWeekAsOptions($selected);
}

function longDateFormatsAsOptions($selected)
{
    return DateTimeHelper::getLongDateFormatsAsOptions($selected);
}

function shortDateFormatsAsOptions($selected)
{
    return DateTimeHelper::getShortDateFormatsAsOptions($selected);
}

function longTimeFormatsAsOptions($selected)
{
    return DateTimeHelper::getLongTimeFormatsAsOptions($selected);
}

function shortTimeFormatsAsOptions($selected)
{
    return DateTimeHelper::getShortTimeFormatsAsOptions($selected);
}

#endregion

#region File
function maxUploadFileSize()
{
    $max_upload = intval(ini_get('upload_max_filesize'));
    $max_post = intval(ini_get('post_max_size'));
    $memory_limit = intval(ini_get('memory_limit'));
    return min($max_upload, $max_post, $memory_limit) * 1024 * 1024; // in bytes
}

function asByte($size)
{
    return $size . ' byte' . ($size > 1 ? 's' : '');
}

function asKb($size)
{
    return round($size / 1024) . 'KB';
}

function asMb($size)
{
    return round($size / 1024 / 1024) . 'MB';
}

#endregion

#region Routes
function homePath($locale = null)
{
    if (!isset($locale)) {
        return currentLocale();
    }
    return $locale;
}

function translatedPath($path)
{
    return LaravelLocalization::transRoute('routes.' . $path);
}

function translatedAdminPath($path)
{
    return LaravelLocalization::transRoute('routes.admin/' . $path);
}

function localizedPath($path, $locale = null)
{
    return homePath($locale) . '/' . translatedPath($path);
}

function localizedAdminPath($path, $locale = null)
{
    return homePath($locale) . translatedAdminPath($path);
}

#endregion

#region URL
function redirectUrlAfterLogin(User $user)
{
    $redirect_url = homeURL();
    $overwrite_url = session(AppHelper::SESSION_RDR);
    if (!empty($overwrite_url)) {
        $redirect_url = $overwrite_url;
        session([AppHelper::SESSION_RDR => null]);
    } elseif ($user->can('access-admin')) {
        $redirect_url = adminHomeURL($user->language);
    } elseif ($user->hasRole('supporter')) {
        $redirect_url = localizedURL('support-channel/{id?}', ['id' => null], $user->language);
    } elseif ($user->hasRole('student')) {
        $redirect_url = localizedURL('profile',[], $user->language);
        // $redirect_url = localizedURL('student/{id?}', ['id' => null], $user->language);
    } elseif ($user->hasRole('teacher')) {
        $redirect_url = localizedURL('profile',[], $user->language);
        // if (!$user->teacherProfile->isPublicizable()) {
        //     $redirect_url = localizedURL('teacher/becoming', [], $user->language);
        // } else {
        //     $redirect_url = localizedURL('teacher/{id?}', ['id' => null], $user->language);
        // }
    }
    return $redirect_url;
}

function notAnyHomeURL($url, $locale = null)
{
    return $url != homeURL($locale) && $url != adminHomeURL($locale);
}

function nonLocalizedURL($url)
{
    return LaravelLocalization::getNonLocalizedURL($url);
}

function currentURL($locale = null)
{
    if (empty($locale)) {
        return enhancedCurrentUrl();
    }
    return LaravelLocalization::getLocalizedURL($locale, null);
}

function localizedURL($path, $params = [], $locale = null)
{
    return enhancedHomeUrl($path, $params, $locale);
}

function localizedAdminURL($admin_path, $params = [], $locale = null)
{
    return enhancedAdminUrl($admin_path, $params, $locale);
}

function homeURL($locale = null)
{
    if (empty($locale)) {
        return appHomeUrl() . '/' . currentLocale();
    }

    return appHomeUrl() . '/' . $locale;
}

function adminHomeURL($locale = null)
{
    return enhancedAdminUrl('', [], $locale);
}


#endregion

#region Generate URL
function enhancedTransRoute($route)
{
    return LaravelLocalization::transRoute('routes.' . $route);
}

function enhancedEnhancedHomeRoute($route)
{
    return enhancedTransRoute($route);
}

function enhancedAdminRoute($route)
{
    return enhancedTransRoute('admin/' . $route);
}

function enhancedCurrentPath()
{
    $path = parse_url(enhancedCurrentUrl())['path'];
    return empty($path) ? '/' : $path;
}

function enhancedTransPath($route = '', array $params = [], $locale = null)
{
    if (empty($locale)) {
        $locale = currentLocale();
    }
    if (empty($route)) {
        return $locale;
    }
    $route = trans('routes.' . $route);
    foreach ($params as $key => $value) {
        $route = str_replace(['{' . $key . '}', '{' . $key . '?}'], $value, $route);
    }
    return $locale . '/' . $route;
}

function enhancedHomePath($route = '', array $params = [], $locale = null)
{
    return enhancedTransPath($route, $params, $locale);
}

function enhancedAdminPath($route = '', array $params = [], $locale = null)
{
    return empty($route) ? enhancedHomePath('admin', $params, $locale) : enhancedHomePath('admin/' . $route, $params, $locale);
}

function enhancedCurrentUrl()
{
    return request()->url();
}

function enhancedCurrentFullUrl()
{
    return request()->fullUrl();
}

function enhancedTransUrl($route = '', array $params = [], $locale = null)
{
    $path = enhancedTransPath($route, $params, $locale = null);
    return url($path);
}

function enhancedHomeUrl($route = '', array $params = [], $locale = null)
{
    return enhancedTransUrl($route, $params, $locale);
}

function enhancedAdminUrl($route = '', array $params = [], $locale = null)
{
    return empty($route) ? enhancedHomeUrl('admin', $params, $locale) : enhancedHomeUrl('admin/' . $route, $params, $locale);
}

#endregion

#region Action
function pushMessage($channel, $message)
{
    PushClient::getInstance()->sendNow($channel, $message);
}

/**
 * @param $id
 * @param CallableObject $callableObject
 */
function add_action($id, CallableObject $callableObject)
{
    Hook::add($id, $callableObject);
}

function do_action($id, array $params = [])
{
    return Hook::activate($id, $params);
}

/**
 * @param $id
 * @param CallableObject $callableObject
 */
function add_filter($id, CallableObject $callableObject)
{
    ContentFilter::add($id, $callableObject);
}

/**
 * @param string $id
 * @param string $content
 * @return mixed
 */
function content_filter($id, $content)
{
    return ContentFilter::flush($id, $content);
}

/**
 * @param $id
 * @param CallableObject $callableObject
 */
function add_place($id, CallableObject $callableObject)
{
    ContentPlace::add($id, $callableObject);
}

/**
 * @param string $id
 * @return string
 */
function content_place($id, array $params = [])
{
    return ContentPlace::flush($id, $params);
}

#endregion

#region DateTime
/**
 * @param string $time
 * @return string
 */
function defaultTime($time)
{
    return DateTimeHelper::getInstance()->format('Y-m-d H:i:s', $time);
}

/**
 * @param string $time
 * @return string
 */
function defaultTimeTZ($time)
{
    return DateTimeHelper::getInstance()->format('Y-m-d\TH:i:s\Z', $time);
}

function formatTime($format, $time = 'now', $start = 0, $no_offset = false)
{
    return DateTimeHelper::getInstance()->format($format, $time, $start, $no_offset);
}

function fromFormattedTime($format, $inputString, $no_offset = false)
{
    return DateTimeHelper::getInstance()->fromFormat($format, $inputString, $no_offset);
}

function toDatabaseTime($current_format, $inputString, $no_offset = false)
{
    return DateTimeHelper::getInstance()->convertToDatabaseFormat($current_format, $inputString, $no_offset);
}

function currentTimeZone()
{
    return DateTimeHelper::getInstance()->getCurrentTimeZone();
}

function convertTimeZone($str, $timezone = 'UTC')
{
    $time = date_create($str);
    return $time->setTimezone(new \DateTimeZone($timezone));
}

#endregion