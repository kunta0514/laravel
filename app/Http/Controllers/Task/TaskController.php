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
        //TODO::改为打开新的页面
        return json_encode($task_detail, JSON_UNESCAPED_UNICODE);
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
        return view('task.query', ['theme' => 'default', 'developers' => Cache::get('developers'),'tasks' => $tasks]);
    }

    //TODO:根据查询条件查询结果
    public function query_task(Request $request)
    {
//        $draw = 1;
//        $recordsTotal = 1;
//        $recordsFiltered = 1;
//        $tasks = Task::where('status', '<', 3)->take(10)->get();
//        print_r($tasks);
//        die;
//        $data = $tasks->toArray();
        $data = [];
//        //查询条件为自带
        $query = $request->input('search')['value'];
        if(!empty($query)){
            $tasks = Task::where('task_no','=',$query)
                ->orWhere('customer_name','like',$query)
                ->get();
//            $tasks = DB::select("select t.*,max(case when tw.type = 0 then tw.name end) as dev,max(case when tw.type = 1 then tw.name end) as test from tasks t left join tasks_workload tw on t.id = tw.task_id  where t.task_no = '$query' or t.customer_name like '%$query%' GROUP BY t.id ");

//            print_r($tasks);
//            die;
            if(!empty($tasks)){
                $data = $tasks->toArray();
//                $draw = 1;
//                $recordsTotal = count($data);
//                $recordsFiltered = $recordsTotal;
            }
        }

        $ret=[
            //'draw' => $draw,
//            'recordsTotal' => $recordsTotal,
//            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ];
        return json_encode($ret,JSON_UNESCAPED_UNICODE);
    }

    public function detail($id)
    {
//        Cache::forget('developers');
        if (!Cache::has('developers')) {
            Cache::forever('developers', User::where('role', 0)->get());
        }
        if (!Cache::has('testers')) {
            Cache::forever('testers', User::where('role', 1)->get());
        }
//        $task_detail =  DB::select("select t.*,max(case when tw.type = 0 then tw.name end) as dev,max(case when tw.type = 1 then tw.name end) as test from tasks t left join tasks_workload tw on t.id = tw.task_id  where t.id = $id  GROUP BY t.id ");
//        $task_detail2 = Task::find($id);
//        var_dump($task_detail[0]);
//
//        print_r('<br>');
//        print_r('<br>');
//
//        print_r( $task_detail[0]->task_title);
//        print_r( $task_detail[0]->comment);
//        print_r('<br>');
//        print_r('<br>');
//        var_dump($task_detail2);
//        print_r(Task::find($id)->toSql());
        $task_detail = Task::find($id);

        return view('task.details', ['theme' => 'default', 'task' =>  $task_detail, 'developers' => Cache::get('developers'), 'testers' => Cache::get('testers')]);

    }

    public function detail_edit(Request $request)
    {
        //按需更新

//            $task_id = $request->id;
//            $task = Task::find($task_id);
//            $task->comment = $request->comment;
//            $task->status = $request->status;
        if (!empty($request->path())) {
//            DB::table('tasks')->where('id', $request->id)->update(['comment' => $request->comment]);
            $result = DB::transaction(function () use ($request) {
                DB::table('tasks')->where('id', $request->id)->update(['comment' => $request->comment,'status' => $request->status]);
            });
        }
    }
}
