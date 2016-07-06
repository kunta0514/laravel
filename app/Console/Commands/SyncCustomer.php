<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\Customer;
use App\Models\CustomerDetail;
use Webpatser\Uuid\Uuid;

class SyncCustomer extends Command
{
    /**e
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sync_cus';

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
//        $this->sync_customer();
//        $this->sync_app_customer();
        $this->sync_customer_uuid();
    }

    //第一次初始化用，不要在使用！
//    protected function sync_customer()
//    {
//        $customer = DB::table('Projects')->get();
//        foreach($customer as $val)
//        {
//            $customer = new Customer();
//            $customer->name = $val->name;
//            $customer->path = $val->path;
//            $customer->uuid = Uuid::generate();
//            $customer->save();
//        }
//        $customer_details = DB::table('customers')
//            ->join('projects2workflow','customers.name','=','projects2workflow.project_name')
//            ->select('customers.uuid','projects2workflow.*')
//            ->get();
//
////        print_r($customer_details);
//
//        foreach($customer_details as $val) {
//            $customer_details = new CustomerDetail();
//            $customer_details->customer_uuid = $val->uuid;
//            $customer_details->customer_name = $val->project_name;
//            $customer_details->path = $val->path;
//            $customer_details->workflow_path = $val->workflow_path;
//            $customer_details->assemblyInfo_path = $val->assemblyInfo_path;
//            $customer_details->assemblyInfo = $val->assemblyInfo;
//            $customer_details->assemblyFileInfo = $val->assemblyFileInfo;
//            $customer_details->workflow_version = $val->workflow_version;
//            $customer_details->erp_version = $val->erp_version;
//            $customer_details->save();
////        print_r($customer);
//        }
//    }

    protected function sync_customer_task()
    {
        $tasks = DB::table('tasks')
//            ->where('developer_workload',0)
            ->where('task_no','>','2016')
            ->get();

        foreach($tasks as $task)
        {
            $customers = DB::table('customers')->where('name','like','%'.$task->customer_name.'%')
                ->orWhere('ekp_latest_name','like','%'.$task->customer_name.'%')
                ->get();


            if(!empty($customers)){
                if(count($customers) == 1){
//                        print_r($customers[0]->uuid);
//                        die;
                    $uuid = $customers[0]->uuid;
                }
                if(count($customers) > 1){
                    foreach($customers as $val){
                        $uuid = $val->uuid;
                        break;
                    }
                }
                DB::table('tasks')->where('id', $task->id)->update(['customer_uuid' => $uuid]);
                echo $this->print_log("任务 $task->task_no 客户uuid同步中 $uuid ");
            }
        }
    }

    //同步移动用户
    protected function sync_app_customer()
    {
        $tasks = DB::table('tasks')
            ->where('customer_uuid',null)
            ->where('abu_pm','刘嵩')
            ->get();
        foreach($tasks as $task){
            $customers = DB::table('customers')->where('name','like','%'.$task->customer_name.'%')
                ->orWhere('ekp_latest_name','like','%'.$task->customer_name.'%')
                ->get();
            if(empty($customers)){
                $customer = new Customer();
                $customer->name = $task->customer_name;
                $customer->uuid = Uuid::generate();
                $customer->is_app = 1;
                $customer->is_standard = 1;
                $customer->save();
            }
        }
    }

    protected function sync_customer_uuid(){
        $query = '2016';//这之后的任务，没有用38服务器了
        $tasks =  DB::table('tasks')
            ->where('task_no','like', $query.'%')
            ->where('customer_uuid',null)
            ->where('status','<',4)
            ->get();

        foreach($tasks as $task){
            $customers = DB::table('customers')->where('name','like','%'.$task->customer_name.'%')
                ->orWhere('ekp_latest_name','like','%'.$task->customer_name.'%')
                ->get();

            if(!empty($customers)){
                $mysql_task = Task::find($task->id);
                if(count($customers) == 1){
                    $mysql_task->customer_uuid = $customers[0]->uuid;
                }
                if(count($customers) > 1){
                    foreach($customers as $val){
                        $mysql_task->customer_uuid = $val->uuid;
                        break;
                    }
                }
                $mysql_task->save();
                echo $this->print_log("任务 $task->task_no 同步中,客户名: $task->customer_name ");
            }else{
                echo $this->print_log("任务 $task->task_no 同步失败,客户名: $task->customer_name ");
            }
        }
    }

    protected function print_log($context)
    {
        echo iconv('utf-8','gbk',$context).chr(10);
    }
}
