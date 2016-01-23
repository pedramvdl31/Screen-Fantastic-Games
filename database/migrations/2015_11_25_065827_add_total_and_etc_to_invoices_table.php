<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalAndEtcToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('shipping_cost', 11,2)->nullable()->after('quantity');
            $table->decimal('subtotal', 11,2)->nullable()->after('shipping_cost');
            $table->decimal('total', 11,2)->nullable()->after('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            
        });
    }
}
