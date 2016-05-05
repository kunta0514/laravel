<?php
/**
 * Created by PhpStorm.
 * User: wank
 * Date: 2015/12/14
 * Time: 21:43
 */


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function(Blueprint $table)
        {
            $table->increments('id');
            $table->uuid('uid');
            $table->string('name');
            $table->string('use_num')->nullable();      //使用次数
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
        Schema::drop('tags');
    }
}