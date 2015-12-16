<?php

namespace App\Http\Controllers\Mywork;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use App\Workflow;
use DB;

class ProjectController extends Controller
{
    /**
     * @param $dir 文件目录
     */
    protected function scan_dir_all($dir,$target_filename,&$file_array)
    {
        $array = scandir($dir);
        if(is_array($array) && count($array) > 2){
            //去掉数组中的.、..2个目录
            array_shift($array);
            array_shift($array);
            foreach ($array as $val){
                $cur_dir=$dir.DIRECTORY_SEPARATOR.$val;
                if(is_dir($cur_dir)){
                    //如果找到MyWorkflow，则寻找其下的AssemblyInfo.vb或My Project下的AssemblyInfo.vb
                    if($val == 'MyWorkflow'){
                        //1、MyWorkflow下存在AssemblyInfo.vb
                        if(is_file($cur_dir.DIRECTORY_SEPARATOR.$target_filename)) {
                            $file_array['dir'] = $cur_dir;
                            $file_array['file'] = $cur_dir.DIRECTORY_SEPARATOR.$target_filename;
                        }
                        //2、MyWorkflow下存在My Project，并存在AssemblyInfo.vb
                        if(is_file($cur_dir.DIRECTORY_SEPARATOR.'My Project'.DIRECTORY_SEPARATOR.$target_filename)) {
                            $file_array['dir'] = $cur_dir.DIRECTORY_SEPARATOR.'My Project';
                            $file_array['file'] = $cur_dir.DIRECTORY_SEPARATOR.'My Project'.DIRECTORY_SEPARATOR.$target_filename;
                        }

                    }

                    $this->scan_dir_all($cur_dir,$target_filename,$file_array);
                }
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $target_filename = 'AssemblyInfo.vb';

    public function index()
    {
        //
//        $result = DB::select('select * from projects where assemblyInfo = ?',['']);
//        $result = Project::where('assemblyInfo','=',null);
//        print_r($result);
//        $dir = 'F:\Project\安徽金大地';
//        $dir = iconv("utf-8","gb2312//IGNORE",$dir);
//        $file_array = [];
//        $this->scan_dir_all($dir,$this->target_filename,$file_array);
//
//        print_r($file_array);

        $projects = Project::where('id','>','0')->where('id','<','5')->get();

        foreach($projects as $project)
        {
//            print_r($project);
            //$project->path 为更新条件
            $dir = $project->path;
            $dir = iconv("utf-8","gb2312//IGNORE",$dir);
            $file_array = [];
            $this->scan_dir_all($dir,$this->target_filename,$file_array);
            //print_r($file_array);
            if(!empty($file_array)){
                $workflow = new Workflow();
                $workflow->project_name = $project->name;
                $workflow->path = $project->path;
                $workflow->workflow_path = iconv('gbk','utf-8',$file_array['dir']);
                $workflow->assemblyInfo_path = iconv('gbk','utf-8',$file_array['file']);
                $workflow->save();
            }


        }


//        foreach($result as $project)
//        {
//            //$project->path 为更新条件
//            $dir = $project->path;
//            $dir = iconv("utf-8","gb2312//IGNORE",$dir);
//            $file_array = [];
//            $this->scan_dir_all($dir,$this->target_filename,$file_array);
//
//            $workflow = new Workflow();
//            $workflow->project_name = $project->name;
//            $workflow->path = $project->path;
//            $workflow->workflow_path = $file_array['dir'];
//            $workflow->assemblyInfo_path = $file_array['file'];
//            $workflow->save();
//
////            if(!empty($file_array)) {
////                foreach($file_array as $k=>$val){
////
////                }
////            }
//
//
//        }
//        print_r($result);
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
