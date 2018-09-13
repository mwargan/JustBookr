<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTextbookClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('textbook_class', function(Blueprint $table)
		{
			$table->integer('tclink', true);
			$table->string('isbn', 17)->index('isbn');
			$table->integer('class-id')->index('class-id');
			$table->string('used-until', 5)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('textbook_class');
	}

}
