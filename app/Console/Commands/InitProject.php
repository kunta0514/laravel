<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Project;
use App\Workflow;
use Illuminate\Support\Facades\DB;

class InitProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:init_project';

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
    protected $target_dir =  'H:\Project';
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
        echo 'what fuck!!';
        $this->init_project();

        $this->get_workflow_dir_step_1();
        $this->get_workflow_dir_step_2();
        $this->get_workflow_dir_step_3();
        echo 'ok';
    }

    /**
     * 扫描F盘下的所有项目，记录版本文件地址
     */
    protected function get_workflow_dir_step_1()
    {
//        $dir = 'F:\Project\长城地产';
//        $dir = iconv("utf-8","gbk",$dir);
//        $file_array = [];
//        $this->scan_dir_all($dir,$this->target_filename,$file_array);
//        print_r($file_array);
//        DB::table('projects2workflow')->truncate();
        $projects = DB::table('project')->get();
        $c = 1;
        $fail = 0;
        foreach($projects as $project)
        {
            //$project->path 为更新条件
            $dir = $project->path;
            $dir = iconv("utf-8","gbk",$dir);
            $file_array = [];
            $description = '扫描到第'.$c.'个目录，扫描地址："'.$project->path.'"';
            $this->print_log($description);

            if(is_dir($dir)){
                $this->scan_dir_all($dir,$this->target_filename,$file_array);
            }

            if(!empty($file_array)){
                for($x = 0; $x < count($file_array['workflow_path']); $x++){
                    $workflow = new Workflow();
                    $workflow->project_name = $project->name;
                    $workflow->path = $project->path;
                    $workflow->workflow_path = iconv('gbk','utf-8',$file_array['workflow_path'][$x]);
                    $workflow->assemblyInfo_path = iconv('gbk','utf-8',$file_array['assemblyInfo_path'][$x]);
                    $workflow->save();
                }
            }
            else{
                $fail++;
                $description = "失败：第 $c 个目录\" $project->path \"，未扫描到文件";
                $this->print_log($description);
            }

            $c++;
            unset($file_array);
        }

        $count = $c - 1;
        $success = $c - $fail - 1;
        $description = "本次共扫描 $count 个目录，成功 $success 次，失败 $fail 次";
        $this->print_log($description);
    }

    /**
     * 扫描H盘下的所有项目，记录版本文件地址
     */
    protected function get_workflow_dir_step_2()
    {
        $projects = DB::select('select * from project where `name` not in (select project_name from projects2workflow) and source = 1');
        $dir_root = 'H:\Project';
        $c = 1;
        $fail = 0;
        foreach($projects as $project)
        {
            $dir = $dir_root.DIRECTORY_SEPARATOR.$project->name;
            $dir_gbk = iconv("utf-8","gbk",$dir);
//            echo $dir_gbk.chr(10);
            $file_array = [];
            $description = '扫描到第'.$c.'个目录，扫描地址："'.$dir.'"';
            $this->print_log($description);

            if(is_dir($dir_gbk)){
                $this->scan_dir_all($dir_gbk,$this->target_filename,$file_array);
            }

            if(!empty($file_array)){
                for($x = 0; $x < count($file_array['workflow_path']); $x++){
//                    print_r($file_array);
                    $workflow = new Workflow();
                    $workflow->project_name = $project->name;
                    $workflow->path = $dir;
                    $workflow->workflow_path = iconv('gbk','utf-8',$file_array['workflow_path'][$x]);
                    $workflow->assemblyInfo_path = iconv('gbk','utf-8',$file_array['assemblyInfo_path'][$x]);
                    $workflow->save();
                }
            }
            else{
                $fail++;
                $description = "失败：第 $c 个目录\" $dir \"，未扫描到文件";
                $this->print_log($description);
            }

            $c++;
            unset($file_array);
        }
        $count = $c - 1;
        $success = $c - $fail - 1;
        $description = "本次共扫描 $count 个目录，成功 $success 次，失败 $fail 次";
        $this->print_log($description);
    }

    /**
     * 读取版本信息文件，记录版本号
     */
    protected function get_workflow_dir_step_3()
    {
//        $works = DB::table('projects2workflow')->get();
        //TODO:会取出' <Assembly: AssemblyVersion("1.0.*")> 注释部分
        $works = Workflow::all();
        $pattern = 'AssemblyVersion.*\)';
        $pattern_file = 'AssemblyFileVersion.*\)';
        $c = 1;
        $fail = 0;
        foreach($works as $work){
            $description = '扫描到第'.$c.'个目录，扫描地址："'.$work->workflow_path.'"';
            $this->print_log($description);
            $work->assemblyInfo = $this->get_assembly_info(iconv('utf-8','gbk',$work->assemblyInfo_path),$pattern);
            $work->assemblyFileInfo = $this->get_assembly_info(iconv('utf-8','gbk',$work->assemblyInfo_path),$pattern_file);
            $work->save();
            $c++;
        }
        $count = $c - 1;
        $success = $c - $fail - 1;
        $description = "本次共扫描 $count 个目录，成功 $success 次，失败 $fail 次";
        $this->print_log($description);
    }

    protected function refresh_version()
    {
        //SQL更新版本数据
//        update projects2workflow set workflow_version = case when assemblyFileInfo is  NULL then assemblyInfo  else assemblyFileInfo end
//        update projects2workflow set workflow_version = REPLACE(workflow_version,'AssemblyVersion("','');
//        update projects2workflow set workflow_version = REPLACE(workflow_version,'AssemblyFileVersion("','');
//        update projects2workflow set workflow_version = REPLACE(workflow_version,'")','');
//        select * from projects2workflow where workflow_version = '1.0.*'
        DB::update('update projects2workflow a inner join versions b ON a.workflow_version = b.workflow_version set a.erp_version = b.erp_version');

//        所有1.0的都是3.5.3.20630的主动修复版本
//        佛山海骏达	3.5.3.20630	ERP3.0.3
//        福建新华都	3.5.3.20630	ERP3.0.3
//        福建新华都	3.5.8.40930	ERP3.0.7SP3
//        江苏中南建设	3.5.1.10824	ERP3.0.1SP1
//        江苏中南建设	3.5.3.20630	ERP3.0.3
//        南京中新	3.5.5.30704	ERP3.0.5
//        南京中新	3.5.3.20630	ERP3.0.3
//        南京中新	3.5.6.40213	ERP3.0.6
//        南宁市地产业	3.5.3.20630	ERP3.0.3
//        深圳泰富华	3.5.3.20630	ERP3.0.3
//        深圳星河	3.0.8.50415	ERP2.5.6
//        深圳星河	3.0.8.50415	ERP2.5.6
//        深圳星河	3.5.3.20630	ERP3.0.3
    }

    protected function get_assembly_info($file_full_name,$pattern)
    {
        $file_handle = fopen($file_full_name, "r");
        $context = fread($file_handle,filesize($file_full_name));
        fclose($file_handle);
//        $pattern = 'AssemblyVersion.*\)';
        $assembly_info = $this->get_assembly_info_match($pattern,$context);
        return $assembly_info;
    }
    protected function get_assembly_info_match($pattern,$context)
    {

        $pattern = '/'.$pattern.'/';

        preg_match($pattern,$context,$matches);
        if(!empty($matches)) {
            return $matches[0];
        }
        else{
            return null;
        }
    }

    protected function init_project()
    {
        //1.清空项目信息
        //DB::table('project')->get();

//        echo 'fuck!!';
        DB::table('project')->truncate();
        $this->print_log("清空projects中的数据！");

        DB::table('projects2workflow')->truncate();
        $this->print_log("清空projects2workflow中的数据！");

        //2.初始化二开项目信息
        $this->scan_project_dir($this->target_dir);

    }

    //扫描项目根目录
    protected function scan_project_dir($dir)
    {
        $this->print_log("创建项目数据");
        $project_list = [];
        $array = scandir($dir);
        $project_info = [];
        foreach ($array as $val){
            if($val!="." && $val!=".." && is_dir($dir.DIRECTORY_SEPARATOR.$val) && $val!= iconv('utf-8','gbk','00 部门及项目公共管理') && $val != iconv('utf-8','gbk','mWF项目文档库') && $val != iconv('utf-8','gbk','WF项目文档库')){
                $project = new Project();
                $project->name = iconv('gbk','utf-8',$val);
                $project->path =iconv('gbk','utf-8',$dir.DIRECTORY_SEPARATOR.$val);
                $project->save();
//                print_r($dir.DIRECTORY_SEPARATOR.$val);
            }
        }
        $this->print_log("项目数据填充完毕");
    }

    protected function print_log($context)
    {
        echo iconv('utf-8','gbk',$context).chr(10);
    }

}
