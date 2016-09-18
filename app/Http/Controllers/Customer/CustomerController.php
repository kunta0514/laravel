<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Cache;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Cache::pull('customer');
        $customers = Cache::get('customer',function(){
            $customer = Customer::all();
            Cache::forever('customer', $customer);
            return   $customer;
        });
//        print_r($customers);
//        die;
        return view('customer.main',['theme' => 'default','customer'=>$customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        Cache::pull('customer');
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
        $customer = null;
        if(!empty($id)){
            $customer = Customer::find($id);

            $customer_details = DB::table('customer_details')->where('customer_uuid',$customer->uuid)->get();
        }
//        print_r($customer);
        return view('customer.edit',['theme'=>'default','customer'=>$customer, 'customer_details' => $customer_details]);
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
        if (!empty($request->path()) && !empty($id)) {
            $query = [];
            if(!empty($request->ekp_latest_name)){
                $query['ekp_latest_name'] = $request->ekp_latest_name;
            }
            if(!empty($request->ekp_code)){
                $query['ekp_code'] = $request->ekp_code;
            }
            if(!empty($request->area)){
                $query['area'] = $request->area;
            }

            if(!empty($request->is_standard)){
                $query['is_standard'] = $request->is_standard;
            }
            if(!empty($request->is_update)){
                $query['is_update'] = $request->is_update;
            }
            if(!empty($request->is_aop)){
                $query['is_aop'] = $request->is_aop;
            }
            if(!empty($request->update_type_standard)){
                $query['update_type_standard'] = $request->update_type_standard;
            }
            if(!empty($request->update_type_standard)){
                $query['update_reason'] = $request->update_reason;
            }
            if(!empty($request->level)|| $request->level == 0){
                $query['level'] = $request->level;
            }
            if(!empty($query)){
                $result = DB::transaction(function () use ($id,$query) {
                    DB::table('customers')->where('id', $id)->update($query);
                });
            }
        }
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

    public function test()
    {
        $a = [
            [
                "id"=> "WF_PLDownload",
                "parentnode" => "/configuration/system.web/httpHandlers/add",
                "info" => [
                    "path" => "WF_PLDownload.ashx",
                    "type" => "MyWorkflow.WF_PLDownLoad, MyWorkflow",
                    "verb" => "*"
                ]
            ],
            [
                "id"=> "WF_SilverLightUploder",
                "parentnode" => "/configuration/system.web/httpHandlers/add",
                "info" => [
                    "path" => "/MyWorkflow/*/WF_SilverLightUploder.ashx",
                    "type" => "MyWorkflow.WF_SilverLightUploder, MyWorkflow",
                    "verb" => "*"
                ]
            ]
        ];

        print_r(json_encode($a,JSON_UNESCAPED_UNICODE));

//        return view('customer.test',['theme'=>'default']);
    }
}
