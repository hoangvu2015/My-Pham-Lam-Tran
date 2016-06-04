<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-10-30
 * Time: 10:36
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\SocialLinks;

use Antoree\Models\Themes\LearningApp\Theme;
use Antoree\Models\Plugins\BaseLinks\Widget as BaseLinks;
use Illuminate\Support\Str;

class Widget extends BaseLinks
{
    const WIDGET_NAME = 'social_links';
    const WIDGET_DISPLAY_NAME = 'Social Links';
    const THEME_NAME = Theme::NAME;

    public function render()
    {
        return $this->getTemplateRender([
            'name' => $this->name,
            'items' => $this->link_items(),
            'color_func' => function ($name) {
                if (Str::contains($name, ['facebook', 'Facebook'])) {
                    return 'indigo';
                }
                if (Str::contains($name, ['twitter', 'Twitter'])) {
                    return 'blue';
                }
                if (Str::contains($name, ['google', 'Google'])) {
                    return 'red';
                }
                if (Str::contains($name, ['skype', 'Skype'])) {
                    return 'light-blue';
                }
                return 'grey';
            },
        ]);
    }
}