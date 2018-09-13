<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivityfeedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activityfeed', function(Blueprint $table)
		{
			$table->integer('activity-id', true);
			$table->enum('type', array('ADMINPOST','BOUGHTPOST','ERRORPOST','SOLDPOST','TEXTBOOKPOST','USERPOST'));
			$table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('title', 259);
			$table->text('content', 65535);
			$table->text('picture', 65535);
			$table->text('footer', 65535)->nullable();
			$table->text('action', 65535);
			$table->integer('uni-id')->nullable()->index('uni-id');
			$table->integer('user-id')->index('user-id');
			$table->integer('user-id-who')->nullable()->index('user-id(who)');
			$table->string('post-id', 17)->nullable()->index('isbn');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activityfeed');
	}

}
