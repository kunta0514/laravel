<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Task;
use App\TaskWorkload;

class InitTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:init_task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
//        echo '111';
        $this->init_task();
//        echo 'ok';
    }

    protected function init_task()
    {
        $tasks = DB::connection('sqlsrv')->select('select * from Task');
        $count = 1;
        echo $this->print_log("开始导入任务...请不要关闭程序！");
        foreach ($tasks as $task) {
            $mysql_task = new Task();
            $mysql_task->task_no = $task->TaskNo;
            $mysql_task->task_title = $task->TaskTitle;
            $mysql_task->customer_name = $task->CustomerName;
            $mysql_task->erp_version = $task->ErpVersion;
            $mysql_task->map_version = $task->MapVersion;
            $mysql_task->abu_pm = $task->AbuPM;
            $mysql_task->ekp_create_date = isset($task->CreateTime) ? $task->CreateTime:null;
            $mysql_task->start = $task->Start;
            $mysql_task->ekp_expect = isset($task->ExpectEnd) ? $task->ExpectEnd:null;;
            $mysql_task->actual_finish_date = isset($task->ActualEnd) ? $task->ActualEnd:null;
            $mysql_task->status = $task->Status;
            $mysql_task->comment = $task->Comment;
            $mysql_task->task_type = $task->TaskType;
            $mysql_task->workflow_version = $task->WorkflowVersion;
            $mysql_task->is_sla = $task->IsExceedSLA;
            $mysql_task->is_sensitive = $task->IsSensitive;
            $mysql_task->save();
//            echo $task->TaskTitle.'<br>';
            echo $this->print_log("任务： $task->TaskNo 同步中");
            $count++;
        }
        echo $this->print_log("本次导入任务 $count 个");

        $task_workloads = DB::connection('sqlsrv')->select('select * from Workload');
        $count_workload = 1;
        echo $this->print_log("开始导入任务明细...请不要关闭程序！");
        foreach($task_workloads as $task_workload){
            //TODO::此计算方式存在问题，38中的taskid与mysql中的taskid不一样，导致取到明细存在问题。
//            $mysql_task = Task::find($task_workload->TaskId);
//            if($task_workload->type == 0){
//                if(empty($mysql_task->developer)){
//                    $mysql_task->developer = $task_workload->name;
//                }
//                else{
//                    $mysql_task->developer = $mysql_task->developer . ',' . $task_workload->name;
//                }
//                if($mysql_task->developer_workload == 0){
//                    $mysql_task->developer_workload = $task_workload->time;
//                }
//                else{
//                    $mysql_task->developer_workload = $mysql_task->developer_workload + $task_workload->time;
//                }
//            }
//            else{
//                if(empty($mysql_task->tester)){
//                    $mysql_task->tester = $task_workload->name;
//                }
//                else{
//                    $mysql_task->tester = $mysql_task->tester . ',' . $task_workload->name;
//                }
//                if($mysql_task->tester_workload == 0){
//                    $mysql_task->tester_workload = $task_workload->time;
//                }
//                else{
//                    $mysql_task->tester_workload = $mysql_task->tester_workload + $task_workload->time;
//                }
//            }
//            $mysql_task->save();
            $mysql_task_workload = new TaskWorkload();
            $mysql_task_workload->type = $task_workload->type;
            $mysql_task_workload->name = $task_workload->name;
            $mysql_task_workload->time = $task_workload->time;
            $mysql_task_workload->task_id = $task_workload->TaskId;
            $mysql_task_workload->save();
            echo $this->print_log("任务明细： $task_workload->TaskId 同步中...");
//            die;
            $count_workload++;
        }
        echo $this->print_log("开始导入任务明细 $count_workload 个");
    }

    public function update_task()
    {

    }

    protected function print_log($context)
    {
        echo iconv('utf-8','gbk',$context).chr(10);
    }
}
