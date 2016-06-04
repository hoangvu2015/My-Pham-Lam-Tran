<?php
namespace Antoree\Models\Themes\LearningApp\Plugins\LearningSteps;

use Antoree\Models\Themes\LearningApp\Theme;

use Antoree\Models\Plugins\BaseLinks\Widget as BaseLinks;

class Widget extends BaseLinks
{
    const WIDGET_NAME = 'learning_steps';
    const WIDGET_DISPLAY_NAME = 'Learning Steps';
    const THEME_NAME = Theme::NAME;

    public function render()
    {
        return $this->getTemplateRender([
            'name' => $this->name,
            'description' => $this->description,
            'items' => $this->link_items(),
        ]);
    }
}
