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
            $table->string('protocol', 34);
			$table->string('cpf', 11)->unique();
			$table->string('name', 150);
			$table->char('sex', 1);
			$table->string('signo_zodiacal', 11);
			$table->date('date_birth', 8)->nullable();
			$table->string('age', 2);
			$table->double('estimated_income', 8,2)->default(0);

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
		Schema::drop('people');
	}
}
