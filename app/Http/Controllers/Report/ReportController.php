<?php

namespace App\Http\Controllers\Report;

use App\Models\Task;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type='top10')
    {
        switch($type) {
            case 'top10':
             $task_data = DB::select('select customer_name cname,count(1) ttotal,SUM(isabubug) abubug,SUM(isselfbug) selfbug,SUM(isdemand) demand from (
                     select task_no,customer_name,case task_type when \'项目BUG\' then 1 else 0 end as isabubug,case task_type when \'产品BUG\' then 1 else 0 end as isselfbug, case task_type when \'需求\' then 1 else 0 end as isdemand
                    from tasks ) a WHERE task_no like \'2016%\' GROUP BY customer_name ORDER BY COUNT(1) desc LIMIT 0,10');
               break;
        }
        $page_data = array('data' =>
            (!isset($task_data))?null:$task_data,
        );
        return view('report.top10',['theme' => 'default','page_data'=>json_encode($page_data)]);
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
}
