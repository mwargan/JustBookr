<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextbookMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('textbook_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('isbn', 17)->default('')->index('isbn');
            $table->string('meta', 128)->nullable();
            $table->string('value', 256)->nullable();
            $table->timestamp('timestamp')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('textbook_meta');
    }
}
