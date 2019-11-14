<?php

namespace App\Models;
use BaseModel;

class Customer extends BaseModel
{
    // use \Awobaz\Compoships\Compoships;
    protected $fillable = [
        'name',
        'project_code',
        'building_code',
        'room_no',
        'phone',
        'family_number_of_adults',
        'family_number_of_children',
        'gift_status',
        'address',
        'remaining_rice',
    ];

    public function project()
    {
    	return $this->belongsTo('App\Models\Project','project_code','project_code');
    }

    public function building()
    {
    	return $this->belongsTo('App\Models\Building','building_code','building_code');
    }

    public function room()
    {
    	return $this->belongsTo('App\Models\Room',['project_code','building_code','room_no'],['project_code','building_code','room_no']);
    }
    public function order()
    {
        return $this->hasMany('App\Models\Order' , 'customer_id', 'id');
    }

    public function customer_issue()
    {
        return $this->hasOne('App\Models\Issue' , 'customer_id', 'id');
    }
}
