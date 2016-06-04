<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-10-28
 * Time: 02:57
 */

namespace Antoree\Models\Themes\AdminLte;

use Antoree\Models\Themes\AdminTheme;


class Theme extends AdminTheme
{
    const NAME = 'AdminLte';
    const VIEW = 'admin_lte';

    public function __construct()
    {
        parent::__construct();
    }

    protected function registerComposers($is_auth = false)
    {
        view()->composer(
            $this->masterPath('admin_menu'), Composers\AdminMenuComposer::class
        );
    }
}