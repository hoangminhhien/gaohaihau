<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportHistory extends BaseModel
{
    protected $table = 'import_histories';
    protected $fillable = [
        'product_id',
        'quantity',
        'price'
    ];

    public function product(){
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
