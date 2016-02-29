<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $table = 'tasks';


    /**
     * 获取任务的开发�??
     *
     * @return String
     */
    public function getDevorsAttribute()
    {
        return $this->attributes['Devors'] =join(',',$this->get_Devors()->toArray());
    }

    /**
     * 获取任务的测�?
     *
     * @return String
     */
    public function getTestorsAttribute()
    {
        return $this->attributes['Testors'] =join(',',$this->get_Testors()->toArray());
    }


    /**
     * 追加到模型数组表单的访问�?
     *
     * @var array
     */
    protected $appends = ['Devors','Testors'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_workloads()
    {
        return $this->hasMany('App\Taskload');
    }

    protected function get_Devors()
    {
        return $this->hasMany('App\Taskload')->where('work_type','=','����')->lists('user_name');
    }

    protected function get_Testors()
    {
        return $this->hasMany('App\Taskload')->where('work_type','=','����')->lists('user_name');
    }


}
