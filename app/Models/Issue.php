<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use BaseModel;
class Issue extends Model
{
    protected $fillable = [
        'customer_id',
        'type',
        'status',
        'due_date',
        'order_id',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }
}
