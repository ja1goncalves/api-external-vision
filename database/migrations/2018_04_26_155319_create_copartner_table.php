<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copartner', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('cpf')->unique();
            $table->string('name');
            $table->integer('companie_id')->unsigned();
            $table->foreign('companie_id')->references('id')->on('companies');
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
        Schema::drop('copartner');
    }
}
