<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccupationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occupations', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('code');
            $table->string('description');
            $table->string('cnpj');
            $table->string('corporate');
            $table->string('cnae');
            $table->string('description_cnae');
            $table->string('postage');
            $table->string('salary');
            $table->string('salary_range');
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
        Schema::drop('occupations');
    }
}
