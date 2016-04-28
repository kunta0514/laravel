<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $table = 'tasks';
//    protected $appends = ['developer_name','tester_name'];

//    public function setDeveloperNameAttribute($value)
//    {
//        $this->attributes['developer_name'] = '';
//    }
//    public function setTesterNameAttribute($value)
//    {
//        $this->attributes['tester_name'] = '';
//    }

//    public function dev()
//    {
//        return $this->hasOne('App\Models\Taskworkload','task_id','id')->where('type',0);
//    }
//
//    public function test()
//    {
//        return $this->hasOne('App\Models\Taskworkload','task_id','id')->where('type',1);
//    }
}
