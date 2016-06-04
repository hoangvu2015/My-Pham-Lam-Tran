<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-10-28
 * Time: 02:54
 */

namespace Antoree\Models\Themes;

use Illuminate\Support\Facades\Facade;

class LmsThemeFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lms_theme';
    }
}