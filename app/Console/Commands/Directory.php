<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/28
 * Time: 22:12
 */

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
//                if(strpos($subFile,'MAP')>0 || strpos($subFile,'map')>0)
//                {
//                    continue;
//                }
//
//                if(strpos($subFile,'WF')>0 || strpos($subFile,'wf')>0 || strpos($subFile,'MAP')>0 || strpos($subFile,'map')>0)
//                {
//                    //echo $subFile;
//                    $wfArr[] = $subFile;
//                    continue;
//                }
                $dirArr[] = $subFile;
                $arr = deepScanDir($subFile);
                $dirArr = array_merge($dirArr, $arr['dir']);
            }
        }
        closedir($dirHandle);
    }

    return array('dir'=>$dirArr);
}

$dir = 'F:\mygit';
//$arr = deepScanDir($dir);
//var_dump($arr);
//$all = scandir($dir);
//var_dump($all);
$list = [];
function scan_dir($dir){
    global $list;
    $array=scandir($dir);
    foreach ($array as $val){
        if($val!="." && $val!=".." && is_dir($dir."\\".$val)){
            $list[] =  $dir."\\".$val;
            //TODO:第一步筛选，找出文件夹，后续筛选找出文件
            //读取文件中的内容
            scan_dir($dir."\\".$val);
        }
    }
}

scan_dir($dir);
var_dump($list);
