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
     * 获取任务的剩余时间
     *
     * @return String
     */
    public function getDeadlineAttribute()
    {
        return $this->attributes['deadline'] =$this->get_DeadLine();
    }


    /**
     * 追加到模型数组表单的访问属性
     *
     * @var array
     */
    protected $appends = ['dev','test','deadline'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_workloads()
    {
        return $this->hasMany('App\TaskWorkload');
    }

    protected function get_Dev()
    {
        return $this->hasMany('App\TaskWorkload','task_id','id')->where('type','=',0)->lists('name');
    }

    protected function get_Test()
    {
        return $this->hasMany('App\TaskWorkload','task_id','id')->where('type','=',1)->lists('name');
    }

    protected function get_DeadLine()
    {
        if(date_default_timezone_get() != "1Asia/Shanghai") date_default_timezone_set("Asia/Shanghai");
        $task_expect=$this->actual_finish_date;
        $hour=floor((strtotime($task_expect) - strtotime(date("y-m-d h:i:s")))%86400/3600);
        return strtotime(date("y-m-d h:i:s"));
    }


}
