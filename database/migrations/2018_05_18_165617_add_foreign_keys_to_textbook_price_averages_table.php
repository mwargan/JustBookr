<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTextbookPriceAveragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('textbook_price_averages', function (Blueprint $table) {
            $table->foreign('isbn', 'isbn_key')->references('isbn')->on('textbooks')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('textbook_price_averages', function (Blueprint $table) {
            $table->dropForeign('isbn_key');
        });
    }
}
