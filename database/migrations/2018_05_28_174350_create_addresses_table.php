<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAddressesTable.
 */
class CreateAddressesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addresses', function(Blueprint $table) {
            $table->increments('id');
			$table->string('zip_code', 20);
			$table->string('country', 20)->default('BR');
			$table->string('state', 4);
			$table->string('city', 50);
			$table->string('district',200);
			$table->string('street', 300);
			$table->string('complement', 300)->nullable();
			$table->integer('number')->nullable();

			$table->integer('addressable_id')->default(0);
			$table->string('addressable_type',20);

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
		Schema::drop('addresses');
	}
}
