<?php

namespace App\Http\Controllers\TaskPanel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TaskPanel;

class TaskPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $task_panel="Hello World";
        return view('taskpanel.main', ['theme' => 'default', 'task_panel' => $task_panel]);
    }

    /**
     *
     */
    public function get_personal_page()
    {
        return view('taskpanel.personal',['theme' => 'default']);
    }

    public function get_all_info()
    {
        $obj = new TaskPanel();
        $tasks = $obj->get_all_info();
        //var_dump($tasks);
        return $tasks;
    }

    public function get_personal_info($id)
    {
        $obj=new TaskPanel();
        $tasks=$obj->get_personal_info($id);
        return $tasks;
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
