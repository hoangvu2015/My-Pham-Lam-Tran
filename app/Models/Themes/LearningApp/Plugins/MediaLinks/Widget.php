<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-10-30
 * Time: 10:36
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\MediaLinks;

use Antoree\Models\Themes\LearningApp\Theme;
use Antoree\Models\Plugins\BaseLinks\Widget as BaseLinks;

class Widget extends BaseLinks
{
    const WIDGET_NAME = 'media_links';
    const WIDGET_DISPLAY_NAME = 'Media Links';
    const THEME_NAME = Theme::NAME;

    public function render()
    {
        return $this->getTemplateRender([
            'name' => $this->name,
            'description' => $this->description,
            'items' => $this->link_items()
        ]);
    }
}