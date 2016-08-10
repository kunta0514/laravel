<?php

namespace App\Http\Controllers\Report;

use App\Models\Task;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type='top10')
    {
        switch($type) {
            case 'top10':
             $task_data = DB::select('select customer_name cname,count(1) ttotal,SUM(isabubug) abubug,SUM(isselfbug) selfbug,SUM(isdemand) demand from (
                     select task_no,customer_name,case task_type when \'项目BUG\' then 1 else 0 end as isabubug,case task_type when \'产品BUG\' then 1 else 0 end as isselfbug, case task_type when \'需求\' then 1 else 0 end as isdemand
                    from tasks ) a WHERE task_no like \'2016%\' GROUP BY customer_name ORDER BY COUNT(1) desc LIMIT 0,10');
               break;
        }
        $page_data = array('data' =>
            (!isset($task_data))?null:$task_data,
        );
        return view('report.top10',['theme' => 'default','page_data'=>json_encode($page_data)]);
    }

    public function task_report($type)
    {
//        $type = 'week';
        $query_begin = null;
        $query_end = null;
        switch($type){
                case 'month':
                        $query_begin = date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y")));
                        $query_end = date("Y-m-d ",mktime(0,0,0,date("m")+1,1,date("Y")));
                        break;
                case 'week':
                        $query_begin = date("Y-m-d",strtotime("-1 week Monday"));
                        $query_end = date("Y-m-d",strtotime("+0 week Monday"));
                        break;
                default:
                    $query_begin = date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y")));
                    $query_end = date("Y-m-d ",mktime(0,0,0,date("m")+1,1,date("Y")));
                    break;
        }
        $tasks_sum = DB::table('tasks')->select(DB::raw('ifnull(sum(case when status = 0 then 1 ELSE 0 end),0) as todo'),DB::raw('ifnull(sum(case when status = 1 then 1 ELSE 0 end),0) as deving'),DB::raw('ifnull(sum(case when status = 2 then 1 ELSE 0 end),0) as testing'),DB::raw('ifnull(sum(case when status > 2 then 1 ELSE 0 end),0) as over'))
            ->where('ekp_create_date','>',$query_begin)->first();

        //TODO:这里的条件，在团队数据和个人数据中是不一样的，团队的用actual_finish_date，个人的用dev、test_end_date
        $tasks_workload_sum =  DB::table('tasks')->select(DB::raw('sum(developer_workload) as developer_workload_all'),DB::raw('sum(tester_workload) as tester_workload_all'))
            ->where('actual_finish_date','>',$query_begin)->where('actual_finish_date','<',$query_end)
            ->first();
        $task_details = Task::where('actual_finish_date','>',$query_begin)
            ->where('actual_finish_date','<',$query_end)
            ->get();
        $query_str="SELECT b.name,sum(CASE `status` WHEN 0 THEN 1 ELSE 0 END ) AS todo,sum( CASE `status` WHEN 1 THEN 1 ELSE 0 END ) AS doing,sum( CASE `status` WHEN 2 THEN 1 ELSE 0 END ) AS testing,
                sum(CASE `status` WHEN 3 THEN 1 ELSE 0 END ) AS dong,COUNT(1) AS totle FROM tasks a LEFT JOIN users b ON a.developer = b. CODE WHERE developer_start > :begin_time AND developer_start < :end_time  AND developer <> '' AND `status` IN (0, 1, 2, 3)
                GROUP BY b. NAME UNION SELECT b. NAME,sum( CASE `status` WHEN 0 THEN 1 when 1 then 1 ELSE 0 END ) AS todo,0 doing, sum( CASE `status` WHEN 2 THEN 1 ELSE 0 END )
                AS testing,sum( CASE `status` WHEN 3 THEN 1 ELSE 0 END ) AS dong,COUNT(1) AS totle FROM tasks a LEFT JOIN users b ON a.tester = b.CODE WHERE tester_start > :begin_time1
                AND tester_start < :end_time1 AND tester <> '' AND tester <> 'xmabu' AND tester <> 'yd' AND `status` IN (0, 1, 2, 3) GROUP BY b. NAME";
//        print_r($query_begin);
//        print_r($query_end);
////        print_r(date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))));
//       dd($query_str);die;
        $query_params=array(
            'begin_time'=>$query_begin,
            'end_time'=>$query_end,
            'begin_time1'=>$query_begin,
            'end_time1'=>$query_end
        );
        $person_workload_totle=DB::select($query_str, $query_params);

        $query_str="select NAME,sum(todo_workload) todo_workload,sum(deving_workload) deving_workload,sum(testing_workload) testing_workload,sum(dong_workload) dong_workload,role,sum(sum_workload) sum_workload from
             (SELECT b. NAME,IFNULL(case `status`  when 0 then sum(developer_workload) END,0) todo_workload,IFNULL(case `status`  when 1 then sum(developer_workload) END,0) deving_workload,IFNULL(CASE `status` WHEN 2 THEN sum(developer_workload)END,0) as testing_workload,
             IFNULL(case `status`  when 3 then sum(developer_workload) END,0) dong_workload,IFNULL(SUM(developer_workload),0) sum_workload, b.role FROM tasks a LEFT JOIN users b ON a.developer = b. CODE
             WHERE developer_start > :begin_time AND developer_start < :end_time  AND developer <> '' AND `status` IN (0, 1, 2, 3) GROUP BY b. NAME,
                `status` UNION SELECT b. NAME,IFNULL(case when `status` in (0,1) then sum(tester_workload) end,0) as todo_workload,0 as deving_workload,IFNULL(case when `status`=2 then sum(tester_workload) end,0) as testing_workload,
                IFNULL(case when `status`=3 then sum(tester_workload) end,0) as done_workload,IFNULL(SUM(tester_workload),0) sum_workload,b.role FROM tasks a LEFT JOIN users b ON a.tester = b. CODE WHERE tester_start > :begin_time1
                AND tester_start < :end_time1 AND tester <> '' AND tester <> 'xmabu' AND tester <> 'yd' AND `status` IN (0, 1, 2, 3) GROUP BY b. NAME,
                `status` ) a GROUP BY NAME";
//        dd($query_str);die;
        $person_workload_sum=DB::select($query_str, $query_params);

        $page_data = array(
            'mode'=>$type,
            'tasks_sum'=>$tasks_sum,
            'tasks_workload_sum'=>$tasks_workload_sum,
            'task_details'=>$task_details,
            'person_workload_totle'=>$person_workload_totle,
            'person_workload_sum'=>$person_workload_sum);
        return view('report.main_chart',['theme' => 'default','page_data'=>json_encode($page_data),'tasks_workload_sum'=>$tasks_workload_sum,'task_details'=>$task_details]);
    }

}
