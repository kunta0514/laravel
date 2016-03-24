<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/16
 * Time: 15:47
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use App\Task;
use App\User;

class TaskPanel extends Model{


    //指定自定义表名
    protected $table = "tasks";

    /**
     * 追加到模型数组表单的访问属性
     *
     * @var array
     */
    protected $appends = ['dev','test','deadline'];


    /** 获取任务详情 DB
     * @param $id
     */
    public function get_detail($id)
    {
        //$task_detail = DB::select('SELECT a.*,CASE b.`type` when 0 then b.`name` end as dev,CASE b.`type` when 1 then b.`name` end as test from tasks a left JOIN tasks_workload b on a.id=b.task_id where a.id=:id GROUP BY a.id desc ',[$id]);
    }

    /**获取所有任务 DB
     * @param $page 页
     * @param $pagesize 页大小
     * @return string
*/
    public function get_all_info($page,$pagesize)
    {
        //Todo:分页取数
//        // 获取分页参数
//        $page = 0 ;
//        $pageSize = 3;
//
//        if(!is_null($_GET["page"])) {
//            $page = $_GET["page"];
//        }
//
//        if(!is_null($_GET["pageSize"])) {
//            $pageSize = $_GET["pageSize"];
//        }

        $sql=<<<EOT
            select t.id,t.task_title,ifnull(td.user_id,'0'),ifnull(td.user_name,'未分配'),t.status
            from tasks t
            left join task_details td on t.task_no = td.task_id
            left join users u on td.user_id = u.id
            limit 0,10
EOT;
        $tasks=DB::select($sql);
        //var_dump($tasks);
        return json_encode($tasks);

//DB:select
//        $tasks = DB::select('select * from tasks limit 2,10');
//        return json_encode($tasks);

//原生的查询
//        $link=mysqli_connect("localhost","root","","taskmanager");
//        $result = mysqli_query($link,'select * from tasks');
//
//        //var_dump($result);
//        $results = array();
//        while ($row = mysqli_fetch_assoc($result)) {
//            $results[] = $row;
//        }
//
//        mysqli_free_result($result);
//        mysqli_close($link);
//
//        return json_encode($results);

    }

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

//    /**
//     * 获取任务的开发头像
//     *
//     * @return String
//     */
//    public function getDevPicAttribute()
//    {
//        return $this->attributes['dev_pic'] =join(',',$this->get_Dev_Pic()->toArray());
//    }
//
//    /**
//     * 获取任务的测试头像
//     *
//     * @return String
//     */
//    public function getTestPicAttribute()
//    {
//        return $this->attributes['test_pic'] =join(',',$this->get_Test_Pic()->toArray());
//    }

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

//    protected function get_Dev_Pic()
//    {
//        return $this->hasMany('App\TaskWorkload','task_id','id')->where('type','=',0)->lists('user_pic');
//    }
//
//    protected function get_Test_Pic()
//    {
//        return $this->hasMany('App\TaskWorkload','task_id','id')->where('type','=',1)->lists('user_pic');
//    }

    protected function get_DeadLine()
    {
        if(date_default_timezone_get() != "1Asia/Shanghai") date_default_timezone_set("Asia/Shanghai");
        $task_expect=$this->actual_finish_date;
        $hour=floor((strtotime($task_expect) - strtotime(date("y-m-d h:i:s")))%86400/3600);
        return strtotime(date("y-m-d h:i:s"));
    }


}