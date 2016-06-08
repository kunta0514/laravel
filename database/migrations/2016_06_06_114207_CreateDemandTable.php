<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('demands', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('demand_no');        //需求编号
            $table->string('demand_name');            //任务主题
            $table->Integer('task_id');         //任务id
            $table->string('task_no');          //任务编号
            $table->string('story');                //故事描述
            $table->string('acceptance');       //验收标准
            $table->string('comment');      //备注
            $table->Integer('PRI');         //优先级
            $table->Integer('scrum_id');      //迭代组织
            $table->string('scrum_name');      //迭代组织
            $table->Integer('sprint');          //批次
            $table->Integer('sprint_name');    //批次
            $table->Integer('source');         //来源，任务系统（0），一线反馈，产品需求（1）
            $table->Integer('sort_id');         //排序ID
            $table->Integer('status');         //需求状态
            $table->Integer('type');         //故事类型
            $table->float('workload')->default(0);   //工作量合计/故事点/其他
            $table->dateTime('actual_finish_date'); //截止时间
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
        //
    }
}
