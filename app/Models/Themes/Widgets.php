<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-10-30
 * Time: 09:32
 */

namespace Antoree\Models\Themes;


use Antoree\Models\Plugins\BaseLinks\Widget as BaseLinks;
use Antoree\Models\Plugins\ExtraHtml\Widget as ExtraHtml;

class Widgets
{
    private $widgets;

    public function display($placeholder, $before = '', $after = '')
    {
        $widgets = $this->widgets->where('placeholder', $placeholder);
        $count_widgets = $widgets->count();
        $output = $count_widgets > 0 ? $before : '';
        foreach ($widgets as $widget) {
            $output .= $widget->render();
        }
        return $count_widgets > 0 ? $output . $after : $output;
    }

    public function register()
    {
        if (empty($this->widgets)) {
            $this->widgets = ThemeWidget::forDisplay()->get();
        }
        foreach ($this->widgets as $widget) {
            $widget->register();
        }
    }

    public function all()
    {
        return array_merge([
            BaseLinks::WIDGET_NAME => BaseLinks::class,
            ExtraHtml::WIDGET_NAME => ExtraHtml::class
        ], LmsThemeFacade::widgets());
    }

    public function widgetClass($name)
    {
        static $widgets;
        if (empty($widgets)) {
            $widgets = $this->all();
        }
        return empty($widgets[$name]) ? null : $widgets[$name];
    }
}