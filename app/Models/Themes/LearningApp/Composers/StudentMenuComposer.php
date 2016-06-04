<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-09-09
 * Time: 15:44
 */

namespace Antoree\Models\Themes\LearningApp\Composers;

use Illuminate\Support\Facades\Request;
use Antoree\Models\Helpers\Menu;
use Antoree\Models\Helpers\MenuItem;
use Illuminate\Contracts\View\View;

class StudentMenuComposer
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
//            localizedURL('student/dashboard'),
//            trans('pages.my_dashboard'),
//            'li', 'list-group-item', 'link-text-color'
//        ))->addItem(new MenuItem(
            localizedURL('student/edit'),
            trans('pages.edit_my_profile'),
            'li', 'list-group-item', 'link-text-color'
        ))
        // ->addItem(new MenuItem(
        //     localizedURL('student/documents'),
        //     trans('pages.my_documents_title'),
        //     'li', 'list-group-item', 'link-text-color'
        // ))
        ->addItem(new MenuItem(
//            localizedURL('student/learning-requests'),
//            trans('pages.my_requests'),
//            'li', 'list-group-item', 'link-text-color'
//        ))->addItem(new MenuItem(
//            localizedURL('student/courses'),
//            trans('pages.my_courses'),
//            'li', 'list-group-item', 'link-text-color'
//        ))->addItem(new MenuItem(
//            localizedURL('student/messages'),
//            trans('pages.my_messages'),
//            'li', 'list-group-item', 'link-text-color'
//        ))->addItem(new MenuItem(
            localizedURL('auth/logout'),
            trans('form.action_logout'),
            'li', 'list-group-item', 'link-text-color', '<span>', '</span>'
        ));

        $view->with('student_menu', $menu->render());
    }
}