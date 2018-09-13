<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_comments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('post-id')->index('pid');
			$table->integer('user-id')->index('user-id');
			$table->string('comment', 250);
			$table->timestamp('comment_timestamp')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('post_comments');
	}

}
