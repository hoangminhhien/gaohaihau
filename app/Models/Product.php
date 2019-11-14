<?php

namespace App\Models;
use BaseModel;

class Product extends BaseModel
{
    protected $fillable = [
        'name',
        'made_from',
        'unit',
        'capacity',
        'price',
        'image_url',
        'short_desc',
        'desc',
        'quantity',
        'is_public',
        'gift_code',
    ];
}
