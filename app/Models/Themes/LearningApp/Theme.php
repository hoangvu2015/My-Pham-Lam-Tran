<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-10-28
 * Time: 02:54
 */

namespace Antoree\Models\Themes\LearningApp;

use Antoree\Models\Plugins\OwnerInformation\OwnerInfo;
use Antoree\Models\Themes\LmsTheme;
use Antoree\Models\Themes\LearningApp\Plugins\BlogCategories\Widget as BlogCategoriesWidget;
use Antoree\Models\Themes\LearningApp\Plugins\LearningSteps\Widget as LearningStepsWidget;
use Antoree\Models\Themes\LearningApp\Plugins\MediaLinks\Widget as MediaLinksWidget;
use Antoree\Models\Themes\LearningApp\Plugins\SocialLinks\Widget as SocialLinksWidget;
use Antoree\Models\Themes\LearningApp\Plugins\FeaturedArticles\Widget as FeaturedArticlesWidget;
use Antoree\Models\Themes\LearningApp\Plugins\ClientLinks\Widget as ClientLinksWidget;
use Antoree\Models\Themes\LearningApp\Plugins\PartnerLinks\Widget as PartnerLinksWidget;
use Antoree\Models\Themes\LearningApp\Plugins\SocialSharing\Widget as SocialSharingWidget;
use Antoree\Models\Themes\LearningApp\Plugins\FeaturedTeachers\Widget as FeaturedTeachersWidget;
use Antoree\Models\Themes\LearningApp\Plugins\RegisterTrialClass\Widget as RegisterTrialClass;
use Antoree\Models\Themes\LearningApp\Plugins\FeaturedReviews\Widget as FeaturedReviewsWidget;
use Antoree\Models\Themes\LearningApp\Plugins\IntroVideoLinks\Widget  as IntroVideoLinksWidget;


class Theme extends LmsTheme
{
    const NAME = 'LearningApp';
    const VIEW = 'learning_app';

    public function __construct()
    {
        parent::__construct();
    }

    public function register($is_auth = false)
    {
        parent::register($is_auth);
    }

    protected function registerComposers($is_auth = false)
    {
        view()->composer(
            $this->masterPath('layout_header'), Composers\MainMenuComposer::class
        );
        view()->composer(
            $this->masterPath('layout_footer'), Composers\FooterMenuComposer::class
        );
        if ($is_auth) {
            view()->composer(
                $this->masterPath('student_board'), Composers\StudentMenuComposer::class
            );
            view()->composer(
                $this->masterPath('teacher_board'), Composers\TeacherMenuComposer::class
            );
            view()->composer(
                $this->masterPath('user_board'), Composers\UserMenuComposer::class
            );
        }
    }

    public function extensions()
    {
        return [
            // define extension here
        ];
    }

    public function placeholders()
    {
        return [
            'left_footer' => 'Footer - On the Left',
            'right_footer' => 'Footer - On the Right',
            'middle_footer' => 'Footer - On the Middle',
            'bottom_footer' => 'Footer - On the Bottom',
            'bottom_homepage' => 'Homepage - Extra Content',
            'blog_widgets' => 'Blog - Right Sidebar',
            'blog_article_widgets' => 'Blog Article - Below Content',
            'single_course_widgets' => 'Singe Course - Right Sidebar',
        ];
    }

    public function widgets()
    {
        return [
            SocialLinksWidget::WIDGET_NAME => SocialLinksWidget::class,
            MediaLinksWidget::WIDGET_NAME => MediaLinksWidget::class,
            LearningStepsWidget::WIDGET_NAME => LearningStepsWidget::class,
            ClientLinksWidget::WIDGET_NAME => ClientLinksWidget::class,
            BlogCategoriesWidget::WIDGET_NAME => BlogCategoriesWidget::class,
            SocialSharingWidget::WIDGET_NAME => SocialSharingWidget::class,
            FeaturedTeachersWidget::WIDGET_NAME => FeaturedTeachersWidget::class,
            FeaturedArticlesWidget::WIDGET_NAME => FeaturedArticlesWidget::class,
            PartnerLinksWidget::WIDGET_NAME => PartnerLinksWidget::class,
            RegisterTrialClass::WIDGET_NAME => RegisterTrialClass::class,
            FeaturedReviewsWidget::WIDGET_NAME => FeaturedReviewsWidget::class,
            IntroVideoLinksWidget::WIDGET_NAME => IntroVideoLinksWidget::class
        ];
    }
}