<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/7/2015
 * Time: 3:40 PM
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\FeaturedReviews;

use Antoree\Models\Plugins\DefaultWidget\Widget as DefaultWidget;
use Antoree\Models\Review;
use Antoree\Models\Themes\LearningApp\Theme;


class Widget extends DefaultWidget
{
    const WIDGET_NAME = 'featured_reviews';
    const WIDGET_DISPLAY_NAME = 'Featured Reviews';
    const THEME_NAME = Theme::NAME;

    public function render()
    {
        $randomIndex = rand(1,4);
//        $randomIndex = 4;
        return $this->getTemplateRender([
            'name' => $this->name,
            'description' => $this->description,
            'review' => $this->review(),
            'randomIndex' => $randomIndex
        ]);
    }

    protected function __initAdminViewParams()
    {
        $all_reviews = Review::whereNotNull('user_id')->orderBy('created_at', 'desc')->get();
        $this->setViewParams([
            'all_reviews' => $all_reviews,
            'review_ids' => $this->review_ids()
        ]);
    }

    public function review()
    {
        $review_ids = $this->review_ids();

        $array_key = array_rand($review_ids,1);
        return Review::where('id',$review_ids[$array_key])->firstOrFail();
    }

    public function review_ids()
    {
//        echo "<pre>";
//        print_r($this->data['review_ids']);
//        exit;
        return !empty($this->data['review_ids']) ? $this->data['review_ids'] : [];
    }

    public function validationRules()
    {
        return array_merge(parent::validationRules(), [
            'review_ids' => 'required|array|exists:reviews,id',
        ]);
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            'review_ids'
        ]);
    }
}