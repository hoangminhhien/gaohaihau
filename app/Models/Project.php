<?php

namespace App\Models;
use BaseModel;

class Project extends BaseModel
{
    protected $fillable = [
        'name',
        'project_code',
        'address',
        'latitude',
        'longitude',
    ];
    public function buildings()
    {
        return $this->hasMany('App\Models\Building' , 'project_code', 'project_code');
    }
    public function rooms()
    {
        return $this->hasMany('App\Models\Room' , 'project_code', 'project_code');
    }
}
