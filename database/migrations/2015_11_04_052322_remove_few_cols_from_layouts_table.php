<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFewColsFromLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layouts', function(Blueprint $table) {
            $table->dropColumn('slider_images');
            $table->dropColumn('slider_option');
            $table->dropColumn('param_one');
            $table->dropColumn('param_two');
            $table->dropColumn('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('layouts', function(Blueprint $table) {
            
        });
    }
}
