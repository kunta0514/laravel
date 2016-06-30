<?php

namespace App\Http\Controllers\Demand;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Demand;
use App\Models\Task;
use App\Models\Serial;
use DB;
use Cache;
use Log;

class DemandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_data=array(
            'task_status'=>Config('params.task_status'),
        );
        return view('demand.main', ['theme' => 'default','page_data'=>json_encode($page_data,JSON_UNESCAPED_UNICODE)]);
    }

    public function get_todoList()
    {
        $demands = Demand::where('id','>',0)->get();
        return json_encode(Array('data'=>$demands->toArray()));
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
        if (!empty($request->path())){
            $demand = new Demand();
            //需求编号需要一个生成规则，日期+流水号
//            $demand_no = date("Ymd",strtotime("now")).'-'.'A'.'001';

            $cur_serial_key = date("Ymd", strtotime("now"));
            $cur_serial = DB::table('serial')->where('serial_key',$cur_serial_key )->get();
            if(empty($cur_serial)){
                $serial = new Serial();
                $serial->serial_key = date("Ymd",strtotime("now"));
                $serial->serial_value = 1;
                $serial->save();
                $demand_no = date("Ymd",strtotime("now")).'-'.'A'.'001';
            }else{
                $cur_serial_value = $cur_serial[0]->serial_value + 1;
                if ($cur_serial_value < 10) {
                    $cur_serial_value_str = 'A00' . $cur_serial_value;
                }
                if ($cur_serial_value >= 10 && $cur_serial_value < 100) {
                    $cur_serial_value_str = 'A0' . $cur_serial_value;
                }
                if ($cur_serial_value > 100) {
                    $cur_serial_value_str = 'A' . $cur_serial_value;
                }
                $demand_no = $cur_serial[0]->serial_key.'-'.$cur_serial_value_str;
                Serial::where('id', $cur_serial[0]->id)
                    ->update(['serial_value' => $cur_serial_value]);
            }

            $demand->demand_no = $demand_no;
            $demand->demand_name = $request->demand_name;
            $demand->acceptance = $request->acceptance;
            $demand->comment = $request->comment;
            $demand->status = $request->status;
//            print_r($demand->toArray());
//            Log::info('执行'.time());
            $demand->save();
            return $demand->toJson();
//            die;
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
        if (!empty($request->path()) && !empty($id)) {
            $query = [];
            if(!empty($request->demand_name)){
                $query['demand_name'] = $request->demand_name;
            }
            if(!empty($request->acceptance)){
                $query['acceptance'] = $request->acceptance;
            }
            if(!empty($request->comment)){
                $query['comment'] = $request->comment;
            }
            if(!empty($request->status)){
                $query['status'] = $request->status;
            }
            if(!empty($query)){
                $result = DB::transaction(function () use ($id,$query) {
                    DB::table('demands')->where('id', $id)->update($query);
                });
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //
        $demand = new Demand();
        $demand_no = 'test4';
        $demand_name = 'test4';
        $demand->demand_no = $demand_no;
        $demand->demand_name = $demand_name;
//            print_r($demand->toArray());
//            Log::info('执行'.$cur_serial_value);
        $demand->save();
        Log::info('测试执行执行'.time());
//        return $demand;
    }

    public function test()
    {
        return view('demand.test', ['theme' => 'default']);
    }
}
