<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->decimal('pretax', 11,2)->nullable();
            $table->decimal('tax', 11,2)->nullable();
            $table->decimal('aftertax', 11,2)->nullable();
            $table->decimal('unit_price', 11,2)->nullable();
            $table->unsignedInteger('sale_id',false)->nullable();
            $table->unsignedInteger('naver_item_id',false)->nullable();
            $table->text('image_srcs')->nullable();
            $table->text('video_srcs')->nullable();

            $table->tinyInteger('order')->nullable();
            $table->tinyInteger('status')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inventories');
    }
}
