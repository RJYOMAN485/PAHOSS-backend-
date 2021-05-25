<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Feedback;
use App\Models\ParkingZones;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParkingController extends Controller
{
    public function getClients()
    {
        return User::all();
    }

    public function getBookings()
    {
        return Booking::all();
    }

    public function getParkings()
    {
        return ParkingZones::all();
    }

    public function getTodayBookings()
    {
        return Booking::where('created_at', Carbon::now());
    }

    public function getActiveBookings()
    {
        return Booking::where('status', 'active');
    }

    public function getClientsFeedback()
    {
        return Feedback::all();
    }


    public function storeUser(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->contact = $request->contact;
        $user->gender = $request->gender;
        $user->car_type = $request->car_type;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->roles = 'user';

        $user->save();
    }

    public function storeParking(Request $request)
    {
        // return 'parkings';
        $max = ParkingZones::get()->pluck('alotted')->first();

        if(!$max)
            $max = 1;

        $parking = new ParkingZones();
        $parking->name = $request->location;
        $parking->available_space = $request->available_space;
        $parking->available_time = $request->available_time;
        $parking->postal = $request->postal;
        $parking->lat = $request->lat;
        $parking->lng = $request->lng;
        $parking->alotted = $max;

        $parking->save();
    }

    public function storeBooking(Request $request)
    {
        $booking = new Booking();
        $booking->user_id = $request->user_id;
        $booking->entry_date = $request->entry_date;
        $booking->entry_time = $request->entry_time;
        $booking->exit_date = $request->exit_date;
        $booking->exit_time = $request->exit_time;
        $booking->car_type = $request->car_type;
        $booking->status = $request->status;

        $booking->save();
    }

    public function storeFeedback(Request $request)
    {
        $feedback = new Feedback();
        $feedback->user_id = $request->user_id;
        $feedback->message = $request->message;

        $feedback->save();
    }
}
