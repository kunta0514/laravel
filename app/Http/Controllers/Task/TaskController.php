<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Solution\SolutionController;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Redirect, Input, Auth;
use Cache;
use DB;

class TaskController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (!Cache::has('developers')) {
            Cache::forever('developers', User::where('role', 0)->lists('name','code')->toArray());
        }
        if (!Cache::has('testers')) {
            Cache::forever('testers', User::where('role', 1)->lists('name','code')->toArray());
        }
        $task_list = Task::where('status', '<', 3)->orderBy('task_no')->get();
        return view('task.main', ['theme' => 'default', 'tasks' => $task_list, 'developers' => Cache::get('developers'), 'testers' => Cache::get('testers')]);
    }

    //get 测试功能方法
    public function wonder4()
    {
        dd(Task::find(2917)->toArray());
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
//        dd($task);die;
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
        return view('task.query',['theme' => 'default']);
    }

    //TODO:根据查询条件查询结果
    public function query_task(Request $request)
    {
        $data = [];
        //查询条件为自带
        $query = $request->input('search')['value'];
        if(!empty($query)){
            $tasks = Task::where('task_no','=',$query.'%')
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

    /**
     * 获取任务详情
     * @Date 2016年5月6日21:25:26
     * @Author  wank
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        if (!Cache::has('developers')) {
            Cache::forever('developers', User::where('role', 0)->lists('name','code')->toArray());
        }
        if (!Cache::has('testers')) {
            Cache::forever('testers', User::where('role', 1)->lists('name','code')->toArray());
        }

        $task_detail = Task::find($id);

        $task_detail->package_name=$task_detail->build_package_name();

        return view('task.details', ['theme' => 'default', 'task' =>  $task_detail, 'developers' => Cache::get('developers'), 'testers' => Cache::get('testers')]);

    }


    /**
     * 功能：***
     * Date:2016年5月9日16:49:58
     * @param Request $request
     */
    public function detail_edit(Request $request)
    {
        if (!empty($request->path())) {
            $result = DB::transaction(function () use ($request) {
                DB::table('tasks')->where('id', $request->id)->update(['tester'=>$request->tester,'developer'=>$request->developer,'status'=>$request->status,'comment' => $request->comment,'status' => $request->status]);
            });
        }
    }

    public function test_page()
    {
        $query = '20160330-1606';
        $tasks = DB::table('tasks')->where('task_no','like',$query.'%')
            ->orWhere('customer_name','like','%'.$query.'%')
            ->get();

        var_dump($tasks);

//        $tasks = Task::where('task_no','=',$query.'%')
//            ->orWhere('customer_name','like','%'.$query.'%')
//            ->get();
//            $tasks = DB::select("select t.*,max(case when tw.type = 0 then tw.name end) as dev,max(case when tw.type = 1 then tw.name end) as test from tasks t left join tasks_workload tw on t.id = tw.task_id  where t.task_no = '$query' or t.customer_name like '%$query%' GROUP BY t.id ");
//            $queries = DB::getQueryLog();
//            print_r($queries);
//            print_r($tasks);
//            die;
        return view('task.test', ['theme' => 'default', 'developers' => Cache::get('developers'),'tasks' => $tasks]);
    }

    public function test()
    {
        $query = '20160301-0004';
        $tasks = DB::table('tasks')->where('task_no','like',$query.'%')
            ->orWhere('customer_name','like','%'.$query.'%')
            ->get();
            // dd(Cache::get('developers')['zhuangsd']);die;
            // dd($tasks);die;
            foreach ($tasks as $key => $value) {
               $value->dev_name=Cache::get('developers')[$value->developer];
               $value->tester_name=Cache::get('testers')[$value->tester];
            }
//        $queries = DB::getQueryLog();
//        print_r($queries);
        return view('task.test', ['theme' => 'default', 'developers' => Cache::get('developers'),'tasks' => $tasks]);
    }
}
