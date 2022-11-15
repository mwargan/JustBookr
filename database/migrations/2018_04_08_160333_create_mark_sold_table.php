<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkSoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mark_sold', function (Blueprint $table) {
            $table->integer('sold-id', true);
            $table->timestamp('sold-date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('sold-post');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mark_sold');
    }
}
