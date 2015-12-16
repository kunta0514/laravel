<?php
/**
 * Created by PhpStorm.
 * User: wank
 * Date: 2015/12/14
 * Time: 21:43
 */


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProject2WorkflowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects2workflow', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('project_name');
            $table->string('path')->nullable();
            $table->string('workflow_path')->nullable();
            $table->string('assemblyInfo_path')->nullable();
            $table->string('assemblyInfo')->nullable();
            $table->string('assemblyFileInfo')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('projects');
    }
}