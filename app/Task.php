<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $table = 'tasks';


    /**
     * 获取任务的开发
     *
     * @return String
     */
    public function getDevAttribute()
    {
        return $this->attributes['dev'] =join(',',$this->get_Dev()->toArray());
    }

    /**
     * 获取任务的测试
     *
     * @return String
     */
    public function getTestAttribute()
    {
        return $this->attributes['test'] =join(',',$this->get_Test()->toArray());
    }


    /**
     * 追加到模型数组表单的访问属性
     *
     * @var array
     */
    protected $appends = ['dev','test'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_workloads()
    {
        return $this->hasMany('App\TaskDetail');
    }

    protected function get_Dev()
    {
        return $this->hasMany('App\TaskDetail')->where('work_type','=',0)->lists('user_name');
    }

    protected function get_Test()
    {
        return $this->hasMany('App\TaskDetail')->where('work_type','=',1)->lists('user_name');
    }


}
