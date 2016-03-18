<?php
/**
 * Created by PhpStorm.
 * User: wank
 * Date: 2015/11/29
 * Time: 21:43
 */


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('path')->nullable();
            $table->integer('source');      //是否包含源代码（只有TFS，没创建源代码的不需要统计）
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
        Schema::drop('project');
    }
}