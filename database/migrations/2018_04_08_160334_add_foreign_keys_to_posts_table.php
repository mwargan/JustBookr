<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('posts', function (Blueprint $table) {
			$table->foreign('isbn', 'posts_ibfk_7')->references('isbn')->on('textbooks')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('uni-id', 'posts_ibfk_8')->references('uni-id')->on('universities')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('user-id', 'posts_ibfk_9')->references('user-id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('posts', function (Blueprint $table) {
			$table->dropForeign('posts_ibfk_7');
			$table->dropForeign('posts_ibfk_8');
			$table->dropForeign('posts_ibfk_9');
		});
	}

}
