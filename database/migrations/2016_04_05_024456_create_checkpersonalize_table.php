<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckpersonalizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_personalize', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('customer_name');
            $table->string('alias');
            $table->string('version')->nullable();
            $table->string('history_tasks')->nullable();
            $table->string('remark')->nullable();
            $table->tinyInteger('is_valid')->nullable(); //是否有效
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
        Schema::drop('check_personalize');
    }
}
