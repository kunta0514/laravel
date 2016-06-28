<?php
/**
 * Created by PhpStorm.
 * User: wank
 * Date: 2016/5/25
 * Time: 11:16
 */


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->string('ekp_latest_name')->nullable();     //EKP最新的名字
            $table->string('area')->nullable();     //区域
            $table->string('path')->nullable();
            $table->Integer('is_standard')->nullable();      //是否标准客户  0、不是，1、是    （非标准客户升级到标准数据如何表示）
            $table->Integer('is_update')->nullable();         //是否升级   0、不是，1、是
            $table->Integer('is_aop')->nullable();            //是否插件化   0、不是，1、是
            $table->Integer('update_type')->nullable();      //更新包方式：1、标准更新包升级，2、手工包升级
            $table->string('update_reason')->nullable();
            $table->string('update_log')->nullable();
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
        Schema::drop('customers');
    }
}