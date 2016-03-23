<?php

namespace App\Http\Controllers\TaskPanel;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TaskPanel;
use App\TaskWorkload;
use App\Task;
use Redirect, Input, Auth;

class TaskPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $taskpanel;

    public function __construct()
    {
        $this->taskpanel = new TaskPanel();
    }

    public function index()
    {
        //处理中&已完成
        $tasks = array(
            'tasks_ing' => $this->taskpanel->get_task_all(),
            'tasks_done' => $this->taskpanel->get_task_done()
        );

        //开发&测试
        $users = array(
            'developers' => $this->taskpanel->get_dev_all(),
            'testers' => $this->taskpanel->get_test_all()
        );

        return view('taskpanel.main', ['theme' => 'default', 'tasks' => $tasks, 'users' => $users]);
    }

    public function get_personal_page()
    {
        return view('taskpanel.personal',['theme' => 'default']);
    }

    public function get_all_info()
    {
//        $tasks = $this->taskpanel->get_all_info();
//        return $tasks;
    }

    public function get_personal_info($id)
    {
//        $tasks=$this->taskpanel->get_personal_info($id);
//        return $tasks;
    }

    /**获取任务详情
     * @param $id
     * @return string
     */
    public function get_detail($id)
    {
        $task_detail=$this->taskpanel->get_detail($id);
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

        $task=Task::find($id);

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
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

//        var_dump($_POST);
        $task_id = $_POST["task_id"];
        $task = Task::find($task_id);
        $task->actual_finish_date = $_POST["date"];
        $task->comment = $_POST["comment"];
        $task->priority = $_POST["priority"];

//        var_dump($task->priority);
//        var_dump($_POST["priority"]);

        //先删除
        $old_work_details =TaskWorkload::where('task_id','=',$task_id);
        $old_work_details->delete();

        //新增开发
        $work_details_dev =new TaskWorkload();
        $work_details_dev->task_id=$task->id;
        $work_details_dev->type=0;
        $work_details_dev->name=$_POST["dev"];

        //新增测试
        $work_details_test =new TaskWorkload();
        $work_details_test->task_id=$task->id;
        $work_details_test->name=$_POST["test"];
        $work_details_test->type=1;

        if ($task->save() && $work_details_dev->save() && $work_details_test->save()) {
            return Redirect::to('task_panel');
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
}
