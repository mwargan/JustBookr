<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUniClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uni_classes', function (Blueprint $table) {
            $table->foreign('uni-id', 'uni_classes_ibfk_1')->references('uni-id')->on('universities')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uni_classes', function (Blueprint $table) {
            $table->dropForeign('uni_classes_ibfk_1');
        });
    }
}
