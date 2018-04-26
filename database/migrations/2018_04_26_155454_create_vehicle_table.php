<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('board');
            $table->string('brand_model');
            $table->date('manufacturing_year');
            $table->date('model_year');
            $table->integer('consult_id')->unsigned();
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
        Schema::drop('vehicle');
    }
}
