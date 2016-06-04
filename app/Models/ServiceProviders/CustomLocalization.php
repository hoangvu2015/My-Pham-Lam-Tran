<?php

namespace Antoree\Models\ServiceProviders;

use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Exceptions\SupportedLocalesNotDefined;
use Mcamara\LaravelLocalization\Exceptions\UnsupportedLocaleException;
use Illuminate\Config\Repository;
use Illuminate\View\Factory;
use Illuminate\Translation\Translator;
use Illuminate\Routing\Router;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\URL;

use Mcamara\LaravelLocalization\LaravelLocalization;

class CustomLocalization extends LaravelLocalization
{
    // linhnt.aim@outlook.com
    /**
     * Current browser locale
     *
     * @var string
     */
    protected $browserLocale = false;

    /**
     * Whether the locale detected directly by url path or not
     *
     * @var string
     */
    protected $directLocale = false;
    // end fixed // if no fixed, delete
    
    /**
     * Set and return current locale
     *
     * @param  string $locale Locale to set the App to (optional)
     *
     * @return string                    Returns locale (if route has any) or null (if route does not have a locale)
     */
    public function setLocale($locale = null)
    {
        if (empty($locale) || !is_string($locale)) {
            // If the locale has not been passed through the function
            // it tries to get it from the first segment of the url
            $locale = $this->request->segment(1);
        }

        // linhnt.aim@outlook.com
        $this->directLocale = false;
        // end fixed // if no fixed, delete

        if (!empty($this->supportedLocales[$locale])) {
            $this->currentLocale = $locale;

            // linhnt.aim@outlook.com
            $this->directLocale = true;
            // end fixed // if no fixed, delete
        } else {
            // if the first segment/locale passed is not valid
            // the system would ask which locale have to take
            // it could be taken by the browser
            // depending on your configuration

            $locale = null;

            // if we reached this point and hideDefaultLocaleInURL is true
            // we have to assume we are routing to a defaultLocale route.
            if ($this->hideDefaultLocaleInURL()) {
                $this->currentLocale = $this->defaultLocale;
            }
            // but if hideDefaultLocaleInURL is false, we have
            // to retrieve it from the browser...
            else {
                $this->currentLocale = $this->getCurrentLocale();
                // linhnt.aim@outlook.com
                $this->browserLocale = $this->currentLocale;
                $path = $this->request->path();
                $matchedLocale = false;
                foreach (Lang::get('routes', [], $this->currentLocale) as $name => $trans) { // lang of default locale
                    $name_regex = '/^' . str_replace('/', '\\/', preg_replace('/\{[^\}]+\}/', '(.*)', $trans)) . '$/';
                    if (preg_match($name_regex, $path, $matches)) {
                        $matchedLocale = true;
                        break;
                    }
                }
                if (!$matchedLocale) {
                    $this->currentLocale = $this->defaultLocale;
                }
                // end fixed // if no fixed, delete
            }
        }

        $this->app->setLocale($this->currentLocale);

        return $locale;
    }

    /**
     * Returns an URL adapted to $locale
     *
     * @throws SupportedLocalesNotDefined
     * @throws UnsupportedLocaleException
     *
     * @param  string|boolean $locale Locale to adapt, false to remove locale
     * @param  string|false $url URL to adapt in the current language. If not passed, the current url would be taken.
     * @param  array $attributes Attributes to add to the route, if empty, the system would try to extract them from the url.
     *
     *
     * @return string|false                URL translated, False if url does not exist
     */
    public function getLocalizedURL($locale = null, $url = null, $attributes = array())
    {
        if ($locale === null) {
            $locale = $this->getCurrentLocale();
        }

        if (!$this->checkLocaleInSupportedLocales($locale)) {
            throw new UnsupportedLocaleException('Locale \'' . $locale . '\' is not in the list of supported locales.');
        }

        if (empty($attributes)) {
            $attributes = $this->extractAttributes($url);
        }

        if (empty($url)) {
            if (!empty($this->routeName)) {
                return $this->getURLFromRouteNameTranslated($locale, $this->routeName, $attributes);
            }

            $url = $this->request->fullUrl();

        }

        // linhnt.aim@outlook.com
        $parsed_url = parse_url($url);
        if (!empty($parsed_url['query'])) {
            if ($parsed_url['query'] == '}' && mb_strpos($parsed_url['path'], '{') !== false) {
                $parsed_url['path'] .= '?}';
                $parsed_url['query'] = '';
            } else {
                $tmp = explode('=', $parsed_url['query'])[0];
                $i = mb_strpos($tmp, '?');
                while ($i !== false) {
                    if ($tmp{$i + 1} != '}') {
                        $parsed_url['path'] .= '?' . mb_substr($tmp, 0, $i);
                        $parsed_url['query'] = mb_substr($parsed_url['query'], $i + 1);
                        break;
                    }
                    $i = mb_strpos($tmp, '?', $i + 1);
                }
            }
        }
        // end fixed // if no fixed, delete

        if ($locale && $translatedRoute = $this->findTranslatedRouteByUrl($url, $attributes, $this->currentLocale)) {
            // linhnt.aim@outlook.com
            $translatedUrl = $this->getURLFromRouteNameTranslated($locale, $translatedRoute, $attributes);
            if (!empty($parsed_url['query'])) {
                $translatedUrl .= '?' . $parsed_url['query'];
            }
            if (!empty($parsed_url['fragment'])) {
                $translatedUrl .= '#' . $parsed_url['fragment'];
            }
            return $translatedUrl;
            // end fixed // if no fixed, delete
//            return $this->getURLFromRouteNameTranslated($locale, $translatedRoute, $attributes); // if no fixed, uncomment
        }

        $base_path = $this->request->getBaseUrl();
//        $parsed_url = parse_url($url); // if no fixed, uncomment
        $url_locale = $this->getDefaultLocale();

        if (!$parsed_url || empty($parsed_url['path'])) {
            $path = $parsed_url['path'] = "";
        } else {
            $parsed_url['path'] = str_replace($base_path, '', '/' . ltrim($parsed_url['path'], '/'));
            $path = $parsed_url['path'];
            foreach ($this->getSupportedLocales() as $localeCode => $lang) {
                $parsed_url['path'] = preg_replace('%^/?' . $localeCode . '/%', '$1', $parsed_url['path']);
                if ($parsed_url['path'] !== $path) {
                    $url_locale = $localeCode;
                    break;
                }

                $parsed_url['path'] = preg_replace('%^/?' . $localeCode . '$%', '$1', $parsed_url['path']);
                if ($parsed_url['path'] !== $path) {
                    $url_locale = $localeCode;
                    break;
                }
            }
        }

        $parsed_url['path'] = ltrim($parsed_url['path'], '/');

        if ($translatedRoute = $this->findTranslatedRouteByPath($parsed_url['path'], $url_locale)) {
            // linhnt.aim@outlook.com
            $translatedUrl = $this->getURLFromRouteNameTranslated($locale, $translatedRoute, $attributes);
            if (!empty($parsed_url['query'])) {
                $translatedUrl .= '?' . $parsed_url['query'];
            }
            if (!empty($parsed_url['fragment'])) {
                $translatedUrl .= '#' . $parsed_url['fragment'];
            }
            return $translatedUrl;
            // end fixed // if no fixed, delete
//            return $this->getURLFromRouteNameTranslated($locale, $translatedRoute, $attributes); // if no fixed, uncomment
        }

        if (!empty($locale) && ($locale != $this->defaultLocale || !$this->hideDefaultLocaleInURL())) {
            $parsed_url['path'] = $locale . '/' . ltrim($parsed_url['path'], '/');
        }
        $parsed_url['path'] = ltrim(ltrim($base_path, '/') . '/' . $parsed_url['path'], '/');

        //Make sure that the pass path is returned with a leading slash only if it come in with one.
        if (starts_with($path, '/') === true) {
            $parsed_url['path'] = '/' . $parsed_url['path'];
        }
        $parsed_url['path'] = rtrim($parsed_url['path'], '/');

        $url = $this->unparseUrl($parsed_url);

        if ($this->checkUrl($url)) {
            return $url;
        }

        return $this->createUrlFromUri($url);
    }

    // linhnt.aim@outlook.com
    private $cacheTranslatedRoutes = [];

    public function getURLFromCacheRouteNameTranslated($locale, $transKeyName, $attributes = array())
    {
        if (!is_string($locale)) {
            $locale = $this->getDefaultLocale();
        }

        if (isset($this->cacheTranslatedRoutes[$locale][$transKeyName])) {
            $route = $this->substituteAttributesInRoute($attributes, $this->cacheTranslatedRoutes[$locale][$transKeyName]);
            return rtrim($this->createUrlFromUri($route));
        }

        return false;
    }
    // end fixed // if no fixed, delete


    /**
     * Returns an URL adapted to the route name and the locale given
     *
     * @throws SupportedLocalesNotDefined
     * @throws UnsupportedLocaleException
     *
     * @param  string|boolean $locale Locale to adapt
     * @param  string $transKeyName Translation key name of the url to adapt
     * @param  array $attributes Attributes for the route (only needed if transKeyName needs them)
     *
     * @return string|false    URL translated
     */
    public function getURLFromRouteNameTranslated($locale, $transKeyName, $attributes = array())
    {
        if (!$this->checkLocaleInSupportedLocales($locale)) {
            throw new UnsupportedLocaleException('Locale \'' . $locale . '\' is not in the list of supported locales.');
        }

        if (!is_string($locale)) {
            $locale = $this->getDefaultLocale();
        }

        $route = "";

        // linhnt.aim@outlook.com
        if (isset($this->cacheTranslatedRoutes[$locale][$transKeyName])) {
            $route = $this->substituteAttributesInRoute($attributes, $this->cacheTranslatedRoutes[$locale][$transKeyName]);
        } else {
            // end fixed // if no fixed, delete
            if (!($locale === $this->defaultLocale && $this->hideDefaultLocaleInURL())) {
                $route = '/' . $locale;
            }
            if (is_string($locale) && $this->translator->has($transKeyName, $locale)) {
                $translation = $this->translator->trans($transKeyName, [], "", $locale);
                $route .= "/" . $translation;

                // linhnt.aim@outlook.com
                if (!isset($this->cacheTranslatedRoutes[$locale])) {
                    $this->cacheTranslatedRoutes[$locale] = [];
                }
                $this->cacheTranslatedRoutes[$locale][$transKeyName] = $route;
                // end fixed // if no fixed, delete

                $route = $this->substituteAttributesInRoute($attributes, $route);
            }

            if (empty($route)) {
                // This locale does not have any key for this route name
                return false;
            }
        }

        return rtrim($this->createUrlFromUri($route));
    }

    // linhnt.aim@outlook.com
    private $cacheNonLocalizedURLs = [];
    // end fixed // if no fixed, delete

    /**
     * It returns an URL without locale (if it has it)
     * Convenience function wrapping getLocalizedURL(false)
     *
     * @param  string|false $url URL to clean, if false, current url would be taken
     *
     * @return string           URL with no locale in path
     */
    public function getNonLocalizedURL($url = null)
    {
//        return $this->getLocalizedURL(false, $url); // if no fixed, uncomment

        // linhnt.aim@outlook.com
        if (empty($url)) {
            $url = $this->request->fullUrl();
        }

        if (isset($this->cacheNonLocalizedURLs[$url])) {
            return $this->cacheNonLocalizedURLs[$url];
        }

        $nonLocalizedUrl = $this->getLocalizedURL(false, $url);
        $this->cacheNonLocalizedURLs[$url] = $nonLocalizedUrl;
        return $nonLocalizedUrl;
        // end fixed // if no fixed, delete
    }

    // linhnt.aim@outlook.com
    /**
     * Returns browser language
     *
     * @return string current language
     */
    public function getCurrentBrowserLocale()
    {
        if ($this->browserLocale) {
            return $this->browserLocale;
        }

        if ($this->currentLocale) {
            return $this->currentLocale;
        }

        // or get application default language
        return $this->configRepository->get('app.locale');
    }

    public function isDirectLocale()
    {
        return $this->directLocale;
    }
    // end fixed // if no fixed, delete

    /**
     * Change route attributes for the ones in the $attributes array
     *
     * @param $attributes array Array of attributes
     * @param string $route string route to substitute
     * @return string route with attributes changed
     */
    protected function substituteAttributesInRoute($attributes, $route)
    {
        foreach ($attributes as $key => $value) {
            // linhnt.aim@outlook.com
            $route = str_replace(['{' . $key . '}', '{' . $key . '?}'], $value, $route);
            // end fixed // if no fixed, delete
//            $route = str_replace("{" . $key . "}", $value, $route); // end fixed // if no fixed, uncomment
//            $route = str_replace("{" . $key . "?}", $value, $route); // end fixed // if no fixed, uncomment
        }

        // delete empty optional arguments that are not in the $attributes array
        $route = preg_replace('/\/{[^)]+\?}/', '', $route);

        return $route;
    }

    /**
     * Returns the translated route for an url and the attributes given and a locale
     *
     * @throws SupportedLocalesNotDefined
     * @throws UnsupportedLocaleException
     *
     * @param  string|false|null $url Url to check if it is a translated route
     * @param  array $attributes Attributes to check if the url exists in the translated routes array
     * @param  string $locale Language to check if the url exists
     *
     * @return string|false                Key for translation, false if not exist
     */
    protected function findTranslatedRouteByUrl($url, $attributes, $locale)
    {
        if (empty($url)) {
            return false;
        }

        // linhnt.aim@outlook.com
        $noQueryUrl = explode('=', $url)[0];
        $i = mb_strpos($noQueryUrl, '?');
        while ($i !== false) {
            if ($noQueryUrl{$i + 1} != '}') {
                $noQueryUrl = mb_substr($noQueryUrl, 0, $i);
                break;
            }
            $i = mb_strpos($noQueryUrl, '?', $i + 1);
        }
        $nonLocalizedUrl = $this->getNonLocalizedURL($noQueryUrl);
        // end fixed // if no fixed, delete

        // check if this url is a translated url
        foreach ($this->translatedRoutes as $translatedRoute) {
            $routeName = $this->getURLFromRouteNameTranslated($locale, $translatedRoute, $attributes);

            // linhnt.aim@outlook.com
            if ($this->getNonLocalizedURL($routeName) == $nonLocalizedUrl) {
                // end fixed // if no fixed, delete
//            if ( $this->getNonLocalizedURL($routeName) == $this->getNonLocalizedURL($url) ) { // if no fixed, uncomment
                return $translatedRoute;
            }

        }

        return false;
    }
}
