<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBookPicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_book_pics', function (Blueprint $table) {
            $table->integer('link-id', true);
            $table->integer('post-id')->nullable()->index('post-id');
            $table->string('isbn', 17)->nullable()->index('isbn');
            $table->integer('user-id')->nullable()->index('user-id');
            $table->string('image-path', 259);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_book_pics');
    }
}
