<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePeopleTable.
 */
class CreatePeopleTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('people', function(Blueprint $table) {
			$table->increments('id');
			$table->string('protocol');
			$table->string('cpf')->unique();
			$table->string('name');
			$table->char('sex');
			$table->string('signo_zodiacal');
			$table->date('date_birth');
			$table->string('age');
			$table->string('estimated_income');

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
		Schema::drop('people');
	}
}
