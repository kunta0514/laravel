<?php

namespace App\Http\Controllers\Demand;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Demand;
use App\Models\Task;

class DemandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $demands = Demand::where('id','>',0)->get();
        $task = Task::where('status', '<', 3)->orderBy('task_no')->get();

        return view('demand.main', ['theme' => 'default', 'demands' => $demands, 'tasks' =>$task]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
//        $demand = Demand::where('id',0)->get();
//        print_r($demand);
//        die;
        return view('demand.create', ['theme' => 'default']);
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
        if (!empty($request->path())){
            $demand = new Demand();
            if(empty($request->demand_name)){
//                $query['demand_name'] = $request->demand_name;
                $demand->demand_name = $request->demand_name;
            }
            if(empty($request->acceptance)){
//                $query['acceptance'] = $request->acceptance;
                $demand->acceptance = $request->acceptance;
            }
            if(empty($request->comment)){
//                $query['comment'] = $request->comment;
                $demand->comment = $request->comment;
            }
            //需求编号需要一个生成规则，日期+流水号
            $demand_no = date("Ymd",strtotime("now")).'-'.'A'.'001';

            $demand_no = Cache::get('serial',function(){
                $serial = [];
                $cur_serial_key = date("Ymd",strtotime("now"));
                $count = 1;
                $serial[$cur_serial_key] = $count;
                Cache::forever('serial', $serial);
            });

            $demand->demand_no = $demand_no;
            $demand->save();

        }
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
    public function edit($id)
    {
        //
        $demand = Demand::find($id);
        return view('demand.edit', ['theme' => 'default','demand' => $demand]);
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
}
