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
            $table->string('task_no');
            $table->string('ekp_oid');
            $table->string('task_title');
            $table->string('customer_name');
            $table->string('erp_version');
            $table->string('map_version');
            $table->string('abu_pm');
            $table->dateTime('ekp_create_date');//ekp任务登记时间
            $table->dateTime('start');
            $table->dateTime('ekp_expect');//期望完成时间（任务时限）
            $table->dateTime('actual_finish_date');//实际完成时间
            $table->tinyInteger('status');
            $table->string('comment');
            $table->string('task_type');
            $table->string('workflow_version');
            $table->tinyInteger('is_sla');
            $table->tinyInteger('is_sensitive');
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