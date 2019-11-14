<?php

namespace App\Models;
use BaseModel;

class Category extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'sequence',
        'is_public',
    ];
    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }   

    public function products()
    {
        return $this->hasMany('App\Models\Product' , 'category_id', 'id');
    }
}