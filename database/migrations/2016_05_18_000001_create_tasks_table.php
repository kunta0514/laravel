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

            $table->string('developer');        //开发
            $table->float('developer_workload')->default(0);   //开发工作量
            $table->string('tester');           //测试
            $table->float('tester_workload')->default(0);   //测试工作量

            $table->dateTime('ekp_create_date');    //ekp任务登记时间
            $table->dateTime('start');
            $table->dateTime('ekp_expect');         //期望完成时间（任务时限）
            $table->dateTime('actual_finish_date'); //实际
            $table->tinyInteger('status');
            $table->string('comment');
            $table->string('ekp_task_type');    //ekp_task_type
            $table->string('task_type');
            $table->string('workflow_version');
            $table->Integer('PRI');         //优先级
            $table->tinyInteger('is_sla');
            $table->tinyInteger('is_sensitive');
            $table->tinyInteger('priority');
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