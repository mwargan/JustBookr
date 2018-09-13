<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_ratings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('isbn', 17)->index('isbn');
			$table->string('rating', 3);
			$table->timestamp('date-rated')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('rated-by', 64);
			$table->text('rate-comment', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('book_ratings');
	}

}
