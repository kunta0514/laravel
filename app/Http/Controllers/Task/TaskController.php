<?php

namespace App\Http\Controllers\Task;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;
use App\TaskDetail;
use Redirect, Input, Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function index($status=2)
    {
//        if(config('params.task_tabs')[$status] == '全部'){
//            $tasks=Task::paginate(12);
////            $tasks=DB::select('SELECT a.*,CASE b.work_type when 0 then user_name end as dev,CASE b.work_type when 1 then user_name end as testor from tasks a left JOIN task_details b on a.id=b.task_id where status = ? GROUP BY id',[$status]);
//        }elseif(config('params.task_tabs')[$status] == '进行中'){
////            $tasks=DB::select('SELECT a.*,CASE b.work_type when 0 then user_name end as dev,CASE b.work_type when 1 then user_name end as testor from tasks a left JOIN task_details b on a.id=b.task_id where status = ? GROUP BY id ORDER BY ekp_create_date',[$status]);
////            dd(config('params.task_status'));die;
//            $tasks=Task::whereIn('status',[1,2])->orderBy('ekp_create_date')->paginate(12);
//        }else
//        {
//            $tasks=Task::where('status','=',$status)->orderBy('ekp_create_date')->paginate(12);
//        }
////        dd($tasks);die;

        $tasks = DB::select('SELECT a.*,CASE b.`type` when 0 then b.`name` end as dev,CASE b.`type` when 1 then b.`name` end as test from tasks a left JOIN tasks_workload b on a.id=b.task_id where a.status in (0,1,2) GROUP BY a.id desc ');

        //TODO::改为缓存读取
        $developers = User::where('role',1)->get();
        $testers = User::where('role',2)->get();
        return view('task.main',['theme' => 'default','tasks' => $tasks,'task_status'=>$status,'developers'=>$developers,'testers'=>$testers]);
    }

    /**
     * 获取任务详情
     *2016年2月27日12:55:17
     * @Author  zhuangsd
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function get_details($id)
    {

        $tasks = DB::select('SELECT a.*,CASE b.`type` when 0 then b.`name` end as dev,CASE b.`type` when 1 then b.`name` end as test from tasks a left JOIN tasks_workload b on a.id=b.task_id where a.id=:id GROUP BY a.id desc ',[$id]);

//        print_r($tasks);
//        $task=Task::find($id);

//        $taskInfo=array(
//            'task'=>$task->toArray(),
//            'user_list'=>User::all(['id as key','name as text','user_role'])->toArray(),
//            'workload'=>$task->get_workloads()->get()->toArray()
//        );
        return json_encode($tasks,JSON_UNESCAPED_UNICODE);
    }


    //get 测试功能方法
    public function wonder4($id)
    {
        dd(config('params.task_status'));

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
//        $this->validate($request, [
//            'title' => 'required|unique:pages,title|max:255',
//            'body' => 'required',
//        ]);
//        var_dump($request);
        echo "ok";
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
     * 任务指派功能
     *
     * @param  \illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $task_id=$request->input("task_id");
        $task = Task::find($task_id);
        $task->ekp_expect=$request->input("task_deadline");
        $task->status=$request->input('sel_task_status');
        $task->comment=$request->input("remark");
        //先删除
        $old_work_details =TaskDetail::where('task_id','=',$task_id);
        $old_work_details->delete();

        //新增开发
        $work_details_dev =new TaskDetail();
        $work_details_dev->task_id=$task->id;
        $work_details_dev->task_type=$task->task_type;
        $work_details_dev->user_id=$request->input("sel_dev_id");
        $work_details_dev->user_name=$request->input("sel_dev_name");
        $work_details_dev->work_type=1;

        //新增测试
        $work_details_test =new TaskDetail();
        $work_details_test->task_id=$task->id;
        $work_details_test->task_type=$task->task_type;
        $work_details_test->user_id=$request->input("sel_test_id");
        $work_details_test->user_name=$request->input("sel_test_name");
        $work_details_test->work_type=0;

        $tab_index=($request->input('task_status'))?$request->input('task_status'):'1';

        if ($task->save() && $work_details_dev->save() && $work_details_test->save()) {
            return Redirect::to('task/'.$tab_index);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！');
        }
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
}
