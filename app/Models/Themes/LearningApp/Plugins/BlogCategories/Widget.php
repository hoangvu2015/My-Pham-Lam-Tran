<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-06
 * Time: 15:37
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\BlogCategories;

use Antoree\Models\BlogCategory;
use Antoree\Models\Themes\LearningApp\Theme;
use Antoree\Models\Plugins\DefaultWidget\Widget as DefaultWidget;

class Widget extends DefaultWidget
{
    const WIDGET_NAME = 'blog_categories';
    const WIDGET_DISPLAY_NAME = 'Blog Categories';
    const THEME_NAME = Theme::NAME;

    public function render()
    {
        return $this->getTemplateRender([
            'name' => $this->name,
            'categories' => BlogCategory::where('type', BlogCategory::BLOG)->get(),
        ]);
    }
}