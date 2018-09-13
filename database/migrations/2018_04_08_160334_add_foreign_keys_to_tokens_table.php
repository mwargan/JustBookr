<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTokensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tokens', function(Blueprint $table)
		{
			$table->foreign('user-id', 'tokens_ibfk_1')->references('user-id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tokens', function(Blueprint $table)
		{
			$table->dropForeign('tokens_ibfk_1');
		});
	}

}
