<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-10-30
 * Time: 16:16
 */

namespace Antoree\Models\Plugins\BaseLinks;

use Antoree\Models\BlogCategory;;
use Antoree\Models\Plugins\DefaultWidget\Widget as DefaultWidget;

class Widget extends DefaultWidget
{
    const WIDGET_NAME = 'base_links';
    const WIDGET_DISPLAY_NAME = 'Base Links';

    protected $link_category_id = '';

    protected function __init()
    {
        parent::__init();

        $this->link_category_id = empty($this->data['link_category_id']) ? '' : $this->data['link_category_id'];
    }

    public function link_category_id()
    {
        return $this->link_category_id;
    }

    public function link_categories()
    {
        $categories = BlogCategory::where('type', BlogCategory::LINK)->get();
        $link_categories = [];
        foreach ($categories as $category) {
            $link_categories[$category->id] = $category->name;
        }
        return $link_categories;
    }

    public function link_items()
    {
        $linkCategory = BlogCategory::where('id', $this->link_category_id)->where('type', BlogCategory::LINK)->first();
        if (empty($linkCategory)) return collect([]);
        return $linkCategory->items()->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
    }

    public function render()
    {
        return $this->getTemplateRender([
            'name' => $this->name,
            'items' => $this->link_items(),
        ]);
    }

    public function validationRules()
    {
        return [
            'link_category_id' => 'required|not_in:0',
        ];
    }

    public function fields()
    {
        return ['link_category_id'];
    }
}