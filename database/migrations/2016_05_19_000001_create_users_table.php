<?php
/**
 * Created by PhpStorm.
 * User: wank
 * Date: 2015/12/14
 * Time: 21:43
 */


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code');
            $table->string('password');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->tinyInteger('role')->default(0);    //角色
            $table->tinyInteger('admin')->default(0);   //是否系统管理员
            $table->tinyInteger('is_out')->default(0);   //是否不在组织
            $table->string('user_pic');//用户头像
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
        Schema::drop('users');
    }
}