<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressDataToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
             $table->string('district_gu', 125)->nullable()->after('city');
             $table->string('area_dong', 125)->nullable()->after('district_gu');
             $table->string('apartment', 125)->nullable()->after('area_dong');
             $table->string('unit', 125)->nullable()->after('apartment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            
        });
    }
}
