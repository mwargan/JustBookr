<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_ratings', function(Blueprint $table)
		{
			$table->foreign('user-id', 'user_ratings_ibfk_1')->references('user-id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_ratings', function(Blueprint $table)
		{
			$table->dropForeign('user_ratings_ibfk_1');
		});
	}

}
