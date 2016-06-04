<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-25
 * Time: 15:44
 */

namespace Antoree\Models\Themes\LearningApp\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Antoree\Models\Helpers\Menu;
use Antoree\Models\Helpers\MenuItem;
use Illuminate\Contracts\View\View;

class UserMenuComposer
{
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
        $is_auth = isAuth();
        $auth_user = authUser();

        $menu = new Menu('ul', 'list-group list-group-menu', Request::url());
        $menu->restrictMatching(true);

        $menu->addItem(new MenuItem(
            localizedURL('user/{id?}', ['id' => null]),
            trans('pages.my_public_profile'),
            'li', 'list-group-item', 'link-text-color'
        ))->addItem(new MenuItem(
            localizedURL('user/edit'),
            trans('pages.edit_my_profile'),
            'li', 'list-group-item', 'link-text-color'
        ))->addItem(new MenuItem(
            localizedURL('user/documents'),
            trans('pages.my_documents_title'),
            'li', 'list-group-item', 'link-text-color'
        ));
        if ($is_auth && $auth_user->can('compose-learning-resources')) {
            $menu->addItem(new MenuItem(
                localizedURL('courses/by-me'),
                trans('pages.my_courses'),
                'li', 'list-group-item', 'link-text-color', '<span>', '</span>'
            ));
        }
        if ($is_auth && $auth_user->can('compose-blog-articles')) {
            $menu->addItem(new MenuItem(
                localizedURL('blog/add'),
                trans('form.action_compose') . ' ' . trans_choice('label.blog_article_lc', 1),
                'li', 'list-group-item', 'link-text-color', '<span>', '</span>'
            ));
        }
        $menu->addItem(new MenuItem(
            localizedURL('auth/logout'),
            trans('form.action_logout'),
            'li', 'list-group-item', 'link-text-color', '<span>', '</span>'
        ));

        $view->with('user_menu', $menu->render());
    }
}