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

class TaskPanel extends Model{


    protected $task_panel = 'task_panel';

    public function get()
    {
        $array = array('name'=>'Shenjl','age'=>18);
        return $array;
    }

    public function get_personal_info($id)
    {
        $userid = "4";

        $strSql = <<<EOT
        SELECT * FROM tasks a
        LEFT JOIN task_details b ON a . task_no = b . task_id
        LEFT JOIN users c ON b . user_id = c . id
        WHERE b . user_id = '4' and a . `status` = 1
EOT;


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

    public function getTaskDetail($id)
    {
        $task=DB::select('select * from tasks where task_no='.$id);
        return json_encode($task, JSON_UNESCAPED_UNICODE);
    }
}