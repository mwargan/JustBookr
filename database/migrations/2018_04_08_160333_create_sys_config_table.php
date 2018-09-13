<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSysConfigTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sys_config', function(Blueprint $table)
		{
			$table->string('variable', 128)->primary();
			$table->string('value', 128)->nullable();
			$table->timestamp('set_time')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('set_by', 128)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sys_config');
	}

}
