<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('textbooks', function (Blueprint $table) {
            $table->string('isbn', 17)->primary();
            $table->string('book-title', 259);
            $table->string('author', 259);
            $table->text('book-des', 65535);
            $table->string('edition', 64)->nullable()->default('');
            $table->string('image-url', 259);
            // $table->index(['isbn', 'book-title', 'edition', 'author', 'book-des'], 'search');

            // Create a fulltext on `isbn`, `book-title`, `edition`, `author`
            $table->fullText(['isbn', 'book-title', 'edition', 'author', 'book-des'], 'search');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('textbooks');
    }
}
