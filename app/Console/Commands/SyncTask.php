<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use Log;

include 'simple_html_dom.php';

class SyncTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sync_task';

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
        //sync
//        return $this->sync_task();
//        echo 'ok';
//        return $this->sync_ekp_oid();
//        return $this->sync_ekp_task_type();
//        return $this->sync_workload();

//        return $this->spider('20160506-0378');
    }


    private static $user_cookie = '9da1e58d-cccb-4528-93d5-e93f40951b53={"MySettingID":"00000000-0000-0000-0000-000000000000","DefaultLoadPage":"MyPendingList","PendingShow":true,"PreSubmitShow":true,"MyAllShow":true,"AllShow":true,"DefaultPageSize":10,"DataMode":0,"UserGUID":null,"RealDataMode":0,"CreatedBy":null,"CreatedOn":null,"ModifiedBy":null,"ModifiedOn":null,"VersionNumber":0,"_DataState":0}; Login_User=UserCode=wank&SignTime=2016-01-21 15:59:27&UserSign=j6rLyJuRe2VCavJ0d2AgUsFwqRYmbmXuknAjL/cDzI2yDwFFAxKBOUzS+ht3lTKVC/1hJGbxB+R3AdeoW5y9S/T9GolzeEpIFszkxhBjcnhifUqqa0KT7gZuvrTbjnbH+TBg0h4E/3vJN0x4maACInOVXpHe58m+bsvyjCRW1Dc=';

    protected function sync_task()
    {
        $url = 'http://pd.mysoft.net.cn/AjaxRequirement/GetAllRequirementList.cspx?KeyValue=&ManagerName=&TeamMembers=&Status=0%2C1%2C2%2C3%2C4%2C5&Source=&XqType=&CustomerType=&CustomerArea=&HandlerToRequirementType=&CreatedOnType=&DevelopEndTimeType=&TechReLmtType=&TaskDoneLmtType=&OrderSeq=';
        $pm = '万堃';
        $cur_page = 1;
        $params = "&PMName=$pm&PageIndex=$cur_page";
        $url = $url .$params;

        $method = 'GET';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //模拟登录
        curl_setopt($ch, CURLOPT_COOKIE, self::$user_cookie);
        //模拟打开浏览器
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        if ($method === 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, true );
        }
        $result = curl_exec($ch);
        $j = json_decode($result);

        $total_count = $j->TotalCount;
        $html = $j->html;

        $count=0;
        $html = str_get_html($html);
        foreach($html->find('div[class*=singleRequirementCard]') as $task_node)
        {
            $task_no = $task_node->find('div[class*=title]',0)->children(0)->plaintext;
            $str = ['【','】'];
            $task_no =trim(str_replace($str,"",$task_no));
            $ekp_oid=$task_node->find('div[class*=title]',0)->children(1)->attr['href'];

            $task_title = trim($task_node->find('div[class*=title]',0)->children(1)->plaintext);
            $task_cst_name = $task_node->find('li[title=客户名称]',0)->plaintext;
            $ekp_task_type = $task_node->find('li[title=需求类型]',0)->plaintext;
            $task_apu_pm = $task_node->find('li[title=需求负责人]',0)->plaintext;
            $task_status = $task_node->find('div[class*=status]',0)->plaintext;

            //判断任务是否已经存在，存在则不同步
            $exits_task_no = DB::table('tasks')->where('task_no',$task_no)->pluck('task_no');
            if(empty($exits_task_no))
            {
                $mysql_task = new Task();
                $mysql_task->task_no = $task_no;
                $mysql_task->task_title = $task_title;
                $mysql_task->customer_name = $task_cst_name;
                $mysql_task->ekp_oid=$ekp_oid;

                $mysql_task->abu_pm = $task_apu_pm;
                $mysql_task->ekp_create_date = date("y-m-d",time());
                $mysql_task->status = $task_status;
                $mysql_task->ekp_task_type = $ekp_task_type;
                $mysql_task->ekp_expect=date("y-m-d",time());
                //TODO：根据客户自动判断
//            $mysql_task->erp_version = $task->ErpVersion;
//            $mysql_task->map_version = $task->MapVersion;
//            $mysql_task->workflow_version = $task->WorkflowVersion;

                //根据客户名称查询客户台账中的唯一用户
                $customers = DB::table('customers')->where('name','like','%'.$task_cst_name.'%')
                    ->orWhere('ekp_latest_name','like','%'.$task_cst_name.'%')
                    ->get();

                if(!empty($customers)){
                    if(count($customers) == 1){
                        $mysql_task->customer_uuid = $customers[0]->uuid;
                    }
                    if(count($customers) > 1){
                        foreach($customers as $val){
                            $mysql_task->customer_uuid = $val->uuid;
                            break;
                        }
                    }
                }
                $mysql_task->save();
                $count++;
            }
        }
        Log::info('同步任务系统记录'.date("Y-m-d H:i:s",strtotime("now")));
        return $count;
    }

    protected function sync_ekp_oid()
    {
        $tasks =  DB::table('tasks')->where('ekp_oid', '')
//            ->where('task_no','like', $query.'%')
            ->orderBy('task_no','desc')->get();
        foreach($tasks as $task) {
            if(empty($task->ekp_oid))
            {
                if(!empty($task->task_no))
                {
                    $ekp_oid = $this->spider($task->task_no);
                    DB::table('tasks')->where('id', $task->id)->update(['ekp_oid' => $ekp_oid]);
                    echo $this->print_log("任务 $task->task_no 同步中，访问地址： $ekp_oid ");
                }
            }
        }
    }


    protected function sync_ekp_task_type()
    {
        $query = '2016';
        $tasks =  DB::table('tasks')->where('ekp_task_type', '')
            ->where('task_no','like', $query.'%')
            ->orderBy('task_no','desc')->get();
        foreach($tasks as $task) {
            $ekp_task_type = $this->spider(trim($task->task_no));
            DB::table('tasks')->where('id', $task->id)->update(['ekp_task_type' => $ekp_task_type]);
            echo $this->print_log("任务 $task->task_no 同步中，任务类型： $ekp_task_type ");
        }
    }

    protected function sync_workload()
    {
        $query = '2013';//这之后的任务，没有用38服务器了
        $tasks =  DB::table('tasks')->where('task_no','like', $query.'%')->get();

//        print_r($tasks);
//        die;

        foreach($tasks as $task)
        {
            $task_old =  DB::connection('sqlsrv')->select("select * from Task where TaskNo = '$task->task_no'");
            $t = $task_old[0]->TaskId;
            $task_old_workload =  DB::connection('sqlsrv')->select("select * from Workload where TaskId = $t ");

            foreach ($task_old_workload as $item) {

                $mysql_task = Task::find($task->id);
                if($item->type == 0){
                    if(empty($mysql_task->developer)){
                        $mysql_task->developer = $item->name;
                    }
                    else{
                        $mysql_task->developer = $mysql_task->developer . ',' . $item->name;
                    }
                    if($mysql_task->developer_workload == 0){
                        $mysql_task->developer_workload = $item->time;
                    }
                    else{
                        $mysql_task->developer_workload = $mysql_task->developer_workload + $item->time;
                    }
                }
                else{
                    if(empty($mysql_task->tester)){
                        $mysql_task->tester = $item->name;
                    }
                    else{
                        $mysql_task->tester = $mysql_task->tester . ',' . $item->name;
                    }
                    if($mysql_task->tester_workload == 0){
                        $mysql_task->tester_workload = $item->time;
                    }
                    else{
                        $mysql_task->tester_workload = $mysql_task->tester_workload + $item->time;
                    }
                }
                $mysql_task->save();
            }
            echo $this->print_log("任务 $task->task_no 同步中 ");
        }
    }

    protected function print_log($context)
    {
        echo iconv('utf-8','gbk',$context).chr(10);
    }

    protected function spider($task_no)
    {
        $url = 'http://pd.mysoft.net.cn/AjaxRequirement/GetAllRequirementList.cspx?Customerchn=&ManagerName=&PMName=&TeamMembers=&Status=&Source=&XqType=&CustomerType=&CustomerArea=&HandlerToRequirementType=&CreatedOnType=&RecordDateBegin=&RecordDateEnd=&DevelopEndTimeType=&FinishiDateBegin=&FinishiDateEnd=&TechReLmtType=&RechDateBegin=&RechDateEnd=&TaskDoneLmtType=&DcDateBegin=&DcDateEnd=&IsHaveTestDoc=&OrderSeq=&PageSize=100';
        $params='&KeyValue='.$task_no;
        $url = $url .$params;
        $method = 'GET';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //模拟登录
        curl_setopt($ch, CURLOPT_COOKIE, self::$user_cookie);
        //模拟打开浏览器
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true );
        }
        $result = curl_exec($ch);
        $j = json_decode($result);
        $total_count = $j->TotalCount;
        $html = $j->html;
        $count=0;
        $html = str_get_html($html);
        $ekp_oid = '';
        $ekp_task_type = '';
        foreach($html->find('div[class*=singleRequirementCard]') as $task_node) {
            $task_no_cur = $task_node->find('div[class*=title]',0)->children(0)->plaintext;
            $str = ['【','】'];
            $task_no_cur =trim(str_replace($str,"",$task_no_cur));
            if($task_no_cur == $task_no) {
                $ekp_task_type = $task_node->find('li[title=需求类型]',0)->plaintext;
            }
        }
        return $ekp_task_type;
    }

}
