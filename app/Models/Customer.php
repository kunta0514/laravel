<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customers';

    protected $appends = ['Details'];

    public function getDetailsAttribute()
    {
        return $this->attributes['Details'] = $this->get_Details();
    }
    protected function get_Details()
    {
        return $this->hasMany('App\Models\CustomerDetail',"customer_uuid","uuid")->get()->toArray();
    }
}
