<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTextbookClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('textbook_class', function(Blueprint $table)
		{
			$table->foreign('class-id', 'textbook_class_ibfk_1')->references('class-id')->on('uni_classes')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('isbn', 'textbook_class_ibfk_2')->references('isbn')->on('textbooks')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('textbook_class', function(Blueprint $table)
		{
			$table->dropForeign('textbook_class_ibfk_1');
			$table->dropForeign('textbook_class_ibfk_2');
		});
	}

}
