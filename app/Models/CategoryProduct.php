<?php

namespace Antoree\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{

    protected $table = 'category_product';
    protected $fillable = [
        'name', 'code', 'parent_id', 'des'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}