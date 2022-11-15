<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBookRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_ratings', function (Blueprint $table) {
            $table->foreign('isbn', 'book_ratings_ibfk_1')->references('isbn')->on('textbooks')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_ratings', function (Blueprint $table) {
            $table->dropForeign('book_ratings_ibfk_1');
        });
    }
}
