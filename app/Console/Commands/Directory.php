<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/28
 * Time: 22:12
 */

//function deepScanDir($dir)
//{
//    $dirArr = array();
//    $dir = rtrim($dir, '//');
//    if(is_dir($dir)){
//        $dirHandle = opendir($dir);
//        while(false !== ($fileName = readdir($dirHandle))){
//            $subFile = $dir . DIRECTORY_SEPARATOR . $fileName;
//            if (is_dir($subFile) && str_replace('.', '', $fileName)!='' )
//            {
////                if(strpos($subFile,'MAP')>0 || strpos($subFile,'map')>0)
////                {
////                    continue;
////                }
////
////                if(strpos($subFile,'WF')>0 || strpos($subFile,'wf')>0 || strpos($subFile,'MAP')>0 || strpos($subFile,'map')>0)
////                {
////                    //echo $subFile;
////                    $wfArr[] = $subFile;
////                    continue;
////                }
//                $dirArr[] = $subFile;
//                $arr = deepScanDir($subFile);
//                $dirArr = array_merge($dirArr, $arr['dir']);
//            }
//        }
//        closedir($dirHandle);
//    }
//
//    return array('dir'=>$dirArr);
//}

//
//function scan_dir($dir){
//    global $list;
//    $array=scandir($dir);
//    foreach ($array as $val){
//        if($val!="." && $val!=".." && is_dir($dir."\\".$val)){
//            if($val == 'MyWorkflow'){
//                $list[] =  $dir."\\".$val;
//            }
//            //读取文件中的内容
//            scan_dir($dir."\\".$val);
//        }
//    }
//}


$target_dir = 'F:\mygit\laravel\ProjectWorkflow';
$list = [];
$project_list = [];

function scan_project_dir($dir)
{
    global $project_list;
    $array = scandir($dir);
    $project_info = [];
    foreach ($array as $val){
        if($val!="." && $val!=".." && is_dir($dir."\\".$val)){
            $project_info = [
                'project_name' => $val,
                'project_path' => $dir."\\".$val
            ];
            $project_list[] =  $project_info;
        }
    }
}

function gbk2utf8($data){
    if(is_array($data)){
        return array_map('gbk2utf8', $data);
    }
    return iconv('gbk','utf-8',$data);
}

function save_project_json($json)
{
    $file_handle = fopen("project_list_file.json", "w");

    fwrite($file_handle, $json);

    fclose($file_handle);
}


function find_workflow_dir($dir,&$project_array){
    $array=scandir($dir);
    foreach ($array as $val){
        if($val!="." && $val!=".." && is_dir($dir."\\".$val)){
            if($val == 'MyWorkflow'){
                $project_array['workflow_path'][] = $dir."\\".$val;
                return $dir."\\".$val;
            }
            //TODO:第一步筛选，找出文件夹，后续筛选找出文件
            //读取文件中的内容
            find_workflow_dir($dir."\\".$val,$project_array);
        }
    }
}


/**
 * 取文件最后$n行
 * @param string $filename 文件路径
 * @param int $n 最后几行
 * @return mixed false表示有错误，成功则返回字符串
 */
function FileLastLines($filename,$n){
    if(!$fp=fopen($filename,'r')){
        echo "打开文件失败，请检查文件路径是否正确，路径和文件名不要包含中文";
        return false;
    }
    $pos=-2;
    $eof="";
    $str="";
    while($n>0){
        while($eof!="\n"){
            if(!fseek($fp,$pos,SEEK_END)){
                $eof=fgetc($fp);
                $pos--;
            }else{
                break;
            }
        }
        $str.=fgets($fp);
        $eof="";
        $n--;
    }
    return $str;
}

function get_assemblyInfo_match($pattern,$context)
{
    /*PHP正则提取图片img标记中的任意属性*/
    //$str = '<center><img src="/uploads/images/20100516000.jpg" height="120" width="120"><br />PHP正则提取或更改图片img标记中的任意属性</center>';

    //$match = 'AssemblyVersion.*\)';
    //1、取整个图片代码

    $pattern = '/'.$pattern.'/';

    preg_match($pattern,$context,$matches);
    if(!empty($matches)) {
        return $matches[0];
    }
    else{
        return null;
    }
}

function get_assemblyInfo($dir,$name)
{
//    $last = FileLastLines($dir."\\".$name,1);
    $file_handle = fopen($dir."\\".$name, "r");
    $context = fread($file_handle,filesize($dir."\\AssemblyInfo.vb"));
    fclose($file_handle);

    $pattern_version = 'AssemblyVersion.*\)';
    $pattern_file_version = 'AssemblyFileVersion.*\)';

    $version = [
        'AssemblyVersion' => get_assemblyInfo_match($pattern_version,$context),
        'AssemblyFileVersion' => get_assemblyInfo_match($pattern_file_version,$context)
    ];
    return $version;
}

$assemblyInfo = "AssemblyInfo.vb";
//scan_dir($dir);
//第一层，找到所有项目名称
scan_project_dir($target_dir);
//第二层，找到项目对应的MyWorkflow
foreach($project_list as $k=>$project)
{
    find_workflow_dir($project['project_path'],$project);
    foreach($project['workflow_path'] as $val)
    {
        //读取AssemblyInfo，拿出版本号并记录
        $version = get_assemblyInfo($val,$assemblyInfo);
        $project['assemblyInfo_path'][] = $val."\\".$assemblyInfo;
        $project['assemblyInfo'][] = $version;
    }
    $project_list[$k] = $project;

}


print_r($project_list);
//var_dump($project_list);

//save_project_json(json_encode(gbk2utf8($project_list),JSON_UNESCAPED_UNICODE));


//echo json_encode($project_list,JSON_UNESCAPED_UNICODE);



//第一层，找到所有项目名称

//第二层，找到项目对应的MyWorkflow

//第二层，找到MyWorkflow中的AssemblyInfo.vb

//$myfile = fopen("project_list_file.json", "w");
//
//fwrite($myfile, $project_list);
//
//fclose($myfile);
