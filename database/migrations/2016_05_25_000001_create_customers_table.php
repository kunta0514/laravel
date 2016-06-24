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
            $table->string('is_standard')->nullable();      //是否标准客户
            $table->string('is_update')->nullable();
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