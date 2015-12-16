<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Project;
use App\Workflow;
use Illuminate\Support\Facades\DB;

class SycnWorkflowProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sycnwork';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    protected $target_filename = 'AssemblyInfo.vb';
    /**
     * @param $dir 文件目录
     */
    protected function scan_dir_all($dir,$target_filename,&$file_array)
    {
        $array = scandir($dir);
        if(is_array($array) && count($array) > 2){
//            //去掉数组中的.、..2个目录
//            array_shift($array);
//            array_shift($array);
            foreach ($array as $val){
                $cur_dir=$dir.DIRECTORY_SEPARATOR.$val;
                if(is_dir($cur_dir) && $val != '.' && $val != '..'){
                    //如果找到MyWorkflow，则寻找其下的AssemblyInfo.vb或My Project下的AssemblyInfo.vb
                    if($val == 'MyWorkflow'){
                        //1、MyWorkflow下存在AssemblyInfo.vb
                        if(is_file($cur_dir.DIRECTORY_SEPARATOR.$target_filename)) {
                            $file_array['workflow_path'][] = $cur_dir;
                            $file_array['assemblyInfo_path'][] = $cur_dir.DIRECTORY_SEPARATOR.$target_filename;
                        }
                        //2、MyWorkflow下存在My Project，并存在AssemblyInfo.vb
                        if(is_file($cur_dir.DIRECTORY_SEPARATOR.'My Project'.DIRECTORY_SEPARATOR.$target_filename)) {
                            $file_array['workflow_path'][] = $cur_dir.DIRECTORY_SEPARATOR.'My Project';
                            $file_array['assemblyInfo_path'][] = $cur_dir.DIRECTORY_SEPARATOR.'My Project'.DIRECTORY_SEPARATOR.$target_filename;
                        }
                        break;
                    }

                    $this->scan_dir_all($cur_dir,$target_filename,$file_array);
                }
//                else if($val{0} == '.') {
//                    print_r($array);
//                    echo $dir.PHP_EOL;
//                    echo $val;
//                }
            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $this->del_project();
//        $this->get_project_dir();
//        print_r(DB::table('projects')->get());
        $this->get_workflow_dir();
//        echo 111;
    }

    protected function get_workflow_dir()
    {
        $dir = 'F:\Project\北京鸿坤';
        $dir = iconv("utf-8","gbk",$dir);
        $file_array = [];
        $this->scan_dir_all($dir,$this->target_filename,$file_array);
        print_r($file_array);
//        DB::table('projects2workflow')->truncate();
//        $projects = DB::table('projects')->get();
//        $c = 1;
//        $fail = 0;
//        foreach($projects as $project)
//        {
//            //$project->path 为更新条件
//            $dir = $project->path;
//            $dir = iconv("utf-8","gbk",$dir);
//            $file_array = [];
//            $this->scan_dir_all($dir,$this->target_filename,$file_array);
//
//            $description = '扫描到第'.$c.'个目的，扫描地址："'.$project->path.'"';
//            echo iconv('utf-8','gbk',$description).chr(10);
//
//            if(!empty($file_array)){
//                for($x = 0; $x < count($file_array['workflow_path']); $x++){
//                    $workflow = new Workflow();
//                    $workflow->project_name = $project->name;
//                    $workflow->path = $project->path;
//                    $workflow->workflow_path = iconv('gbk','utf-8',$file_array['workflow_path'][$x]);
//                    $workflow->assemblyInfo_path = iconv('gbk','utf-8',$file_array['assemblyInfo_path'][$x]);
//                    $workflow->save();
//                }
////                print_r($file_array);
////                $workflow = new Workflow();
////                $workflow->project_name = $project->name;
////                $workflow->path = $project->path;
////                $workflow->workflow_path = iconv('gbk','utf-8',$file_array['dir']);
////                $workflow->assemblyInfo_path = iconv('gbk','utf-8',$file_array['file']);
////                $workflow->save();
//            }
//            else{
//                $fail++;
//                $description = "失败：第 $c 个目录\" $project->path \"，未扫描到文件";
//                echo iconv('utf-8','gbk',$description).chr(10);
//            }
//
//            $c++;
//            unset($file_array);
//        }
//
//        $count = $c - 1;
//        $success = $c - $fail - 1;
//        $description = "本次共扫描 $count 个目录，成功 $success 次，失败 $fail 次";
//        echo chr(10).iconv('utf-8','gbk',$description).chr(10);
    }

    protected function get_project_dir()
    {
        $file_name = "app/Console/Commands/project_list_file.json";
        $file_list = fopen($file_name, "r");
        $project_list_json = fread($file_list,filesize($file_name));
        fclose($file_list);

        $project_list_array = json_decode($project_list_json,true);


        //DB::table('projects')->truncate();
        $description = "填充数据中...";
        //echo $description;
        //echo $description;

        echo iconv('utf-8','gbk',$description).chr(10);
        foreach($project_list_array as $val)
        {
            $project = new Project();
            $project->name = $val['project_name'];
            $project->path = $val['project_path'];
            $project->save();
        }
        $description = "填充完毕！";
        //echo $description;
        //echo $description;

        echo iconv('utf-8','gbk',$description).chr(10);
    }

    protected function del_project()
    {
        //DB::table('projects')->get();
        DB::table('projects')->truncate();
        $description = "清空projects中的数据！";
        //echo $description;
        //echo $description;

        echo iconv('utf-8','gbk',$description).chr(10);

    }
}
