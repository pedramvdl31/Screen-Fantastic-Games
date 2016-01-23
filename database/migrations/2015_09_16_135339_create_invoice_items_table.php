<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('inventory_id',false)->nullable();
            $table->decimal('pretax', 11,2)->nullable();
            $table->decimal('tax', 11,2)->nullable();
            $table->decimal('aftertax', 11,2)->nullable();
            $table->tinyInteger('quantity')->nullable();
            $table->text('comment')->nullable();
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
        Schema::drop('invoice_items');
    }
}
