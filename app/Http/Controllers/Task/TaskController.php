<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Solution\SolutionController;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;
use App\TaskWorkload;
use Redirect, Input, Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
//        $tasks = DB::select('SELECT a.*,CASE b.`type` when 1 then b.`name` end as dev,CASE b.`type` when 0 then b.`name` end as test from tasks a left JOIN tasks_workload b on a.id=b.task_id where a.status in (0,1,2) GROUP BY a.id desc ');

        $tasks=Task::where('status','<',3)->orderBy('task_no')->get();

        //TODO::改为缓存读取
        $developers = User::where('role',0)->get();
        $testers = User::where('role',1)->get();
        return view('task.main',['theme' => 'default','tasks' => $tasks,'developers'=>$developers,'testers'=>$testers]);
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

        //TODO::改为打开新的页面
        return json_encode($tasks,JSON_UNESCAPED_UNICODE);
//        return view('task.details',['details'=>$tasks]);
    }


    //get 测试功能方法
    public function wonder4($id)
    {
        dd(config('params.task_status'));

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
        $task->actual_finish_date=$request->input("date");
        $task->comment=$request->input("comment");
        $task->status=$request->input("status");

        //先删除
        $old_work_details =TaskWorkload::where('task_id','=',$task_id);
        $old_work_details->delete();

        //新增开发
        $work_details_dev =new TaskWorkload();
        $work_details_dev->task_id=$task->id;
        $work_details_dev->type=0;
        $work_details_dev->name=$request->input("dev");

        //新增测试
        $work_details_test =new TaskWorkload();
        $work_details_test->task_id=$task->id;
        $work_details_test->name=$request->input("test");
        $work_details_test->type=1;

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

}
