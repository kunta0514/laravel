<?php

namespace App\Http\Controllers\Excel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use DB;
use App\Models\Task;

class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tasks = Task::select('status','actual_finish_date','task_no', 'task_title','customer_name','abu_pm','erp_version','developer','developer_workload','tester','tester_workload','ekp_task_type','task_type','comment')
            ->where('task_no','20160615-0722')
            ->get();
//        print_r($tasks->toArray());
        $cellData = $tasks->toArray();
        foreach($cellData as $k=>$val){
            print_r(date("Y", strtotime($val['actual_finish_date'])));
            $cellData[0]['actual_finish_date'] = date("Y", strtotime($val['actual_finish_date']));
        }
        print_r($cellData);
        die;
        echo "OK";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $type 季度、月、周
     */
    public function task_end_report($type)
    {
        $query_begin = null;
        $query_end = null;
        switch($type){
            case 'month':
                $query_begin = date("Y-m-d",mktime(0,0,0,date("m")-1,1,date("Y")));
                $query_end = date("Y-m-d ",mktime(0,0,0,date("m")+1,1,date("Y")));
                break;
            case 'week':
                $query_begin = date("Y-m-d",strtotime("-1 week Monday"));
                $query_end = date("Y-m-d",strtotime("+0 week Monday"));
                break;
        }
        //TODO:这里的条件，在团队数据和个人数据中是不一样的，团队的用actual_finish_date，个人的用dev、test_end_date
        $tasks = Task::select('sum(developer_workload) + sum(tester_workload) as workload_all,
        sum(developer_workload) as developer_workload_all,
        sum(tester_workload) as tester_workload_all')
                ->where('actual_finish_date','>',$query_begin)
                ->where('actual_finish_date','<',$query_end)
                -get();

        $tasks_detail = Task::where('actual_finish_date','>',$query_begin)
                ->where('actual_finish_date','<',$query_end)
            -get();

    }

    public function task_report($type)
    {
        $file_name = '任务报表'.date("Ymd",strtotime("now"));
        $query_begin = date("Ymd",mktime(0,0,0,date("m")-1,1,date("Y")));
        $query_end = date("Ymd ",mktime(0,0,0,date("m")+1,1,date("Y")));
        $tasks = Task::select('COUNT(1),sum(case when `status` = 0 then 1 ELSE 0 end) as todo,sum(case when `status` = 1 then 1 ELSE 0 end) as deving,sum(case when `status` = 2 then 1 ELSE 0 end) as testing,sum(case when `status` > 2 then 1 ELSE 0 end) as over')
            ->where('task_no','>',$query_begin)
            ->get();

//        $cellData = $tasks->toArray();
//        $title = ['总数	','待处理','开发中','测试中','任务标题','已完成'];
//        Excel::create($file_name,function($excel) use ($cellData){
//            $excel->sheet('score', function($sheet) use ($cellData){
//                $sheet->rows($cellData);
//            });
//        })->export('xls');
    }

    public function task($type)
    {
        $tasks = null;
        $query = null;
        $title = ['状态	','完成时间','PRI','任务编号','任务标题','客户名称','PM','工作流版本','开发人员','工作量','测试人员','工作量','EKP任务','实际任务','备注'];

        $file_name = '任务明细'.date("Ymd",strtotime("now"));

        switch($type)
        {
            case 'year':
                $query_begin = date("Y",mktime(0,0,0,date("m"),1,date("Y")));
                $tasks = Task::select('status','actual_finish_date','PRI','task_no', 'task_title','customer_name','abu_pm','erp_version','developer','developer_workload','tester','tester_workload','ekp_task_type','task_type','comment')
                    ->where('task_no','>',$query_begin)
                    ->get();
                $file_name = '本年'.$file_name;
                break;
            case 'month':
                $query_begin = date("Ymd",mktime(0,0,0,date("m")-1,1,date("Y")));
                $query_end = date("Ymd ",mktime(0,0,0,date("m")+1,1,date("Y")));
                $tasks = Task::select('status','actual_finish_date','task_no', 'task_title','customer_name','abu_pm','erp_version','developer','developer_workload','tester','tester_workload','ekp_task_type','task_type','comment')
                    ->where('task_no','>',$query_begin)
                    ->where('task_no','<',$query_end)
                    ->orWhere('status','<', 3)
                    ->get();
                $file_name = '本月'.$file_name;
                break;
            case 'week':
                $query_begin = date("Ymd",strtotime("-1 week Monday"));
                $query_end = date("Ymd",strtotime("+0 week Monday"));
                $tasks = Task::select('status','actual_finish_date','PRI','task_no', 'task_title','customer_name','abu_pm','erp_version','developer','developer_workload','tester','tester_workload','ekp_task_type','task_type','comment')
//            ->where('developer_workload',0)
                    ->where('task_no','>',$query_begin)
                    ->where('task_no','<',$query_end)
                    ->get();
                $file_name = '本周'.$file_name;
                break;
            case 'yd':
                $tasks = Task::select('status','actual_finish_date','PRI','task_no', 'task_title','customer_name','abu_pm','erp_version','developer','developer_workload','tester','tester_workload','ekp_task_type','task_type','comment')
                    ->where('abu_pm','刘嵩')
                    ->orderBy('task_no','DESC')
                    ->get();
                $file_name = '本周'.$file_name;
                break;

        }

        $cellData = [];
        $cellData = $tasks->toArray();
////        print_r($tasks);
        foreach($cellData as $k=>$val){
            if(date("Y-m-d", strtotime($val['actual_finish_date'])) === '1970-01-01' || date("Y-m-d", strtotime($val['actual_finish_date'])) === '-0001-11-30'){
                $cellData[$k]['actual_finish_date'] = "";
            }else
            {
                $cellData[$k]['actual_finish_date'] = date("Y-m-d", strtotime($val['actual_finish_date']));
            }
            $cellData[$k]['status'] = Config('params.task_status')[$val['status']];
            $cellData[$k]['developer'] = $val['dev_name'];
            $cellData[$k]['tester'] = $val['tester_name'];
            unset($cellData[$k]['dev_name']);
            unset($cellData[$k]['tester_name']);
        }
//        print_r($cellData);
//        die;
//        print_r($cellData);

        Excel::create($file_name,function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    protected function my_time()
    {
        echo date("Ymd",strtotime("now")), "\n";
        echo date("Ymd",strtotime("-1 week Monday")), "\n";
        echo date("Ymd",strtotime("-1 week Sunday")), "\n";
        echo date("Ymd",strtotime("+0 week Monday")), "\n";
        echo date("Ymd",strtotime("+0 week Sunday")), "\n";

        echo "*********第几个月:";
        echo date('n');
        echo "*********本周周几:";
        echo date("w");
        echo "*********本月天数:";
        echo date("t");
        echo "*********";

        echo '<br>上周起始时间:<br>';
        echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y"))),"\n";
        echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y"))),"\n";
        echo '<br>本周起始时间:<br>';
        echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"))),"\n";
        echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))),"\n";

        echo '<br>上月起始时间:<br>';
        echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y"))),"\n";
        echo date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y"))),"\n";
        echo '<br>本月起始时间:<br>';
        echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y"))),"\n";
        echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y"))),"\n";

        $season = ceil((date('n'))/3);//当月是第几季度
        echo '<br>本季度起始时间:<br>';
        echo date('Y-m-d H:i:s', mktime(0, 0, 0,$season*3-3+1,1,date('Y'))),"\n";
        echo date('Y-m-d H:i:s', mktime(23,59,59,$season*3,date('t',mktime(0, 0 , 0,$season*3,1,date("Y"))),date('Y'))),"\n";

        $season = ceil((date('n'))/3)-1;//上季度是第几季度
        echo '<br>上季度起始时间:<br>';
        echo date('Y-m-d H:i:s', mktime(0, 0, 0,$season*3-3+1,1,date('Y'))),"\n";
        echo date('Y-m-d H:i:s', mktime(23,59,59,$season*3,date('t',mktime(0, 0 , 0,$season*3,1,date("Y"))),date('Y'))),"\n";
    }
}
