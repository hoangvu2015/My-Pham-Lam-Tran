<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/7/2015
 * Time: 3:40 PM
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\FeaturedArticles;

use Antoree\Models\BlogArticle;
use Antoree\Models\BlogCategory;
use Antoree\Models\Helpers\AppHelper;
use Antoree\Models\Plugins\DefaultWidget\Widget as DefaultWidget;
use Antoree\Models\Themes\LearningApp\Theme;


class Widget extends DefaultWidget
{
    const WIDGET_NAME = 'featured_articles';
    const WIDGET_DISPLAY_NAME = 'Featured Articles';
    const THEME_NAME = Theme::NAME;

    public function render()
    {
        return $this->getTemplateRender([
            'name' => $this->name,
            'description' => $this->description,
            'articles' => $this->articles(),
            'shorten_length' => AppHelper::BLOG_ARTICLE_SHORTEN_LENGTH,
            'international_locale' => AppHelper::INTERNATIONAL_LOCALE_CODE,
        ]);
    }

    protected function __initAdminViewParams()
    {
        $all_articles = BlogArticle::whereHas('categories', function ($query) {
            $query->where('type', BlogCategory::BLOG);
        })->orderBy('created_at', 'desc')->get();

        $this->setViewParams([
            'all_articles' => $all_articles,
            'article_ids' => $this->article_ids()
        ]);
    }

    public function articles()
    {
        return BlogArticle::whereIn('id', $this->article_ids())->get();
    }

    public function article_ids()
    {
        return !empty($this->data['article_ids']) ? $this->data['article_ids'] : [];
    }

    public function validationRules()
    {
        return array_merge(parent::validationRules(), [
            'article_ids' => 'required|array|exists:blog_articles,id',
        ]);
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            'article_ids'
        ]);
    }
}