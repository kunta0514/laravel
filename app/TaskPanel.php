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


    protected $task_panel = 'task_panel';

    public function get()
    {
        $array = array('name'=>'Shenjl','age'=>18);
        return $array;
    }

    public function get_detail($id)
    {
        //$task_detail = DB::select('SELECT a.*,CASE b.`type` when 0 then b.`name` end as dev,CASE b.`type` when 1 then b.`name` end as test from tasks a left JOIN tasks_workload b on a.id=b.task_id where a.id=:id GROUP BY a.id desc ',[$id]);

        //$task_detail=Task::where('id','=',$id)->get();

        $task_detail=Task::find($id);
        return json_encode($task_detail,JSON_UNESCAPED_UNICODE);
    }

    public function get_task_all()
    {
        $tasks=Task::where('status','<','3')->get();
        return $tasks;
    }

    public function get_dev_all()
    {
        return User::where('role',0)->get();
    }

    public function get_test_all()
    {
        return User::where('role',1)->get();
    }



    public function get_task_done()
    {
        $tasks=Task::where('status','=','3')->orderBy('actual_finish_date','desc')->take(5)->get();
        return $tasks;
    }

    public function get_task_todo()
    {
        $tasks=Task::where('status','=','0')->get();
        return $tasks;
    }

    public function get_task_doing()
    {
        $tasks=Task::where('status','=','1')->get();
        return $tasks;
    }

    public function get_task_verify()
    {
        $tasks=Task::where('status','=','2')->get();
        return $tasks;
    }

    public function get_personal_info($id)
    {

    }

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

}