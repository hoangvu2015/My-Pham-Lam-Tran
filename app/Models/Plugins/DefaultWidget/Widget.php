<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-11-06
 * Time: 15:31
 */

namespace Antoree\Models\Plugins\DefaultWidget;

use Antoree\Models\Themes\Widget as BaseWidget;

class Widget extends BaseWidget
{
    const WIDGET_NAME = 'default';
    const WIDGET_DISPLAY_NAME = 'Default';
    const WIDGET_TRANSLATABLE = true;

    public $name = '';
    public $description = '';

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    protected function __init()
    {
        parent::__init();

        if (!empty($this->localizedData)) {
            $this->name = empty($this->localizedData['name']) ? '' : $this->localizedData['name'];
            $this->description = empty($this->localizedData['description']) ? '' : $this->localizedData['description'];
        }
    }

    public function render()
    {
        return '';
    }

    public function localizedFields()
    {
        return ['name', 'description'];
    }
}