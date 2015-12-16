<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Project;

class Workflow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:workflow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function fire()
    {
        $this->line('command set successfully');
    }

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

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


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    }
}
