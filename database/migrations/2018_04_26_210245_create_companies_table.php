<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cnpj');
            $table->string('corporate');
            $table->string('cnae');
            $table->string('discription_cnae');
            $table->string('participation');
            $table->date('date_entry');
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
        Schema::dropIfExists('companies');
    }
}
