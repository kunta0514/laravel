<?php

namespace App\Http\Controllers\Mywork;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WorkController extends Controller
{

//    /**
//     * 取得输入目录所包含的所有目录和文件
//     * 以关联数组形式返回
//     * author: flynetcn
//     */
//    function deepScanDir($dir)
//    {
//        $fileArr = array();
//        $dirArr = array();
//        $dir = rtrim($dir, '//');
//        if(is_dir($dir)){
//            $dirHandle = opendir($dir);
//            while(false !== ($fileName = readdir($dirHandle))){
//                $subFile = $dir . DIRECTORY_SEPARATOR . $fileName;
//                if(is_file($subFile)){
//                    $fileArr[] = $subFile;
//                } elseif (is_dir($subFile) && str_replace('.', '', $fileName)!=''){
//                    $dirArr[] = $subFile;
//                    $arr = $this->deepScanDir($subFile);
//                    $dirArr = array_merge($dirArr, $arr['dir']);
//                    $fileArr = array_merge($fileArr, $arr['file']);
//                }
//            }
//            closedir($dirHandle);
//        }
//        return array('dir'=>$dirArr, 'file'=>$fileArr);
//    }
//
//    /**
//     * 取得输入目录所包含的所有文件
//     * 以数组形式返回
//     * author: flynetcn
//     */
//    function get_dir_files($dir)
//    {
//        if (is_file($dir)) {
//            return array($dir);
//        }
//        $files = array();
//        if (is_dir($dir) && ($dir_p = opendir($dir))) {
//            $ds = DIRECTORY_SEPARATOR;
//            while (($filename = readdir($dir_p)) !== false) {
//                if ($filename=='.' || $filename=='..') { continue; }
//                $filetype = filetype($dir.$ds.$filename);
//                if ($filetype == 'dir') {
//                    $files = array_merge($files, get_dir_files($dir.$ds.$filename));
//                } elseif ($filetype == 'file') {
//                    $files[] = $dir.$ds.$filename;
//                }
//            }
//            closedir($dir_p);
//        }
//        return $files;
//    }

    var $wfArr = [];
    function deepScanDir($dir)
    {
        $dirArr = array();
        $dir = rtrim($dir, '//');
        if(is_dir($dir)){
            $dirHandle = opendir($dir);
            while(false !== ($fileName = readdir($dirHandle))){
                $subFile = $dir . DIRECTORY_SEPARATOR . $fileName;
                if (is_dir($subFile) && str_replace('.', '', $fileName)!='' )
                {
                    if(strpos($subFile,'WF')>0 || strpos($subFile,'wf')>0)
                    {
                        echo $subFile;
                        $this->wfArr[] = $subFile;
                        continue;
                    }
                    $dirArr[] = $subFile;
                    $arr = $this->deepScanDir($subFile);
                    $dirArr = array_merge($dirArr, $arr['dir']);
                }
            }
            closedir($dirHandle);
        }

        return array('dir'=>$dirArr);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //return view('mywork.index');
        //echo 'ffff';
        $dir = 'E:\mygit\test';
        $arr = $this->deepScanDir($dir);
        //print_r($arr);
        var_dump($this->wfArr);
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
