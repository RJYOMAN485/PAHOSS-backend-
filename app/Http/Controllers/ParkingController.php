<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Feedback;
use App\Models\ParkingZones;
use App\Models\User;
use Carbon\Carbon;
use Facade\FlareClient\Http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class ParkingController extends Controller
{
    private $email;

    public function __construct()
    {
        Booking::where('exit_date', Carbon::now()->toDateString())
            ->where([
                ['exit_time', '=', date('H:i')],
                ['status', '=', 'active']
            ])
            ->update(['status' => 'released']);
    }
    public function getClients()
    {
        return User::where('roles', 'user')->get();
    }

    public function sendMail($email, $book_id)
    {
        $data = array('book_id' => $book_id);

        $this->email = $email;

        Mail::send(['text' => 'mail'], $data, function ($message) {
            $message->to($this->email, 'Clients')->subject('Slot Booking Successful');
            $message->from('pahosscenter@gmail.com', 'Pahoss Aizawl');
        });
        echo "Basic Email Sent. Check your inbox.";
    }

    public function postMail(Request $request)
    {
        $this->sendMail($request->email, $request->book_id);
    }

    public function getTodayBookings()
    {

        $dt = Carbon::today()->toDateString();


        // return DB::select("select * from bookings where DATE(created_at)='$dt'");
        return DB::select("select users.name,bookings.id,bookings.entry_date,bookings.entry_time,bookings.exit_date,bookings.exit_time,bookings.amount,bookings.status,parking_zones.pname from users,bookings,parking_zones where bookings.user_id = users.id and bookings.parking_id = parking_zones.id and DATE(bookings.created_at) = '$dt' order by bookings.created_at desc");

        // return DB::select("select * from bookings where convert(date,created_at)=convert(date,getdate())");


    }

    public function deleteParking(Request $request)
    {
        $parking = ParkingZones::find($request->id);
        $parking->delete();
    }

    public function deleteUser(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
    }

    public function updateParking(Request $request)
    {
        $parking = ParkingZones::find($request->id);
        $parking->pname = $request->pname;
        $parking->lat = $request->lat;
        $parking->lng = $request->lng;
        $parking->available_space = $request->available_space;
        $parking->available_time = $request->available_time;
        $parking->save();
    }


    public function updateUser(Request $request)
    {
        // return $request->all();
        // return $request->password ? $request->password : 'null' ; 
        $user = User::find($request->id);

        $user->name = $request->name;

        $user->email = $request->email;

        $user->roles = $request->roles;

        // $request->password = $request->password ? Hash::make($request->password) : $user->password; 

        if ($request->password)
            $user->password = Hash::make($request->password);

        $user->save();
    }

    public function cancelBooking(Request $request)
    {
        // return $request->id;
        $cancel = Booking::find($request->id);
        $cancel->status = 'cancelled';
        $cancel->save();
    }

    public function dashboard()
    {
        // return Carbon::today();
        $total_bookings = Booking::all()->count();

        $todays_booking = Booking::whereDate('created_at', Carbon::today())->get()->count();

        $active_booking = Booking::where('status', 'active')->count();

        $release_booking = Booking::where('status', 'cancelled')->count();

        $total_clients = User::where('roles', 'user')->count();

        $toal_parkings = ParkingZones::all()->count();

        $recent = DB::select("select * from users,bookings where bookings.user_id = users.id limit 5");

        return response()->json([
            'total_bookings' => $total_bookings,
            'todays_booking' => $todays_booking,
            'active_booking' => $active_booking,

            'release_booking' => $release_booking,

            'total_clients' => $total_clients,
            'total_parkings' => $toal_parkings,

            'recents' => $recent,




        ]);

        // return $active_booking;
    }

    public function feedback(Request $request)
    {
        $feedback =  new Feedback();
        $feedback->user_id = $request->user_id;
        $feedback->message = $request->message;

        $feedback->save();
    }

    public function check(Request $request)
    {
        // return date('H:i');

        $check = Booking::where('exit_date', Carbon::now()->toDateString())
            ->where([
                ['exit_time', '=', date('H:i')],
                ['status', '=', 'active']
            ])
            ->update(['status' => 'released']);


        return $check;

        // $check->status = ''



        // return Booking::where([
        //     'entry_date' => Carbon::now()->toDateString(),
        //     'exit_time' => '08:56'
        // ])->get();
        // $count = ParkingZones::where('id',10)->get()->pluck('available_space')->first();

        // $check = Booking::where([
        //     'parking_id' => 10,
        //     'entry_date' => ''

        // ]);

        // return Booking::where('entry_date','2021-05-28')->get();

        // return $count;

        return Booking::where('entry_date', Carbon::now()->toDateString())->get();
    }

    public function getFeedback()
    {
        return DB::select("select users.name,feedback.message from users,feedback where users.id = feedback.user_id");
    }

    public function getUserBookings($id)
    {



        $query = DB::select("select bookings.id,bookings.entry_date,bookings.entry_time,bookings.exit_date,bookings.exit_time,bookings.amount,bookings.status,parking_zones.pname from parking_zones,bookings where bookings.user_id = $id and parking_zones.id = bookings.parking_id order by bookings.created_at desc");

        return $query;
    }

    public function getDate()
    {
        $date = Carbon::now()->toDateString();
        return $date;
    }

    public function getPostal(Request $request)
    {
        // return ParkingZones::all();
        return ParkingZones::where('postal', $request->postal)->get();
    }

    public function getBookings()
    {
        return DB::select("select users.name,bookings.id,bookings.entry_date,bookings.entry_time,bookings.exit_date,bookings.exit_time,bookings.amount,bookings.status,parking_zones.pname from users,bookings,parking_zones where bookings.user_id = users.id and bookings.parking_id = parking_zones.id order by bookings.created_at desc");
    }

    public function getParkings()
    {
        return ParkingZones::all();
    }

    // public function getTodayBookings()
    // {
    //     return Booking::where('created_at', Carbon::now());
    // }

    public function getActiveBookings()
    {
        // return 'dsd';
        return DB::select("select users.name,bookings.id,bookings.entry_date,bookings.entry_time,bookings.exit_date,bookings.exit_time,bookings.amount,bookings.status,parking_zones.pname from users,bookings,parking_zones where bookings.user_id = users.id and bookings.parking_id = parking_zones.id and bookings.status='active' order by bookings.created_at desc");
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

    public function storeAdmin(Request $request)
    {
        $admin = new User();
        $admin->name = $request->name;
        $admin->password = Hash::make($request->password);
        $admin->email = $request->email;
        $admin->roles = 'admin';

        $admin->save();
    }

    public function storeParking(Request $request)
    {
        // return 'parkings';
        $max = ParkingZones::get()->pluck('alotted')->first();

        if (!$max)
            $max = 1;

        $parking = new ParkingZones();
        $parking->pname = $request->location;
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
        $book_id = DB::table('bookings')->max('id');

        if (!$book_id)
            $book_id = 100;

        $booking = new Booking();
        $booking->id = $book_id + 1;
        $booking->user_id = $request->user_id;
        $booking->parking_id = $request->parking_id;
        $booking->entry_date = $request->entry_date;
        $booking->entry_time = $request->entry_time;
        $booking->exit_date = $request->exit_date;
        $booking->exit_time = $request->exit_time;
        $booking->amount = $request->amount;
        $booking->status = $request->status;

        $booking->save();

        $this->sendMail($request->email, $book_id+1);
    }

    public function storeFeedback(Request $request)
    {
        $feedback = new Feedback();
        $feedback->user_id = $request->user_id;
        $feedback->message = $request->message;

        $feedback->save();
    }
}
