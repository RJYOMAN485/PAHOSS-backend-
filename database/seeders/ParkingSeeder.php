<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parking_zones')->insert([
            'pname' => 'ITI Veng',
            'available_space' => 6,
            'available_time' => 'Morning',
            'postal' => '796001',

            'alotted' => 1,
            'address' => 'test',
            'lat' => '23.7206231',
            'lng' => '92.7285287',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
