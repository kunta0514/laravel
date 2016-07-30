<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Task;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $this->task_report('week');
        $type = 'week';
        $query_begin = null;
        $query_end = null;
        switch($type){
            case 'month':
                $query_begin = date("Y-m-d",mktime(0,0,0,date("m")-1,1,date("Y")));
                $query_end = date("Y-m-d ",mktime(0,0,0,date("m")+1,1,date("Y")));
                break;
            case 'week':
                $query_begin = date("Y-m-d",strtotime("-1 week Monday"));
                $query_end = date("Y-m-d",strtotime("+0 week Monday"));
                break;
        }
        $tasks_sum = DB::table('tasks')->select(DB::raw('sum(case when status = 0 then 1 ELSE 0 end) as todo'),DB::raw('sum(case when status = 1 then 1 ELSE 0 end) as deving'),DB::raw('sum(case when status = 2 then 1 ELSE 0 end) as testing'),DB::raw('sum(case when status > 2 then 1 ELSE 0 end) as over'))
            ->where('ekp_create_date','>',$query_begin)->first();

        //TODO:这里的条件，在团队数据和个人数据中是不一样的，团队的用actual_finish_date，个人的用dev、test_end_date
        $tasks_workload_sum =  DB::table('tasks')->select(DB::raw('sum(developer_workload) as developer_workload_all'),DB::raw('sum(tester_workload) as tester_workload_all'))
            ->where('actual_finish_date','>',$query_begin)->where('actual_finish_date','<',$query_end)
            ->first();
        $task_details = Task::where('actual_finish_date','>',$query_begin)
            ->where('actual_finish_date','<',$query_end)
            ->get();
        return view('report.main',['theme' => 'default','tasks_sum'=>$tasks_sum,'tasks_workload_sum'=>$tasks_workload_sum,'task_details'=>$task_details]);
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
    public function edit($id)
    {
        //
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

    public function task_report_end_($type)
    {



    }

    protected function task_report($type)
    {
        $query_begin = null;
        $query_end = null;
        switch($type){
            case 'month':
                $query_begin = date("Y-m-d",mktime(0,0,0,date("m")-1,1,date("Y")));
                $query_end = date("Y-m-d ",mktime(0,0,0,date("m")+1,1,date("Y")));
                break;
            case 'week':
                $query_begin = date("Y-m-d",strtotime("-1 week Monday"));
                $query_end = date("Y-m-d",strtotime("+0 week Monday"));
                break;
        }
        $tasks_sum = DB::table('tasks')->select(DB::raw('sum(case when status = 0 then 1 ELSE 0 end) as todo'),DB::raw('sum(case when status = 1 then 1 ELSE 0 end) as deving'),DB::raw('sum(case when status = 2 then 1 ELSE 0 end) as testing'),DB::raw('sum(case when status > 2 then 1 ELSE 0 end) as over'))
            ->where('ekp_create_date','>',$query_begin)->get();


        //TODO:这里的条件，在团队数据和个人数据中是不一样的，团队的用actual_finish_date，个人的用dev、test_end_date

        $tasks_workload_sum =  DB::table('tasks')->select(DB::raw('sum(developer_workload) as developer_workload_all'),DB::raw('sum(developer_workload) as developer_workload_all'),DB::raw('sum(tester_workload) as tester_workload_all'))
            ->where('actual_finish_date','>',$query_begin)->where('actual_finish_date','<',$query_end)
            ->get();


        $tasks_detail = Task::where('actual_finish_date','>',$query_begin)
                ->where('actual_finish_date','<',$query_end)
                ->get()->toArray();
        return view('report.main',['theme' => 'default','tasks_sum'=>$tasks_sum,'tasks_workload_sum'=>$tasks_workload_sum,'tasks_detail'=>$tasks_detail]);
    }
}
