<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCompaniesTable.
 */
class CreateCompaniesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('companies', function(Blueprint $table) {
            $table->increments('id');
            $table->string('cnpj', 18);
            $table->string('corporate');
            $table->string('cnae', 9);
            $table->string('discription_cnae', 200);
            $table->string('participation');
            $table->date('date_entry', 8)->nullable();
            $table->integer('people_id')->unsigned()->index();
            $table->foreign('people_id')->references('id')->on('people');

            $table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('companies');
	}
}
