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
            $table->string('ekp_code')->nullable();
            $table->string('area')->nullable();     //区域
            $table->string('path')->nullable();
            $table->tinyInteger('source')->nullable();          //0、工作流个性化代码库中的，1、EKP配置库，2、移动配置库
            $table->tinyInteger('level')->nullable();           //客户级别  0、一般客户，10、项目重点客户，20、移动重点客户，30、区域重点客户（数字越高界别越高）分数加权，10+20+30 60代表都重要
            $table->tinyInteger('is_app')->nullable();          //是否移动客户  0、不是，1、是
            $table->tinyInteger('is_standard')->nullable();      //是否标准客户  0、不是，1、是    （非标准客户升级到标准数据如何表示）
            $table->tinyInteger('is_update')->nullable();         //是否升级   0、不是，1、是
            $table->tinyInteger('is_aop')->nullable();            //是否插件化   0、不是，1、是
            $table->tinyInteger('update_type')->nullable();      //更新包方式：1、标准更新包升级，2、手工包升级
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