<?php

namespace Antoree\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Antoree\Models\BlogCategory;

class ViewController extends Controller
{
    /**
     * @var \Antoree\Models\Themes\Theme
     */
    protected $theme;

    protected $globalViewData;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $adminPath = localizedPath('admin', $this->locale);
        $authPath = localizedPath('auth', $this->locale);
        $passwordPath = localizedPath('password', $this->locale);
        $documentPath = localizedPath('documents', $this->locale);
        if ($request->is($adminPath, $adminPath . '/*', $authPath . '/*', $passwordPath . '/*', $documentPath . '/*')) {
            $this->theme = app('admin_theme');
        } else {
            $this->theme = app('lms_theme');
        }

        if (!defined('ELFINDER_IMG_PARENT_URL')) {
            define('ELFINDER_IMG_PARENT_URL', libraryAsset('elfinder'));
        }

        $this->theme->register($this->is_auth);

        $blog_categories = BlogCategory::where('type', BlogCategory::BLOG)->get();
        $can_add_blog = $this->is_auth && $this->auth_user->can('compose-blog-articles');
        $can_edit_blog = $this->is_auth && $this->auth_user->hasRole('blog-editor');

        $this->globalViewData = [
            'site_locale' => $this->locale,
            'site_version' => appVersion(),
            'site_name' => appName(),
            'site_logo' => appLogo(),
            'site_keywords' => appKeywords(),
            'site_short_name' => appShortName(),
            'site_description' => appDescription(),
            'site_author' => appAuthor(),
            'site_email' => appEmail(),
            'site_domain' => appDomain(),
            'site_home_url' => appHomeUrl(),
            'is_auth' => $this->is_auth,
            'auth_user' => $this->auth_user,
            'session_id' => $request->session()->getId(),
            'blog_categories' => $blog_categories,
            'can_add_blog' => $can_add_blog,
            'can_edit_blog' => $can_edit_blog,
        ];
        foreach ($this->globalViewData as $key => $value) {
            view()->share($key, $value);
        }

        gettingUtmAndRefererHostname($request);
    }

    protected function themePage($name)
    {
        return $this->theme->page($name);
    }
}
