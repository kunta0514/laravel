<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSprintTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sprint', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');              //冲刺名称
            $table->Integer('project_id');      //所属项目ID
            $table->Integer('project_name');      //所属项目名称
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
