<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Task;
use App\TaskWorkload;

class SycnTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sycntask';

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
        $this->init_task();
//        echo 'ok';
    }

    protected function init_task()
    {
//        $tasks = DB::connection('sqlsrv')->select('select * from Task');
//        $count = 1;
//        echo $this->print_log("开始导入任务...请不要关闭程序！");
//        foreach ($tasks as $task) {
//            $mysql_task = new Task();
//            $mysql_task->TaskNo = $task->TaskNo;
//            $mysql_task->TaskTitle = $task->TaskTitle;
//            $mysql_task->CustomerName = $task->CustomerName;
//            $mysql_task->ErpVersion = $task->ErpVersion;
//            $mysql_task->MapVersion = $task->MapVersion;
//            $mysql_task->AbuPM = $task->AbuPM;
//            $mysql_task->CreateTime = $task->CreateTime;
//            $mysql_task->Start = $task->Start;
//            $mysql_task->ExpectEnd = $task->ExpectEnd;
//            $mysql_task->ActualEnd = $task->ActualEnd;
//            $mysql_task->Status = $task->Status;
//            $mysql_task->Comment = $task->Comment;
//            $mysql_task->TaskType = $task->TaskType;
//            $mysql_task->WorkflowVersion = $task->WorkflowVersion;
//            $mysql_task->IsExceedSLA = $task->IsExceedSLA;
//            $mysql_task->IsSensitive = $task->IsSensitive;
//            $mysql_task->save();
////            echo $task->TaskTitle.'<br>';
//            $count++;
//        }
//        echo $this->print_log("本次导入任务 $count 个");

        $task_workloads = DB::connection('sqlsrv')->select('select * from Workload');
        $count_workload = 1;
        echo $this->print_log("开始导入任务明细...请不要关闭程序！");
        foreach($task_workloads as $task_workload){
            $mysql_task_workload = new TaskWorkload();
            $mysql_task_workload->type = $task_workload->type;
            $mysql_task_workload->name = $task_workload->name;
            $mysql_task_workload->time = $task_workload->time;
            $mysql_task_workload->taskid = $task_workload->TaskId;
            $mysql_task_workload->save();
            $count_workload++;
        }
        echo $this->print_log("开始导入任务明细 $count_workload 个");
    }

    protected function print_log($context)
    {
        echo iconv('utf-8','gbk',$context).chr(10);
    }
}
