<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class BlogCategory extends Model
{
    const BLOG = 0;
    const LINK = 1;
    const FAQ = 2;

    use Translatable;
    public $useTranslationFallback = true;

    protected $table = 'blog_categories';
    protected $fillable = ['parent_id', 'name', 'slug', 'order', 'type'];

    protected $translationForeignKey = 'cat_id';
    public $translatedAttributes = ['name', 'slug'];

    public function articles()
    {
        return $this->belongsToMany(BlogArticle::class, 'blog_categories_articles', 'cat_id', 'art_id');
    }

    public function parent()
    {
        return $this->hasOne(BlogCategory::class, 'id', 'parent_id');
    }

    public function scopeOfBlog($query)
    {
        return $query->where('type', $this::BLOG);
    }

    public function scopeOfLink($query)
    {
        return $query->where('type', $this::LINK);
    }

    public function scopeOfFaq($query)
    {
        return $query->where('type', $this::FAQ);
    }

    public function items()
    {
        return $this->belongsToMany(LinkItem::class, 'link_categories_items', 'cat_id', 'itm_id');
    }
}

class BlogCategoryTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'blog_category_translations';
    protected $fillable = ['name', 'slug', 'description'];
}
