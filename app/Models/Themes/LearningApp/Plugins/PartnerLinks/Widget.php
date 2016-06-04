<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/10/2015
 * Time: 4:32 PM
 */
namespace Antoree\Models\Themes\LearningApp\Plugins\PartnerLinks;

use Antoree\Models\Themes\LearningApp\Theme;
use Antoree\Models\Plugins\BaseLinks\Widget as BaseLinks;

class Widget extends BaseLinks
{
    const WIDGET_NAME = 'partner_links';
    const WIDGET_DISPLAY_NAME = 'Partner Links';
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