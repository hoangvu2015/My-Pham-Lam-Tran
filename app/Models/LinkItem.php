<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class LinkItem extends Model
{
    use Translatable;

    public $useTranslationFallback = true;

    protected $table = 'link_items';
    protected $fillable = ['link', 'image', 'name', 'description, itm_id, cat_id, order'];

    protected $translationForeignKey = 'itm_id';
    public $translatedAttributes = ['link', 'name', 'description'];

    public function link_categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'link_categories_items','itm_id','cat_id');
    }
}


class LinkItemTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'link_items_translations';
    protected $fillable = ['link', 'name', 'description'];
}