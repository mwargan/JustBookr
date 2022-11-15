<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTextbookMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('textbook_meta', function (Blueprint $table) {
            $table->foreign('isbn', 'textbook_meta_ibfk_1')->references('isbn')->on('textbooks')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('textbook_meta', function (Blueprint $table) {
            $table->dropForeign('textbook_meta_ibfk_1');
        });
    }
}
