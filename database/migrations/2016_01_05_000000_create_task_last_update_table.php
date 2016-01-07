<?php
/**
 * Created by PhpStorm.
 * User: wank
 * Date: 2015/12/14
 * Time: 21:43
 */


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTask_last_updateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_last_update', function(Blueprint $table)
        {
            $table->increments('id');
            $table->dateTime('update_date');
            $table->string('user');
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
        Schema::drop('versions');
    }
}