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
//        $this->sync_ekp_customer();
//        $this->sync_customer_version();
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

    protected function sync_customer_version()
    {
        $customers = DB::table('customers')
            ->where('source',0)
            ->whereNull('erp_version')
            ->get();
        foreach($customers as $customer)
        {
            $customer_details = DB::table('customer_details')
                ->where('customer_uuid',$customer->uuid)
                ->get();
            if(!empty($customer_details)){
                $erp_version = null;
                $workflow_version = null;
                foreach($customer_details as $customer_detail){
                    if(empty($erp_version)){
                        $erp_version = $customer_detail->erp_version;
                    }else{
                        $erp_version = $erp_version . ',' . $customer_detail->erp_version;
                    }
                    if(empty($workflow_version)){
                        $workflow_version = $customer_detail->workflow_version;
                    }else{
                        $workflow_version = $workflow_version . ',' . $customer_detail->workflow_version;
                    }
                }
                $mysql_customer = Customer::find($customer->id);
                $mysql_customer->erp_version = $erp_version;
                $mysql_customer->workflow_version = $workflow_version;
                $mysql_customer->save();
                echo $this->print_log("客户 $customer->name 同步成功,ERP版本: $erp_version ,工作流版本: $workflow_version ");
            }

        }
    }

    //TODO：思路有问题，不要启用
    //同步移动用户
    protected function sync_app_customer()
    {

//        $tasks = DB::table('tasks')
//            ->where('customer_uuid',null)
//            ->where('abu_pm','刘嵩')
//            ->get();
//        foreach($tasks as $task){
//            $customers = DB::table('customers')->where('name','like','%'.$task->customer_name.'%')
//                ->orWhere('ekp_latest_name','like','%'.$task->customer_name.'%')
//                ->get();
//            if(empty($customers)){
//                $customer = new Customer();
//                $customer->name = $task->customer_name;
//                $customer->uuid = Uuid::generate();
//                $customer->is_app = 1;
//                $customer->is_standard = 1;
//                $customer->save();
//            }
//        }
    }

    protected function sync_customer_uuid(){
//        $query = '201';//这之后的任务，没有用38服务器了
//        $tasks =  DB::table('tasks')
//            ->where('task_no','like', $query.'%')
//            ->where('customer_uuid',null)
//            ->where('status','<',4)
//            ->get();


        //20150318-1195
        $query = '20150318-1195';//这之后的任务，没有用38服务器了
        $tasks =  DB::table('tasks')
            ->where('task_no','>', $query)
            ->where('customer_uuid',null)
//            ->where('status','<',4)
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

    protected function sync_ekp_customer()
    {
//        $this->sync_ekp_customer_init();
        $this->sync_ekp_customer_add();
    }
    //补充分析新客户
    protected function sync_ekp_customer_add()
    {
        $csts = DB::select('select a.*,b.area_name from customer_ekp a INNER JOIN customer_area_ekp b on a.area_id = b.area_id where `code` not in (select `code` from customer_ekp_copy_160805)');

        foreach($csts as $cst){
            if(!empty($cst)){
                $customer = new Customer();
                $customer->name = $cst->name;
                $customer->uuid = Uuid::generate();
                $customer->ekp_code = $cst->code;
                $customer->area = $cst->area_name;
                $customer->source = 1;
                $customer->save();
            }
        }

    }

    //ekp客户初始化的在Init文件中，这里只管更新规则
    protected function sync_ekp_customer_init()
    {
        //更新没有code客户
        //update customers a inner join customer b on a.`name` = b.`name` set a.ekp_code = b.`code` where a.ekp_code is null

        //北京区域过滤规则
        $csts = DB::select('select * from customer where area_id = \'6b676aeb-a0ab-4e4e-b301-7a614cdff49d\' and LEFT(name,2) = \'北京\' and `name` not in (\'北京一组_费用权责发生制\',\'北京二组erp303sp4专属\',\'北京307sp4\')and LEFT(`name`,4) not in (select LEFT(`name`,4) from customers )');

        foreach($csts as $cst)
        {
            if(!empty($cst)){
                $customer = new Customer();
                $customer->name = $cst->name;
                $customer->uuid = Uuid::generate();
                $customer->ekp_code = $cst->code;
                $customer->area = '北京';
                $customer->source = 1;
                $customer->save();
                echo $this->print_log("客户 $customer->name 同步成功,客户code: $cst->code ");
            }
        }

        //成渝区域
        $csts = DB::select('select * from customer where area_id = \'d157cafa-85b5-4353-b583-4c584b424180\' and `name` not in (\'TEST\') and LEFT(`name`,4) not in (select LEFT(`name`,4) from customers )');

        foreach($csts as $cst)
        {
            if(!empty($cst)){
                $customer = new Customer();
                $customer->name = $cst->name;
                $customer->uuid = Uuid::generate();
                $customer->ekp_code = $cst->code;
                $customer->area = '成渝';
                $customer->source = 1;
                $customer->save();
                echo $this->print_log("客户 $customer->name 同步成功,客户code: $cst->code ");
            }
        }

        //广州福建长沙中山区域
        $csts = DB::select('select * from customer where area_id = \'570680b7-d751-4986-a83a-8aa4c6f01aec\' and `name` not in (\'TEST\') and LEFT(`name`,4) not in (select LEFT(`name`,4) from customers )');
        foreach($csts as $cst)
        {
            if(!empty($cst)){
                $customer = new Customer();
                $customer->name = $cst->name;
                $customer->uuid = Uuid::generate();
                $customer->ekp_code = $cst->code;
//                $customer->area = '成渝';
                $customer->source = 1;
                $customer->save();
                echo $this->print_log("客户 $customer->name 同步成功,客户code: $cst->code ");
            }
        }

        //联营区域
        $csts = DB::select('select * from customer where area_id = \'ee0a764b-27d2-4bf5-af7b-6d196aa31c77\'  and `name` not in (\'TEST\') and LEFT(`name`,4) not in (select LEFT(`name`,4) from customers ) and LEFT(`name`,4) not in (\'标准产品\',\'产品验证\')');
        foreach($csts as $cst)
        {
            if(!empty($cst)){
                $customer = new Customer();
                $customer->name = $cst->name;
                $customer->uuid = Uuid::generate();
                $customer->ekp_code = $cst->code;
                $customer->area = '联营';
                $customer->source = 1;
                $customer->save();
                echo $this->print_log("客户 $customer->name 同步成功,客户code: $cst->code ");
            }
        }

        //上海区域
        $csts = DB::select('select * from customer where area_id = \'54fa8f61-55ff-4169-9fc2-8f63fdeb8ceb\'  and `name` not in (\'TEST\') and LEFT(`name`,4) not in (select LEFT(`name`,4) from customers ) and LEFT(`name`,4) not in (\'商城项目\')');
        foreach($csts as $cst)
        {
            if(!empty($cst)){
                $customer = new Customer();
                $customer->name = $cst->name;
                $customer->uuid = Uuid::generate();
                $customer->ekp_code = $cst->code;
                $customer->area = '上海';
                $customer->source = 1;
                $customer->save();
                echo $this->print_log("客户 $customer->name 同步成功,客户code: $cst->code ");
            }
        }

        //总部区域
        $csts = DB::select('select * from customer where area_id = \'b303ed9d-64ef-4f90-b6c6-c62819fbf387\'  and `name` not in (\'TEST\') and LEFT(`name`,4) not in (select LEFT(`name`,4) from customers ) and LEFT(`name`,4) not in (\'金威啤酒-粤海置地\',\'源动力\',\'星河\',\'万科\',\'招商\',\'明源公司\')');
        foreach($csts as $cst)
        {
            if(!empty($cst)){
                $customer = new Customer();
                $customer->name = $cst->name;
                $customer->uuid = Uuid::generate();
                $customer->ekp_code = $cst->code;
                $customer->area = '总部深圳';
                $customer->source = 1;
                $customer->save();
                echo $this->print_log("客户 $customer->name 同步成功,客户code: $cst->code ");
            }
        }



    }



    protected function print_log($context)
    {
        echo iconv('utf-8','gbk',$context).chr(10);
    }
}
