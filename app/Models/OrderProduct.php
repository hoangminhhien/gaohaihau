<?php

namespace App\Models;
use BaseModel;

class OrderProduct extends BaseModel
{
    protected $table = 'order_products';
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function product(){
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
