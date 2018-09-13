<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToActivityfeedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('activityfeed', function(Blueprint $table)
		{
			$table->foreign('user-id', 'activityfeed_ibfk_1')->references('user-id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user-id-who', 'activityfeed_ibfk_2')->references('user-id')->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
			$table->foreign('uni-id', 'activityfeed_ibfk_3')->references('uni-id')->on('webometric_universities')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('activityfeed', function(Blueprint $table)
		{
			$table->dropForeign('activityfeed_ibfk_1');
			$table->dropForeign('activityfeed_ibfk_2');
			$table->dropForeign('activityfeed_ibfk_3');
		});
	}

}
