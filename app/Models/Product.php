<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    protected $fillable = [
        'name', 'price', 'content', 'brand', 'origin', 'discount', 
        'image1','image2','image3','image4','view','status_show','status_type','category_id'
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}