<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('customer_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('customer_uuid');
            $table->string('customer_name');
            $table->string('path')->nullable();
            $table->string('workflow_path')->nullable();
            $table->string('assemblyInfo_path')->nullable();
            $table->string('assemblyInfo')->nullable();
            $table->string('assemblyFileInfo')->nullable();
            $table->string('workflow_version')->nullable();
            $table->string('erp_version')->nullable();
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
        Schema::drop('customer_details');
    }
}
