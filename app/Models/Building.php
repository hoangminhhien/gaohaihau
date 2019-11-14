<?php

namespace App\Models;
use BaseModel;

class Building extends BaseModel
{
    use \Awobaz\Compoships\Compoships;
    protected $fillable = [
       'name',
       'project_code',
       'building_code'
    ];

    public function rooms()
    {
        return $this->hasMany('App\Models\Room' , ['project_code', 'building_code'], ['project_code', 'building_code']);
    }
}
