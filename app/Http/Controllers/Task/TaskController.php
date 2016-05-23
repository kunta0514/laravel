<?php

namespace App\Http\Controllers\Task;

use App\CheckPersonalize;
use App\Http\Controllers\Solution\SolutionController;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\TaskWorkload;
use Redirect, Input, Auth;
use Cache;
use Carbon\Carbon;
use DB;
use Excel;

class TaskController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (!Cache::has('developers')) {
            Cache::forever('developers', User::where('role', 0)->get());
        }
        if (!Cache::has('testers')) {
            Cache::forever('testers', User::where('role', 1)->get());
        }
        $task_list = Task::where('status', '<', 3)->orderBy('task_no')->get();
        return view('task.main', ['theme' => 'default', 'tasks' => $task_list, 'developers' => Cache::get('developers'), 'testers' => Cache::get('testers')]);

    }

    /**
     * 获取任务详情
     * @Date 2016年2月27日12:55:17
     * @Author  zhuangsd
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function get_details($id)
    {
        $task_detail = Task::find($id);
        echo '123';
        die;
        //TODO::改为打开新的页面
        return $task_detail->toArray();
//        return view('task.details',['details'=>$tasks]);
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
        (new CheckPersonalize())->get_code_lib('东方置地');
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
     * 任务指派功能
     *
     * @param  \illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $task_id=$request->input("task_id");
        $task = Task::find($task_id);
        $task->ekp_expect = $request->input("date");
        $task->comment = $request->input("comment");
        $task->status = $request->input("status");

        //先删除
        $old_work_details =TaskWorkload::where('task_id','=',$task_id);
        $old_work_details->delete();

        //新增开发
        $work_details_dev = new TaskWorkload();
        $work_details_dev->task_id = $task->id;
        $work_details_dev->type = 0;
        $work_details_dev->nick = $request->input("dev");

        //新增测试
        $work_details_test = new TaskWorkload();
        $work_details_test->task_id = $task->id;
        $work_details_test->nick = $request->input("test");
        $work_details_test->type = 1;

        if ($task->save() && $work_details_dev->save() && $work_details_test->save()) {
            return Redirect::to('task');
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！');
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
        return view('task.query', ['theme' => 'default', 'developers' => Cache::get('developers'),'tasks' => $tasks]);
    }

    //TODO:根据查询条件查询结果
    public function query_task(Request $request)
    {
        $data = [];
        //查询条件为自带
        $query = $request->input('search')['value'];
        if(!empty($query)){
            $tasks = Task::where('task_no','like',$query.'%')
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

    public function detail($id)
    {
        $developers = Cache::get('developers',function(){
            $users = DB::table('users')->select('code', 'name','role','admin')->where('role', 0)->get();
            Cache::forever('developers', $users);
        });

        $testers = Cache::get('testers',function(){
            $users = DB::table('users')->select('code', 'name','role','admin')->where('role', 1)->get();
            Cache::forever('testers', $users);
        });

        $task_detail = Task::find($id);

        //TODO::人员下拉框可以提炼组件化
        return view('task.details', ['theme' => 'default', 'task' =>  $task_detail, 'developers' => $developers, 'testers' => $testers]);
    }

    public function detail_edit(Request $request)
    {
        //按需更新

//            $task_id = $request->id;
//            $task = Task::find($task_id);
//            $task->comment = $request->comment;
//            $task->status = $request->status;
        if (!empty($request->path())) {

            $query = [];
            if(empty($request->ekp_oid)){
                $solution=new SolutionController();
                //TODO::oid保存的是herf地址，需要改造成只存OID，打开地址在配置中体现
                $query['ekp_oid'] = str_replace('\"','',$solution->view_pd($request->task_no)[0]->attr['href']);
            }
//            DB::table('tasks')->where('id', $request->id)->update(['comment' => $request->comment]);
            if(!empty($request->comment)){
                $query['comment'] = $request->comment;
            }
            if(!empty($request->status)){
                $query['status'] = $request->status;
            }
            if(!empty($request->developer)){
                $query['developer'] = $request->developer;
            }
            if(!empty($request->developer_workload)){
                $query['developer_workload'] = $request->developer_workload;
            }
            if(!empty($request->tester)){
                $query['tester'] = $request->tester;
            }
            if(!empty($request->tester_workload)){
                $query['tester_workload'] = $request->tester_workload;
            }
            if(!empty($request->actual_finish_date)){
                $query['actual_finish_date'] = $request->actual_finish_date;
            }
            print_r($query);
//            $query['developer_workload'] = $request->developer_workload;
//            $query['tester'] = $request->tester;
//            $query['tester_workload'] = $request->tester_workload;
            if(!empty($query)){
                $result = DB::transaction(function () use ($request,$query) {
                    DB::table('tasks')->where('id', $request->id)->update($query);
                });
            }
        }
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

    }

    public function test()
    {
        $query = '201601';
        $tasks = DB::table('tasks')->where('task_no','like',$query.'%')
//            ->orWhere('customer_name','like','%'.$query.'%')
            ->get();
        return view('task.test', ['theme' => 'default', 'tasks' => $tasks]);
    }

    public function history($type)
    {
        //本周、本月，本季度，上周，上月，上季度
        $tasks = null;
        $query = null;
        switch($type)
        {
            case 'year':
                $query = '2016';
                $tasks = DB::table('tasks')
//            ->where('developer_workload',0)
                    ->where('task_no','like',$query.'%')
                    ->get();
            case 'yd':
                $query = '2016';
                $tasks = DB::table('tasks')
                    ->where('abu_pm','刘嵩')
                    ->where('task_no','like',$query.'%')
                    ->orderBy('task_no','DESC')
                    ->get();

        }
//        $query = '2016';
//        $tasks = DB::table('tasks')
////            ->where('developer_workload',0)
//            ->where('task_no','like',$query.'%')
//            ->get();
        return view('task.history', ['theme' => 'default','tasks' => $tasks]);
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

    public function object_array($array)
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
}
