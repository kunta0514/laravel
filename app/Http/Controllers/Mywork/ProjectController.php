<?php

namespace App\Http\Controllers\Mywork;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use DB;

class ProjectController extends Controller
{
    /**
     * 单个扫描整个目录，直到找到为止
     * @param $dir 扫描地址
     */
    public function scan_dir($dir,&$file_array)
    {
        $array = scandir($dir);
        foreach ($array as $val){
            if($val!="." && $val!=".." && is_dir($dir."\\".$val)){
                $this->scan_dir($dir."\\".$val,$file_array);
            }
            else{
                if($val == 'AssemblyInfo.vb')
                {
                    $file_array[] = $dir."\\".$val;
                }
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result = DB::select('select * from projects where assemblyInfo = ?',['']);
//        $result = Project::where('assemblyInfo','=',null);
//        print_r($result);
        foreach($result as $project)
        {
            $x = [];
            $path = $project->path;
            //中文目录必须要转码
            $path = iconv("utf-8","gb2312//IGNORE",$path);
            $this->scan_dir($path,$x);
            print_r($x);
            die;
        }
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
