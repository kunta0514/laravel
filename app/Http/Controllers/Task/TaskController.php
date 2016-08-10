<?php

namespace App\Http\Controllers\Task;

use App\CheckPersonalize;
use App\Http\Controllers\Solution\SolutionController;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\CustomerUpdateLog;
use Illuminate\Support\Facades\Config;
use Redirect, Input, Auth;
use Cache;
use Carbon\Carbon;
use DB;
use Webpatser\Uuid\Uuid;
use App\Models\CustomerDetail;

class TaskController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //TODO:调整为读取缓存
        $page_data=array(
            'task_status'=>Config('params.task_status'),
        );

        return view('task.main', ['theme' => 'default','page_data'=>json_encode($page_data,JSON_UNESCAPED_UNICODE)]);
    }

    /**
     * 获取待处理任务列表
     * @Date 2016年6月28日18:17:21
     * @Author  zhuangsd
     * @return \Illuminate\Http\Response
     */
    public function get_todo_taskList(Request $request)
    {
//        dd($request->search);die;
        $task_list = Task::where('status', '<', 3)->orderBy('task_no')->get();
        return json_encode(Array('data'=>$task_list->toArray()));
    }


    //get 测试功能方法
    public function wonder4($id)
    {
//        dd(config('params.task_status'));

        // $task=new CheckPersonalize();
        // $task->alias="wonder4";
        //
        // dd($task->save());
        //
        // dd($task->id);
//        echo date("Y-m-d",time());
//        $task_detail = Task::find($id);
//
//       echo($task_detail->build_mail_content());
        $task_list = Task::where('status', '<', 3)->orderBy('task_no')->get();
//        return view('task.main', ['theme' => 'default', 'tasks' => array('data'=>$task_list->toArray()), 'developers' => Cache::get('developers'), 'testers' => Cache::get('testers')]);

        return json_encode(Array('data'=>$task_list->toArray()));
    }


    /**g
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $developers = Cache::get('developers',function(){
            $users = DB::table('users')->select('code', 'name','role','admin')->where('role', 0)->where('is_out',0)->get();
            Cache::forever('developers', $users);
            return $users;
        });

        $testers = Cache::get('testers',function(){
            $users = DB::table('users')->select('code', 'name','role','admin')->where('role', 1)->where('is_out',0)->get();
            Cache::forever('testers', $users);
            return $users;
        });

        $task = Task::find($id);

        //TODO::人员下拉框可以提炼组件化
        return view('task.edit', ['theme' => 'default', 'task' =>  $task, 'developers' => $developers, 'testers' => $testers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!empty($request->path())) {
            $query = [];
            if(empty($request->ekp_oid)){
                $solution=new SolutionController();
                //TODO::oid保存的是herf地址，需要改造成只存OID，打开地址在配置中体现
                $query['ekp_oid'] = str_replace('\"','',$solution->view_pd($request->task_no)[0]->attr['href']);
            }
            $old_task = Task::find($id);
            //TODO::保存校验加上数据存储还不够简练，写的很low
            if(!empty($request->comment)){
                $query['comment'] = $request->comment;
            }
            if(!empty($request->status || $request->status == 0)){
                $query['status'] = $request->status;
                //待处理->开发中、测试中、已完成
                if($query['status'] > 0 && $old_task->status == 0){
                    $query['start'] = date("Y-m-d",strtotime("now"));
                    switch($query['status']){
                        case 1 : $query['developer_start']  = date("Y-m-d",strtotime("now"));
                            break;
                        case 2 : $query['developer_start']  = date("Y-m-d",strtotime("now"));
                            $query['developer_end']  = date("Y-m-d",strtotime("now"));
                            $query['tester_start']  = date("Y-m-d",strtotime("now"));
                        case 3 :$query['developer_start']  = date("Y-m-d",strtotime("now"));
                            $query['developer_end']  = date("Y-m-d",strtotime("now"));
                            $query['tester_start']  = date("Y-m-d",strtotime("now"));
                            $query['tester_end']  = date("Y-m-d",strtotime("now"));
                    }
                }
                //开发中->测试中、已完成
                if($query['status'] > 1 && $old_task->status == 1){
                    switch($query['status']){
                        case 2 : $query['developer_end']  = date("Y-m-d",strtotime("now"));
                            $query['tester_start']  = date("Y-m-d",strtotime("now"));
                        case 3 : $query['developer_end']  = date("Y-m-d",strtotime("now"));
                            $query['tester_start']  = date("Y-m-d",strtotime("now"));
                            $query['tester_end']  = date("Y-m-d",strtotime("now"));
                    }
                }
                //测试中->已完成
                if($query['status'] > 2 && $old_task->status == 2){
                    switch($query['status']){
                        case 3 : $query['tester_end']  = date("Y-m-d",strtotime("now"));
                    }
                }
                //只指定人员，但是不指定状态
                if($query['status']==0 && $old_task->status == 0 && (!empty($request->developer) || !empty($request->tester)))
                {
                    $query['developer_start']  = date("Y-m-d",strtotime("now"));
                }
            }
            //完成时间不为空时，保存完成时间
            if(!empty($request->actual_finish_date)){
                $query['actual_finish_date'] = $request->actual_finish_date;
            }

            if(!empty($request->developer)){
                $query['developer'] = $request->developer;
            }
            if(!empty($request->developer_workload|| $request->developer_workload == 0)){
                $query['developer_workload'] = $request->developer_workload;
            }
            if(!empty($request->tester)){
                $query['tester'] = $request->tester;
            }
            if(!empty($request->tester_workload) || $request->tester_workload == 0){
                $query['tester_workload'] = $request->tester_workload;
            }

            if(!empty($request->task_type)){
                $query['task_type'] = $request->task_type;
            }
            if(!empty($request->PRI)|| $request->PRI == 0){
                $query['PRI'] = $request->PRI;
            }
            if(!empty($request->update_type )|| $request->update_type == 0){
                $query['update_type'] = $request->update_type;
            }
            if(!empty($query)){
                $result = DB::transaction(function () use ($request,$query,$id) {
                    //更新任务
                    DB::table('tasks')->where('id', $request->id)->update($query);
                    //更新客户升级日志
                    if($request->update_type != 0){
                        $customers_update = [] ;
                        $customers_update['update_type'] = $request->update_type;
                        DB::table('customers')->where('uuid', $request->uuid)->update(['update_type'=>$query['update_type']]);
                        if(empty(DB::table('customer_update_log')->where('task_no',$request->task_no)->get())){
                            $customers_update_log = new CustomerUpdateLog();
                            $customers_update_log->task_id = $id;
                            $customers_update_log->task_no = $request->task_no;

                            if(!empty($request->uuid)){
                                $customers_update_log->uuid = $request->uuid;
                            }
                            $customers_update_log->remember_token = date("Ymd",strtotime("now")).'完成升级，任务编号：'.$request->task_no;
                            $customers_update_log->save();
                        }
                    }
                });
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fast_handle($id)
    {
        $task=Task::find($id);
        if($task!=null &&  $task->status<3)
        {
            $task->status += 1;
        }else
        {
            return 'false';
        }
        return ($task->save()) ? 'ok':'false';
    }


    /**
     * @param $task_no
     * @return mixed
     */
    public function view_pd($task_no)
    {
        $solution=new SolutionController();
        return str_replace('\"','',$solution->view_pd($task_no)[0]->attr['href']);
    }

    public function tag()
    {
        //TODO：读取当前团队的标签，展示列表
        return view('task.tag_add');
    }

    public function query()
    {
//        $tasks = $request;
        $tasks = null;
//        $query = 1;
//        $task = DB::table('tasks')->where('task_no','like',$query.'%')->get();
//        print_r($task);
//        $queries = DB::getQueryLog();
//        print_r($queries);
        return view('task.query', ['theme' => 'default','tasks' => $tasks]);
    }

    //TODO:根据查询条件查询结果
    public function query_task(Request $request)
    {
        $data = [];
        //查询条件为自带
        $query = $request->input('search')['value'];
        if(!empty($query)){
            $tasks = Task::where('task_no','like',$query.'%')
                ->orWhere('task_title','like','%'.$query.'%')
                ->orWhere('customer_name','like','%'.$query.'%')
                ->orderBy('task_no', 'desc')
                ->get();
            if(!empty($tasks)){
                $data = $tasks->toArray();
            }
        }
        $ret=[
            'data' => $data,
        ];
        return json_encode($ret,JSON_UNESCAPED_UNICODE);
    }

    public function test_page()
    {
//        $users = Cache::get('user',function(){
//            $users = DB::table('users')->select('code', 'name','role','admin')->get();
//            Cache::forever('user', $users);
//        });
//        $user_code = 'wank,zhuangsd';
//        if(!empty($user_code))
//        {
//            $arr_user_code = explode(',',$user_code);
//            $user_name = [];
////            var_dump($users);
//            if(count($arr_user_code) > 1){
//                //循环数组，输出名字
//                foreach($arr_user_code as $val) {
//                    foreach($users as $user){
//                        if($user->code == $val){
//                            $user_name[$val] = $user->name;
//                        }
//                    }
//                    if(empty($user_name[$val])){
//                        $user_name[$val] = '未知';
//                    }
//                }
//            }
//            else{
//                foreach($users as $user) {
//                    if($user->code == $user_code) {
//                        $user_name[$user_code] = $user->name;
//                    }
//                }
//                if(empty($user_name[$user_code])){
//                    $user_name[$user_code] = '未知';
//                }
//            }
//            var_dump(join(',',$user_name));die;
//        }
//        else
//        {
//            echo '未知code';
//        }
//        $cellData = [
//            ['学号','姓名','成绩'],
//            ['10001','AAAAA','99'],
//            ['10002','BBBBB','92'],
//            ['10003','CCCCC','95'],
//            ['10004','DDDDD','89'],
//            ['10005','EEEEE','96'],
//        ];
        $query = '2016';
        $title = ['任务编号	','任务标题','客户名称','PM','工作流版本','开发人员','测试人员','备注','开发人员','测试人员'];
//        $tasks = DB::table('tasks')->select('task_no', 'task_title','customer_name','abu_pm','erp_version','developer','tester','comment')->where('task_no','like',$query.'%')->get();
        $tasks = Task::select('ekp_task_type','task_type','task_no', 'task_title','customer_name','abu_pm','erp_version','developer','developer_workload','tester','tester_workload','comment')
            ->where('task_no','like',$query.'%')
            ->orderBy('task_no')
            ->get();
        $cellData = [];
        $cellData = $tasks->toArray();
//        $cellData[] = $title;

        Excel::create('本年任务明细-2016-05',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');

//        $x = Uuid::generate();
//        echo $x;
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

    }

    public function test()
    {
//        $query = '201601';
//        $tasks = DB::table('tasks')->where('task_no','like',$query.'%')
////            ->orWhere('customer_name','like','%'.$query.'%')
//            ->get();
//        return view('task.test', ['theme' => 'default', 'tasks' => $tasks]);
        $this->my_time();
    }

    public function history($type)
    {
        //本周、本月，本季度，上周，上月，上季度
        $tasks = null;
        $query = null;
        switch($type)
        {
            case 'year':
                $query_begin = date("Y",mktime(0,0,0,date("m"),1,date("Y")));
                $query_end = null;
                $tasks = DB::table('tasks')
                    ->where('task_no','>',$query_begin)
                    ->get();
                break;
            case 'month':
                $query_begin = date("Ymd",mktime(0,0,0,date("m")-1,1,date("Y")));
                $query_end = date("Ymd ",mktime(0,0,0,date("m")+1,1,date("Y")));
                $tasks = DB::table('tasks')
                    ->where('task_no','>',$query_begin)
                    ->where('task_no','<',$query_end)
                    ->get();
                break;
            case 'week':
                $query_begin = date("Ymd",strtotime("-2 week Monday"));
                $query_end = date("Ymd",strtotime("+0 week Monday"));
                $tasks = DB::table('tasks')
                    ->where('task_no','>',$query_begin)
                    ->where('task_no','<',$query_end)
                    ->get();
                break;
            case 'yd':
                $tasks = DB::table('tasks')
                    ->where('abu_pm','刘嵩')
                    ->orderBy('task_no','DESC')
                    ->get();
                break;

        }
        return view('task.history', ['theme' => 'default','tasks' => $tasks, 'type' => $type]);
    }



    public function sync_task()
    {
        $result=Artisan::call('command:sync_task', []);
        return $result;
    }


    private function get_userName($user_code)
    {
//        Cache::pull('user');
        $users = Cache::get('user',function(){
            $users = DB::table('users')->select('code', 'name','role','admin')->get();
            Cache::forever('user', $users);
        });

        if(!empty($user_code)) {
            $arr_user_code = explode(',',$user_code);
            $user_name = [];
            if(count($arr_user_code) > 1){
                //循环数组，输出名字
                foreach($arr_user_code as $val) {
                    foreach($users as $user){
                        if($user->code == $val){
                            $user_name[$val] = $user->name;
                        }
                    }
                    if(empty($user_name[$val])){
                        $user_name[$val] = '未知1';
                    }
                }
            }
            else{
                foreach($users as $user) {
                    if($user->code == $user_code) {
                        $user_name[$user_code] = $user->name;
                    }
                }
                if(empty($user_name[$user_code])){
                    $user_name[$user_code] = '未知2';
                }
            }
            return join(',',$user_name);
        }
    }

    protected function object_array($array)
    {
        if(is_object($array))
        {
            $array = (array)$array;
        }
        if(is_array($array))
        {
            foreach($array as $key=>$value)
            {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }

    public function mobile()
    {
        if (!Cache::has('developers')) {
            Cache::forever('developers', User::where('role', 0)->get());
        }
        if (!Cache::has('testers')) {
            Cache::forever('testers', User::where('role', 1)->get());
        }
        $task_list = Task::where('status', '<', 3)->orderBy('task_no')->get();
        return view('task.index', ['theme' => 'default', 'tasks' => $task_list, 'developers' => Cache::get('developers'), 'testers' => Cache::get('testers')]);

    }
}
