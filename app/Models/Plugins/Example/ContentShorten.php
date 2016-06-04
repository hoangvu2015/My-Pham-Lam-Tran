<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-16
 * Time: 12:00
 */

namespace Antoree\Models\Plugins\Example;

use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Themes\Extension as BaseExtension;

class ContentShorten extends BaseExtension
{
    const EXTENSION_NAME = 'content_shorten';
    const EXTENSION_DISPLAY_NAME = 'Content Shorten';
    const EXTENSION_DESCRIPTION = 'This is an example extension';

    public function register()
    {
        add_filter('content_shorten', function ($content) {
            return htmlShorten($content, AppHelper::DEFAULT_SHORTEN_TEXT_LENGTH);
        });
    }
}