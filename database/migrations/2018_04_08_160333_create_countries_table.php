<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->char('iso2', 2)->index('iso2');
			$table->char('iso3', 3)->index('iso3');
			$table->string('name', 100)->index('name');
			$table->string('currency', 7)->nullable()->default('&#128;');
			$table->string('currency_iso', 3)->nullable()->default('EUR');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('countries');
	}

}
