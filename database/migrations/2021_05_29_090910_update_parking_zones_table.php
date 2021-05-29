<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateParkingZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parking_zones', function (Blueprint $table) {

            $table->renameColumn('name', 'pname');
            $table->string('postal')->nullable();
            $table->string('alotted')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parking_zones', function(Blueprint $table) {
            $table->renameColumn('pname', 'name');
        });
    }
}
