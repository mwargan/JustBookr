<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToWebometricUniversitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('webometric_universities', function(Blueprint $table)
		{
			$table->foreign('country_id', 'webometric_universities_ibfk_1')->references('id')->on('countries')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('webometric_universities', function(Blueprint $table)
		{
			$table->dropForeign('webometric_universities_ibfk_1');
		});
	}

}
