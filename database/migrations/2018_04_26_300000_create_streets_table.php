<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streets', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('type_street');
            $table->string('public_place');
            $table->string('number');
            $table->string('complement');
            $table->string('neighborhood');
            $table->string('city');
            $table->string('uf');
            $table->string('zipcode');
            $table->string('score');


            $table->integer('consult_id');
            $table->foreign('consult_id')->references('id')->on('consults');


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
        Schema::drop('streets');
    }
}
