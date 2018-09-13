<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUniClassesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('uni_classes', function(Blueprint $table)
		{
			$table->integer('class-id', true);
			$table->integer('uni-id')->index('uni-id');
			$table->string('class_code', 17)->nullable();
			$table->string('class_name', 59)->nullable();
			$table->string('class_group', 7)->nullable();
			$table->string('class_professor', 59)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('uni_classes');
	}

}
