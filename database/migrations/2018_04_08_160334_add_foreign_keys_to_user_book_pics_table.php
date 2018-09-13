<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserBookPicsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_book_pics', function(Blueprint $table)
		{
			$table->foreign('post-id', 'user_book_pics_ibfk_1')->references('post-id')->on('posts')->onUpdate('CASCADE')->onDelete('SET NULL');
			$table->foreign('user-id', 'user_book_pics_ibfk_2')->references('user-id')->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
			$table->foreign('isbn', 'user_book_pics_ibfk_3')->references('isbn')->on('textbooks')->onUpdate('CASCADE')->onDelete('SET NULL');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_book_pics', function(Blueprint $table)
		{
			$table->dropForeign('user_book_pics_ibfk_1');
			$table->dropForeign('user_book_pics_ibfk_2');
			$table->dropForeign('user_book_pics_ibfk_3');
		});
	}

}
