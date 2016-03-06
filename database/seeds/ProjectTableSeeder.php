<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/29
 * Time: 21:58
 */

use Illuminate\Database\Seeder;
use App\Project;

class ProjectTableSeeder extends Seeder {

    public function run()
    {

//        echo 112;
        $file_name = "app/Console/Commands/project_list_file.json";
        $file_list = fopen($file_name, "r");
        $project_list_json = fread($file_list,filesize($file_name));
        fclose($file_list);

        $project_list_array = json_decode($project_list_json,true);

        print_r($project_list_array);

        DB::table('projects')->truncate();

        foreach($project_list_array as $project)
        {
            Project::create([
                'name' => $project['project_name'],
                'path' => $project['project_path']

            ]);
        }

    }

}
