<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-18
 * Time: 22:38
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\RegisterTrialClass;

use Antoree\Models\Plugins\DefaultWidget\Widget as DefaultWidget;
use Antoree\Models\Themes\LearningApp\Theme;

class Widget extends DefaultWidget
{
    const WIDGET_NAME = 'register_trial_class';
    const WIDGET_DISPLAY_NAME = 'Register Trial Class Form';
    const THEME_NAME = Theme::NAME;

    public function render()
    {
        return $this->getTemplateRender([
            'name' => $this->name,
            'description' => $this->description,
        ]);
    }
}