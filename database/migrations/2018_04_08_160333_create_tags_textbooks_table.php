<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagsTextbooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tags_textbooks', function(Blueprint $table)
		{
			$table->integer('tt-id', true);
			$table->integer('tag-id')->index('tag-id');
			$table->string('isbn', 17)->index('isbn');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tags_textbooks');
	}

}
