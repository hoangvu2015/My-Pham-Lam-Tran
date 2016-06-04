<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-09-09
 * Time: 13:53
 */

namespace Antoree\Models\Themes\LearningApp\Composers;

use Antoree\Models\Helpers\Menu;
use Antoree\Models\Helpers\MenuItem;
use Antoree\Models\Teacher;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;

class MainMenuComposer
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
        $main_menu = new Menu('ul', 'nav navbar-nav navbar-nav-margin-left', $match_url);
        $main_menu->addItem(new MenuItem(
            homeURL(),
            trans('pages.page_home_title')
        ))->addItem(new MenuItem(
            localizedURL('teachers'),
            trans('pages.page_teachers_title')
//        ))->addItem(new MenuItem(
//            localizedURL('courses'),
//            trans('pages.page_courses_title')
        ))->addItem(new MenuItem(
            localizedURL('blog'),
            trans('pages.page_blog_title')
        ));
        $blogMenu = new Menu('ul', 'dropdown-menu');

        $main_menu_right = isAuth() ?
            new Menu('ul', 'nav navbar-nav navbar-nav-bordered', $match_url) :
            new Menu('ul', 'nav navbar-nav navbar-nav-bordered navbar-nav-margin-right', $match_url);
        $main_menu_right->addItem(new MenuItem(
            '#',
            '<img src="' . flagAssetFromLanguage(null, 48) . '">',
            'li', 'locale hidden-xs', '', '', ' <span class="caret"></span>', '', trans('form.action_change') . ' ' . trans_choice('label.language', 1)
        ));
        $langMenu = new Menu('ul', 'dropdown-menu');
        foreach (allSupportedLocales() as $localeCode => $properties) {
//            if($localeCode!=LaravelLocalization::getCurrentLocale()) {
            $langMenu->addItem(new MenuItem(currentURL($localeCode), $properties['native'],
                'li', $localeCode == currentLocale() ? 'active' : '', '',
                '<img class="flag-24" src="' . flagAssetFromLanguage($localeCode, 24) . '"> &nbsp; '
            ));
        }
        $main_menu_right->last()->enableDropDown()->setChildMenu($langMenu);
        if (isAuth()) {
            $auth_user = authUser();

            $main_menu_right->addItem(new MenuItem('#', shorten($auth_user->name, 10), 'li', 'user', '',
                '<span class="hidden-xs hidden-sm"><img src="' . $auth_user->profile_picture . '" alt="' . $auth_user->name . '" class="img-circle auto-profile-picture"></span> ',
                ' <span class="caret"></span>', '', $auth_user->name));
            $user_menu = new Menu('ul', 'dropdown-menu', $match_url);
            if ($auth_user->hasRole('admin')) {
                $user_menu->addItem(new MenuItem(
                    adminHomeURL(),
                    trans('pages.page_admin'),
                    'li', '', '', '<i class="fa fa-dashboard"></i> '
                ));
            }
            if ($auth_user->hasRole('supporter')) {
                $user_menu->addItem(new MenuItem(
                    localizedURL('support-channel/{id?}', ['id' => null]),
                    trans('pages.support_channels'),
                    'li', '', '', '<i class="fa fa-table"></i> '
                ));
            }
            $is_teacher = $auth_user->hasRole('teacher');
            if ($is_teacher) {
                if ($auth_user->teacherProfile->status == Teacher::CREATED) {
                    $user_menu->addItem(new MenuItem(
                        localizedURL('teacher/becoming'),
                        trans('pages.teacher_becoming'),
                        'li', '', '', '<i class="fa fa-user"></i> '
                    ));
                } else {
                    $user_menu->addItem(new MenuItem(
                        localizedURL('teacher/{id?}', ['id' => null]),
                        trans('pages.teacher_profile'),
                        'li', '', '', '<i class="fa fa-user"></i> '
                    ));
                }
            } else {
                $user_menu->addItem(new MenuItem(
                    localizedURL('teacher/becoming'),
                    trans('pages.teacher_becoming'),
                    'li', '', '', '<i class="fa fa-user"></i> '
                ));
            }
            $is_student = $auth_user->hasRole('student');
            if ($is_student) {
                $user_menu->addItem(new MenuItem(
                    localizedURL('student/{id?}', ['id' => null]),
                    trans('pages.student_profile'),
                    'li', '', '', '<i class="fa fa-user"></i> '
                ));
            } else {
                $user_menu->addItem(new MenuItem(
                    localizedURL('student/becoming'),
                    trans('pages.student_becoming'),
                    'li', '', '', '<i class="fa fa-user"></i> '
                ));
            }
            if (!$is_teacher && !$is_student) {
                $user_menu->addItem(new MenuItem(
                    localizedURL('user/{id?}', ['id' => null]),
                    trans('pages.user_profile'),
                    'li', '', '', '<i class="fa fa-user"></i> '
                ));
            }
            $user_menu->addItem(new MenuItem(
                localizedURL('auth/logout'),
                trans('form.action_logout'),
                'li', '', '', '<i class="fa fa-sign-out"></i> '
            ));
            $main_menu_right->last()->enableDropDown()->setChildMenu($user_menu);

            // $main_menu_right->addItem(new MenuItem('#', '<i class="fa fa-globe"></i>',
            //     'li', 'notification', '', '', '<span id="notification-count" class="hidden">0</span>'));
            // $notification_menu = new Menu('ul', 'dropdown-menu');
            // $notification_menu->addItem(new MenuItem(null, ''));

            // $notification_list = new Menu('ul', '', '', 'notification-holder');
            // $notifications = $auth_user->notifications()->orderBy('created_at', 'desc')->take(10)->get();
            // foreach ($notifications as $notification) {
            //     $notification_list->addItem(new MenuItem(
            //         $notification->url,
            //         $notification->message,
            //         'li', $notification->read ? 'notification-item read' : 'notification-item unread', '', '<span>',
            //         '</span><br><small class="text-light text-sm"><span class="time-ago" title="' . $notification->timeTz . '">' . $notification->time . '</span></small>',
            //         'notification-' . $notification->id
            //     ));
            // }
            // $notification_menu->last()->setChildMenu($notification_list);
            // $notification_menu->addItem(new MenuItem(
            //     localizedURL('notification'),
            //     trans('form.action_view_all'),
            //     'li', 'text-center', 'view-all', '<small>', '</small>'
            // ));
            // $main_menu_right->last()->enableDropDown()->setChildMenu($notification_menu);
        }

        $view->with('main_menu', $main_menu->render())
            ->with('main_menu_right', $main_menu_right->render());
    }
}