<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
        $this->sync_customer_task();
    }

    //刷新UUID
    protected function sync_customer()
    {
        $customer = DB::table('Projects')->get();
        foreach($customer as $val)
        {
            $customer = new Customer();
            $customer->name = $val->name;
            $customer->path = $val->path;
            $customer->uuid = Uuid::generate();
            $customer->save();
        }
        $customer_details = DB::table('customers')
            ->join('projects2workflow','customers.name','=','projects2workflow.project_name')
            ->select('customers.uuid','projects2workflow.*')
            ->get();

//        print_r($customer_details);

        foreach($customer_details as $val) {
            $customer_details = new CustomerDetail();
            $customer_details->customer_uuid = $val->uuid;
            $customer_details->customer_name = $val->project_name;
            $customer_details->path = $val->path;
            $customer_details->workflow_path = $val->workflow_path;
            $customer_details->assemblyInfo_path = $val->assemblyInfo_path;
            $customer_details->assemblyInfo = $val->assemblyInfo;
            $customer_details->assemblyFileInfo = $val->assemblyFileInfo;
            $customer_details->workflow_version = $val->workflow_version;
            $customer_details->erp_version = $val->erp_version;
            $customer_details->save();
//        print_r($customer);
        }
    }

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

    protected function print_log($context)
    {
        echo iconv('utf-8','gbk',$context).chr(10);
    }
}
