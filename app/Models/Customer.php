<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customers';

    //列表展示有性能问题，暂时不加入，采用冗余字段
//    protected $appends = ['details'];
//
//    public function getDetailsAttribute()
//    {
//        return $this->attributes['details'] = $this->get_Details();
//    }
//    protected function get_Details()
//    {
//        return $this->hasMany('App\Models\CustomerDetail',"customer_uuid","uuid")->get()->toArray();
//    }
}
