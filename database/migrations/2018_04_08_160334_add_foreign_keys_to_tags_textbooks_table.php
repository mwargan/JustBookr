<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTagsTextbooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tags_textbooks', function(Blueprint $table)
		{
			$table->foreign('tag-id', 'tags_textbooks_ibfk_1')->references('tag-id')->on('tags')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('isbn', 'tags_textbooks_ibfk_2')->references('isbn')->on('textbooks')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tags_textbooks', function(Blueprint $table)
		{
			$table->dropForeign('tags_textbooks_ibfk_1');
			$table->dropForeign('tags_textbooks_ibfk_2');
		});
	}

}
