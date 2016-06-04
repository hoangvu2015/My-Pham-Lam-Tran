<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-10-28
 * Time: 06:39
 */

namespace Antoree\Providers;

use Antoree\Models\Themes\Extensions;
use Antoree\Models\Themes\Widgets;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['lms_theme'] = $this->app->share(
            function () {
                $lmsTheme = config('app.lms_theme');
                $lmsTheme = '\Antoree\Models\Themes' . '\\' . $lmsTheme . '\Theme';
                return new $lmsTheme;
            }
        );

        $this->app['admin_theme'] = $this->app->share(
            function () {
                $adminTheme = config('app.admin_theme');
                $adminTheme = '\Antoree\Models\Themes' . '\\' . $adminTheme . '\Theme';
                return new $adminTheme;
            }
        );

        $this->app['extensions'] = $this->app->share(
            function () {
                return new Extensions();
            }
        );

        $this->app['widgets'] = $this->app->share(
            function () {
                return new Widgets();
            }
        );
    }
}