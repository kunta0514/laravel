<?php
/**
 * Created by PhpStorm.
 * User: wank
 * Date: 2015/11/28
 * Time: 16:53
 */


//function deepScanDir($dir)
//{
//    $fileArr = array();
//    $dirArr = array();
//    $dir = rtrim($dir, '//');
//    if(is_dir($dir)){
//        $dirHandle = opendir($dir);
//        while(false !== ($fileName = readdir($dirHandle))){
//            $subFile = $dir . DIRECTORY_SEPARATOR . $fileName;
//            if(is_file($subFile)){
//                $fileArr[] = $subFile;
//            } elseif (is_dir($subFile) && str_replace('.', '', $fileName)!=''){
//                $dirArr[] = $subFile;
//                $arr = deepScanDir($subFile);
//                $dirArr = array_merge($dirArr, $arr['dir']);
//                $fileArr = array_merge($fileArr, $arr['file']);
//            }
//        }
//        closedir($dirHandle);
//    }
//    return array('dir'=>$dirArr, 'file'=>$fileArr);
//}

$wfArr = [];
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
                if(strpos($subFile,'MAP')>0 || strpos($subFile,'map')>0)
                {
                    continue;
                }

                if(strpos($subFile,'WF')>0 || strpos($subFile,'wf')>0 || strpos($subFile,'MAP')>0 || strpos($subFile,'map')>0)
                {
                    //echo $subFile;
                    $wfArr[] = $subFile;
                    continue;
                }
                $dirArr[] = $subFile;
                $arr = deepScanDir($subFile);
                $dirArr = array_merge($dirArr, $arr['dir']);
            }
        }
        closedir($dirHandle);
    }

    return array('dir'=>$dirArr);
}

$dir = 'E:\Project';
$arr = deepScanDir($dir);
print_r($wfArr);