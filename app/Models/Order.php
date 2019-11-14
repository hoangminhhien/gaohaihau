<?php

namespace App\Models;
use BaseModel;

class Order extends BaseModel
{
    protected $fillable = [
        'customer_id',
        'delivery_time_expect_from',
        'delivery_time_expect_to',
        'status',
        'delivered_time',
        'canceled_note',
        'shipper_id',
        'delivery_image_url',
        'gift_code', 
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function orderProduct(){
        return $this->hasMany('App\Models\OrderProduct' , 'order_id', 'id');
    }

    public function shipper(){
        return $this->hasOne('App\User', 'id', 'shipper_id');
    }

}
