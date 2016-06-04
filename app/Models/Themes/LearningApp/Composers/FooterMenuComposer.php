<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-23
 * Time: 07:29
 */

namespace Antoree\Models\Themes\LearningApp\Composers;

use Antoree\Models\Helpers\Menu;
use Antoree\Models\Helpers\MenuItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;

class FooterMenuComposer
{
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $match_url = Request::url();
        $footer_menu = new Menu('ul', 'dropup languages-chooser', $match_url);
        $footer_menu->addItem(new MenuItem(
            '#',
            currentLocaleNativeReading(),
            'li', 'locale', '', '', ' <span class="caret"></span>'
        ));
        $langMenu = new Menu('ul', 'dropdown-menu dropdown-menu-right', $match_url);
        foreach (allSupportedLocales() as $localeCode => $properties) {
//            if($localeCode!=LaravelLocalization::getCurrentLocale()) {
            $langMenu->addItem(new MenuItem(currentURL($localeCode), $properties['native'],
                'li', $localeCode == currentLocale() ? 'active' : '', '',
                '<img class="flag-24" src="' . flagAssetFromLanguage($localeCode, 24) . '"> &nbsp; '
            ));
        }
        $langMenu->addItem(new MenuItem(
            null, null, 'li', 'divider'
        ))->addItem(new MenuItem(
            localizedURL('localization-settings'),
            trans('pages.page_localization_settings_title'),
            'li', '', '', '<i class="fa fa-cog"></i> &nbsp; '
        ));
        $footer_menu->last()->enableDropDown()->setChildMenu($langMenu);

        $view->with('footer_menu', $footer_menu->render());
    }
}