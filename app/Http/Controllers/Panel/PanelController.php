<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Panel;
use App\TaskWorkload;
use App\User;
use Redirect, Input, Auth;

class PanelController extends Controller
{

//region 初始化

    private $panel;

    //构造函数
    public function __construct()
    {
        $this->panel = new Panel();
    }

//endregion

//region 获取视图

    //主页
    public function index()
    {
        //处理中&已完成
        $tasks = array(
            'tasks_ing' => Panel::where('status', '<', '3')->get(),
            'tasks_done' => Panel::where('status', '=', '3')->orderBy('actual_finish_date', 'desc')->take(5)->get()
        );
//        dd($tasks);
//        die;
        //TODO:可以放到点击详情的函数里面
        //开发&测试
        $users = array(
            'developers' => User::where('role', 0)->get(),
            'testers' => User::where('role', 1)->get()
        );

        return view('panel.main', ['theme' => 'default', 'tasks' => $tasks, 'users' => $users]);
    }

    //我的任务
    public function get_my_task_page()
    {
        return view('panel.my_task',['theme' => 'default']);
    }

    //个人视图
    public function get_personal_page()
    {
        return view('panel.personal', ['theme' => 'default']);
    }

//endregion

//region 异步取数

    /**获取任务详情
     * @param $id
     * @return string
     */
    public function get_detail($id)
    {
        $task_detail = Panel::find($id);
        return $task_detail;
    }


    /**快速操作
     * @param $id 任务ID
     * @return bool|string
     */
    public function fast_handle($id)
    {

        $key=$_GET["key"];
        $value=$_GET["value"];

        if($key==null||$key==""||$key=="id")
        {
            return 'false';
        }

        $task=Panel::find($id);

        if($task!=null)
        {
            $task->$key =$value;
        }
        else
        {
            return 'false';
        }
        return ($task->save()) ? 'ok':'false';
    }

//endregion

//region 增删改查

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $task_id = $_POST["task_id"];
        $task = Panel::find($task_id);
        $task->expect_finish_date = $_POST["date"];
        $task->comment = $_POST["comment"];
        $task->priority = $_POST["priority"];

        //先删除
        $old_work_details = TaskWorkload::where('task_id', '=', $task_id);
        $old_work_details->delete();

        //新增开发
        $work_details_dev = new TaskWorkload();
        $work_details_dev->task_id = $task->id;
        $work_details_dev->type = 0;
        $work_details_dev->name = $_POST["dev"];

        //新增测试
        $work_details_test = new TaskWorkload();
        $work_details_test->task_id = $task->id;
        $work_details_test->name = $_POST["test"];
        $work_details_test->type = 1;

        if ($task->save() && $work_details_dev->save() && $work_details_test->save()) {
            return Redirect::to('panel');
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！');
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**完成任务
     *
     */
    public function done($id)
    {
        $task = Panel::find($id);
        if(date_default_timezone_get() != "prc") date_default_timezone_set("prc");
        $task->actual_finish_date = date('y-m-d H:i:s',time());
        $task->status = "3";

        if ($task->save()) {
            return Redirect::to('panel');
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！');
        }
    }
//endregion

}