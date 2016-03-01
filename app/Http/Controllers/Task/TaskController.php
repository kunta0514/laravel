<?php

namespace App\Http\Controllers\Task;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;
use App\Taskload;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Array_;
use Redirect, Input, Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function index($status=2)
    {
        //使用的Laravel的blade模版,{{ $var }}会转义html语义的
//        config('params.task_status');
        //根据配置的状态选择不同的查询
        if(config('params.gander')[$status] == '全部'){
            $tasks=Task::paginate(12);
        }else{
            $tasks=Task::where('status','=',$status)->orderBy('ekp_create_date')->paginate(12);
        }
        return view('task.main',['theme' => 'default','tasks' => $tasks,'task_status'=>$status]);
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
//        echo 'no';
//        die;
        $task=Task::find($id);

//        $taskInfo=array(
//            'task'=>$task->toArray(),
////            'userlist'=>User::all(['id as key','name as text','user_type'])->toArray(),
////            'workload'=>$task->get_workloads()->get()->toArray()
//        );
        return json_encode($task,JSON_UNESCAPED_UNICODE);
//        return response()->json_encode();
    }


    public function wonder4($id)
    {

        $userList=[
            [
                'username'=>'庄少东',
                'code'=>'zhuangsd',
                'admin'=>0,
                'email'=>'zhuangsd@mysoft.com.cn',
                'password'=>'$2y$10$sbUbMp4ophCVgPZrIj/9E.rc2jlRe4vEYUF3kQouDNms07zy4oEZu',
                'user_type'=>'开发'
            ],
            [
                'username'=>'随波',
                'code'=>'suib',
                'admin'=>0,
                'email'=>'suib@mysoft.com.cn',
                'password'=>'$2y$10$sbUbMp4ophCVgPZrIj/9E.rc2jlRe4vEYUF3kQouDNms07zy4oEZu',//123456
                'user_type'=>'测试'
            ],
            [
                'username'=>'荆逢森',
                'code'=>'jinfs',
                'admin'=>0,
                'email'=>'jinfs@mysoft.com.cn',
                'password'=>'$2y$10$sbUbMp4ophCVgPZrIj/9E.rc2jlRe4vEYUF3kQouDNms07zy4oEZu',//123456
                'user_type'=>'测试'
            ],
            [
                'username'=>'季家龙',
                'code'=>'jijl',
                'admin'=>0,
                'email'=>'jijl@mysoft.com.cn',
                'password'=>'$2y$10$sbUbMp4ophCVgPZrIj/9E.rc2jlRe4vEYUF3kQouDNms07zy4oEZu',
                'user_type'=>'开发'
            ],
            [
                'username'=>'沈金龙',
                'code'=>'shenjl',
                'admin'=>0,
                'email'=>'shenjl@mysoft.com.cn',
                'password'=>'$2y$10$sbUbMp4ophCVgPZrIj/9E.rc2jlRe4vEYUF3kQouDNms07zy4oEZu',
                'user_type'=>'开发'
            ],

        ];


        DB::table('users')->truncate();

        foreach($userList as $k=>$val)
        {
            User::create([
                'name' => $val['username'],
                'code' => $val['code'],
                'admin' => $val['admin'],
                'email' => $val['email'],
                'password' => $val['password'],
                'user_type' => $val['user_type'],
            ]);
        }
        echo '用户初始化成功！';
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id task_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $taskid=$request->input("task_id");
        $task = Task::find($taskid);
        $task->ekp_expect=$request->input("task_deadline");
        $task->status=$request->input('sel_task_status');
        $task->comment=$request->input("remark");
        //先删除
        $oldworkload =Taskload::where('task_id','=',$taskid);
        $oldworkload->delete();

        //新增开发
        $workload_dev =new Taskload();
        $workload_dev->task_id=$task->id;
        $workload_dev->task_no=$task->task_no;
        $workload_dev->task_type=$task->task_type;
        $workload_dev->user_id=$request->input("sel_dev_id");
        $workload_dev->user_name=$request->input("sel_dev_name");
        $workload_dev->work_type='开发';

        //新增测试
        $workload_test =new Taskload();
        $workload_test->task_id=$task->id;
        $workload_test->task_no=$task->task_no;
        $workload_test->task_type=$task->task_type;
        $workload_test->user_id=$request->input("sel_test_id");
        $workload_test->user_name=$request->input("sel_test_name");
        $workload_test->work_type='测试';

        $tab_index=($request->input('task_status'))?$request->input('task_status'):'1';

        if ($task->save() && $workload_dev->save() && $workload_test->save()) {
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
