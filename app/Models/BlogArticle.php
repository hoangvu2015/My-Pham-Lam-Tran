<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class BlogArticle extends Model
{
    const TYPE_PAGE = 0;
    const TYPE_POST = 2; // type should be 2^x
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_REQUESTED = 2;
    const STATUS_REJECTED = 3;

    use Translatable;
    public $useTranslationFallback = true;

    protected $table = 'blog_articles';
    protected $fillable = [
        'auth_id', 'title', 'content', 'slug','meta_description',
        'order', 'type', 'status', 'comment_allowed',
        'featured_image', 'multilingual_displayable', 'edit_by_displayable', 'edit_by_overwrite', 'views',
    ];

    protected $translationForeignKey = 'art_id';
    public $translatedAttributes = ['title', 'content', 'slug'];


    public function author()
    {
        return $this->belongsTo(User::class, 'auth_id', 'id');
    }

    public function art_trans()
    {
        return $this->belongsTo(BlogArticle::class, 'blog_article_translations', 'id', 'art_id');
    }

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_categories_articles', 'art_id', 'cat_id');
    }

    public function reviews()
    {
        return $this->belongsToMany(Review::class, 'article_reviews', 'article_id', 'review_id');
    }

    public function getPointedAverageRateAttribute()
    {
        return round($this->reviews()->approved()->avg('rate'), 2);
    }

    public function getAverageRateAttribute()
    {
        return (int)round($this->reviews()->approved()->avg('rate'));
    }

    public function scopeOfBlog($query)
    {
        return $query->whereHas('categories', function ($query) {
            $query->where('type', BlogCategory::BLOG);
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', $this::STATUS_PUBLISHED);
    }

    public function scopeListForUser($query, User $user)
    {
        if ($user->hasRole('blog-editor')) {
            return $query->where(function ($query) use ($user) {
                $query->where('status', $this::STATUS_PUBLISHED)
                    ->orWhere('status', $this::STATUS_REQUESTED)
                    ->orWhere('auth_id', $user->id);
            });
        }
        return $query->where(function ($query) use ($user) {
            $query->where('status', $this::STATUS_PUBLISHED)
                ->orWhere('auth_id', $user->id);
        });
    }

    public function scopeFilter($query, $status = null, array $author_ids = [])
    {
        if (!empty($status) || (string)$status == (string)$this::STATUS_DRAFT) {
            $query->where('status', $status);
        }
        if (!empty($author_ids)) {
            $query->whereIn('auth_id', $author_ids);
        }
        return $query;
    }
}

class BlogArticleTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'blog_article_translations';
    protected $fillable = ['title', 'content', 'slug'];
}
