<?php
/**
 * Created by PhpStorm.
 * User: wank
 * Date: 2015/12/14
 * Time: 21:43
 */


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('TaskNo');
            $table->string('TaskTitle');
            $table->string('CustomerName');
            $table->string('ErpVersion');
            $table->string('MapVersion');
            $table->string('AbuPM');
            $table->dateTime('CreateTime');
            $table->dateTime('Start');
            $table->dateTime('ExpectEnd');
            $table->dateTime('ActualEnd');
            $table->tinyInteger('Status');
            $table->string('Comment');
            $table->string('TaskType');
            $table->string('WorkflowVersion');
            $table->tinyInteger('IsExceedSLA');
            $table->tinyInteger('IsSensitive');
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
        Schema::drop('tasks');
    }
}