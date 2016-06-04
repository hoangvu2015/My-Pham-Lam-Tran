<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-09-16
 * Time: 03:08
 */

namespace Antoree\Models\Themes\LearningApp\Composers;

use Illuminate\Support\Facades\Request;
use Antoree\Models\Helpers\Menu;
use Antoree\Models\Helpers\MenuItem;
use Illuminate\Contracts\View\View;

class TeacherMenuComposer
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
        $menu = new Menu('ul', 'list-group list-group-menu', Request::url());
        $menu->restrictMatching(true);

        $menu->addItem(new MenuItem(
            localizedURL('teacher/{id?}', ['id' => null]),
            trans('pages.my_public_profile'),
            'li', 'list-group-item', 'link-text-color'
        ))
        ->addItem(new MenuItem(
//            LaravelLocalization::getLocalizedURL(null, 'teacher/dashboard'),
//            trans('pages.my_dashboard'),
//            'li', 'list-group-item', 'link-text-color'
//        ))->addItem(new MenuItem(
            localizedURL('teacher/edit'),
            trans('pages.edit_my_profile'),
            'li', 'list-group-item', 'link-text-color'
        ))
        // ->addItem(new MenuItem(
        //     localizedURL('teacher/documents'),
        //     trans('pages.my_documents_title'),
        //     'li', 'list-group-item', 'link-text-color'
        // ))
        // ->addItem(new MenuItem(
        //     localizedURL('courses/by-me'),
        //     trans('pages.my_courses'),
        //     'li', 'list-group-item', 'link-text-color'
        // ))
        ->addItem(new MenuItem(
            localizedURL('blog/add'),
            trans('form.action_compose') . ' ' . trans_choice('label.blog_article_lc', 1),
            'li', 'list-group-item', 'link-text-color', '<span>', '</span>'
//        ))->addItem(new MenuItem(
//            LaravelLocalization::getLocalizedURL(null, 'teacher/learning-requests'),
//            trans('pages.my_requests'),
//            'li', 'list-group-item', 'link-text-color'
//        ))->addItem(new MenuItem(
//            LaravelLocalization::getLocalizedURL(null, 'teacher/messages'),
//            trans('pages.my_messages'),
//            'li', 'list-group-item', 'link-text-color'
        ))
        ->addItem(new MenuItem(
            localizedURL('auth/logout'),
            trans('form.action_logout'),
            'li', 'list-group-item', 'link-text-color', '<span>', '</span>'
        ));

        $view->with('teacher_menu', $menu->render());
    }
}