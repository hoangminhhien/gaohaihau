<?php

namespace App\Models;
use BaseModel;

class Room extends BaseModel
{
    use \Awobaz\Compoships\Compoships;
    protected $fillable = [
        'project_code',
        'building_code',
        'room_no',
    ];

    public function project(){
        return $this->belongsTo('App\Models\Project', 'project_code', 'project_code');
    }

    public function building()
    {
        return $this->belongsTo('App\Models\Building', ['project_code', 'building_code'], ['project_code', 'building_code']);
    }

    public function customers()
    {
        return $this->hasMany('App\Models\Customer',['project_code','building_code','room_no'],['project_code','building_code','room_no']);
    }
}
