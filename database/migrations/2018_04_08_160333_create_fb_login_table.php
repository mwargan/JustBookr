<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFbLoginTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fb_login', function(Blueprint $table)
		{
			$table->string('fb-user-id', 50)->primary();
			$table->integer('user-id')->nullable()->index('user-id');
			$table->boolean('sync-profile-pic')->default(0);
			$table->string('fb_name', 70)->nullable();
			$table->string('fb_surname', 70)->nullable();
			$table->string('fb_email', 90)->nullable();
			$table->string('fb_gender', 20)->nullable();
			$table->string('fb_profilepic', 259)->nullable();
			$table->string('fb_link', 59)->nullable();
			$table->string('fb_location', 59)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fb_login');
	}

}
