<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-09-24
 * Time: 15:39
 */

namespace Antoree\Models\Themes\AdminLte\Composers;

use Antoree\Models\Helpers\Menu;
use Antoree\Models\Helpers\MenuItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AdminMenuComposer
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
        $menu = new Menu('ul', 'sidebar-menu', Request::url());

        $user = authUser();

        if ($user->can('access-admin')) {
            // Dashboard
            $menu->addItem(new MenuItem( // add a menu item
                adminHomeURL(),
                trans('pages.admin_dashboard_title'), 'li', '', '', '<i class="fa fa-dashboard"></i> <span>', '</span>'
            ));
            // File Manager
            $menu->addItem(new MenuItem( // add a menu item
                localizedAdminURL('my-documents'),
                trans('pages.my_documents_title'), 'li', '', '', '<i class="fa fa-file"></i> <span>', '</span>'
            ));


            if ($user->hasRole('admin')) {
                // System Settings
                $menu->addItem(new MenuItem( // add a menu header
                    null,
                    mb_strtoupper(trans('pages.admin_system_settings_title')), 'li', 'header'
                ));
                $menu->addItem(new MenuItem( // add a menu item
                    localizedAdminURL('app-options'),
                    trans('pages.admin_app_options_title'), 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));
                $menu->addItem(new MenuItem( // add a menu item
                    localizedAdminURL('roles'),
                    trans('pages.admin_roles_title'), 'li', '', '', '<i class="fa fa-unlock-alt"></i> <span>', '</span>'
                ));
                $menu->addItem(new MenuItem( // add a menu item
                    localizedAdminURL('users'),
                    trans('pages.admin_users_title'), 'li', '', '', '<i class="fa fa-user"></i> <span>', '</span>'
                ));
                // Theme Settings
                $menu->addItem(new MenuItem( // add a menu header
                    null,
                    mb_strtoupper(trans('pages.admin_theme_settings_title')), 'li', 'header'
                ));
                $menu->addItem(new MenuItem( // add a menu item
                    localizedAdminURL('extensions'),
                    trans('pages.admin_extensions_title'), 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));
                $menu->addItem(new MenuItem( // add a menu item
                    localizedAdminURL('widgets'),
                    trans('pages.admin_widgets_title'), 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));
                $menu->addItem(new MenuItem(  // add an example menu item which have sub menu
                    '#',
                    trans('pages.admin_ui_lang_title'), 'li', 'treeview', '', '<i class="fa fa-table"></i> <span>', '</span> <i class="fa fa-angle-left pull-right"></i>'
                ));
                $sub_menu = new Menu('ul', 'treeview-menu', Request::url());
                $sub_menu->addItem(new MenuItem( // add a menu item
                    localizedAdminURL('ui-lang/php'),
                    trans('pages.admin_ui_lang_php_title'), 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));
                $sub_menu->addItem(new MenuItem( // add a menu item
                    localizedAdminURL('ui-lang/email'),
                    trans('pages.admin_ui_lang_email_title'), 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));
                $menu->last()->setChildMenu($sub_menu);

                //Link categories items
                $menu->addItem(new MenuItem( // add a menu header
                    null,
                    mb_strtoupper(trans('pages.admin_link_header')), 'li', 'header'
                ));
                $menu->addItem(new MenuItem( //add a menu item
                    localizedAdminURL('link/categories'),
                    trans('pages.admin_link_categories_title'), 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));
                $menu->addItem(new MenuItem( //add a menu item
                    localizedAdminURL('link/items'),
                    trans('pages.admin_link_items_title'), 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));

                //FAQ items
                $menu->addItem(new MenuItem( // add a menu header
                    null,
                    mb_strtoupper(trans('pages.admin_faq_header')), 'li', 'header'
                ));
                $menu->addItem(new MenuItem( // add a menu item
                    localizedAdminURL('faq/categories'),
                    trans('pages.admin_faq_categories_title'), 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));
                $menu->addItem(new MenuItem( // add a menu item
                    localizedAdminURL('faq/articles'),
                    trans('pages.admin_faq_articles_title'), 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));
            }

            
            if ($user->hasRole('learning-editor')) {
                $menu->addItem(new MenuItem( // add a menu item
                    localizedAdminURL('subscribe'),
                    'Email đăng ký', 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));

            }

            //Blog items
            if ($user->hasRole('blog-editor')) {
                $menu->addItem(new MenuItem( // add a menu header
                    null,
                    mb_strtoupper(trans('pages.admin_blog_header')), 'li', 'header'
                ));
                $menu->addItem(new MenuItem( //add a menu item
                    localizedAdminURL('blog/categories'),
                    trans('pages.admin_blog_categories_title'), 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));
                $menu->addItem(new MenuItem( //add a menu item
                    localizedAdminURL('blog/articles'),
                    trans('pages.admin_blog_articles_title'), 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));
            }

            //Product items
            if ($user->hasRole('admin')) {
                $menu->addItem(new MenuItem( // add a menu header
                    null,
                    mb_strtoupper('Sản Phẩm'), 'li', 'header'
                ));
                $menu->addItem(new MenuItem( //add a menu item
                    localizedAdminURL('category-product'),
                    'Danh Mục', 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));
                $menu->addItem(new MenuItem( //add a menu item
                    localizedAdminURL('product'),
                    'Sản Phẩm', 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
                ));
            }

            // Example
//            $menu->addItem(new MenuItem( // add an example header
//                null,
//                trans('pages.admin_example_settings'), 'li', 'header'
//            ));
//            $menu->addItem(new MenuItem( // add an example menu item
//                '#',
//                trans('pages.admin_example_title'), 'li', '', '', '<i class="fa fa-table"></i> <span>', '</span>'
//            ));
//            $menu->addItem(new MenuItem(  // add an example menu item which have sub menu
//                '#',
//                trans('pages.example'), 'li', 'treeview', '', '<i class="fa fa-table"></i> <span>', '</span> <i class="fa fa-angle-left pull-right"></i>'
//            ));
//            // create sub menu
//            $sub_menu = new Menu('ul', 'treeview-menu');
//            // add sub menu items
//            $sub_menu->addItem(new MenuItem(
//                '#',
//                trans('pages.example'), 'li', '', '', '<i class="fa fa-table"></i> '
//            ));
//            $sub_menu->addItem(new MenuItem(
//                '#',
//                trans('pages.example'), 'li', '', '', '<i class="fa fa-table"></i> ', ' <i class="fa fa-angle-left pull-right"></i>'
//            ));
//            // create sub sub menu
//            $sub_sub_menu = new Menu('ul', 'treeview-menu');
//            // add sub menu items
//            $sub_sub_menu->addItem(new MenuItem(
//                '#',
//                trans('pages.example'), 'li', '', '', '<i class="fa fa-table"></i> '
//            ));
//            $sub_sub_menu->addItem(new MenuItem(
//                '#',
//                trans('pages.example'), 'li', '', '', '<i class="fa fa-table"></i> '
//            ));
//            // add sub sub menu to current sub menu item
//            $sub_menu->last()->setChildMenu($sub_sub_menu);
//            // add sub menu to current menu item
//            $menu->last()->setChildMenu($sub_menu);
        }

        $langMenu = new Menu('ul', 'menu');
        foreach (allSupportedLocales() as $localeCode => $properties) {
//            if($localeCode!=LaravelLocalization::getCurrentLocale()) {
            $langMenu->addItem(new MenuItem(
                currentURL($localeCode),
                $properties['native'],
                'li', $localeCode == currentLocale() ? 'active' : '','','<h4>','</h4>'
            ));
        }

        $notification_menu = new Menu('ul', 'menu', '', 'notification-holder');
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->take(10)->get();
        foreach ($notifications as $notification) {
            $notification_menu->addItem(new MenuItem(
                $notification->url,
                $notification->message,
                'li', $notification->read ? 'read' : 'unread', '', '<h4>',
                '</h4><p><small><i class="fa fa-clock-o"></i> <span class="time-ago" title="' . $notification->timeTz . '">' . $notification->time . '</span></small></p>',
                'notification-' . $notification->id
            ));
        }

        $view->with('admin_menu', $menu->render())
            ->with('language_menu', $langMenu->render())
            ->with('notification_menu', $notification_menu->render());
    }
}