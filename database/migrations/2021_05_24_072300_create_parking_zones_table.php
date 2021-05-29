<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('available_space');
            $table->string('available_time');




 
            // $table->string('pname')->nullable(); //change
            // $table->string('postal')->nullable();
            // $table->string('alotted')->nullable();
            



            $table->string('address')->nullable();
            $table->string('lat');
            $table->string('lng');
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
        Schema::dropIfExists('parking_zones');
    }
}
