<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-10-28
 * Time: 04:50
 */

namespace Antoree\Models\Themes;


abstract class AdminTheme extends Theme
{
    public function __construct()
    {
        parent::__construct(Theme::TYPE_ADMIN);
    }
}