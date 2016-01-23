<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsiteBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_brand', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('brand_img_src')->nullable();
            $table->string('text_color')->nullable();
            $table->string('font')->nullable();
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
        Schema::drop('website_brand');
    }
}
