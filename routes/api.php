<?php

use App\Http\Controllers\ParkingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/clients', [ParkingController::class, 'getClients']);
Route::get('/bookings', [ParkingController::class, 'getBookings']);
Route::get('/parking-zones', [ParkingController::class, 'getParkings']);
Route::get('/booking/today', [ParkingController::class, 'getTodayBookings']);
Route::get('/booing/active', [ParkingController::class, 'getActiveBookings']);
Route::get('/booing/feedback', [ParkingController::class, 'getClientsFeedback']);
Route::get('/booking/{id}', [ParkingController::class, 'getUserBookings']);

Route::get('/getdate', [ParkingController::class, 'getDate']);

Route::post('/postal', [ParkingController::class, 'getPostal']);

Route::post('/storeuser', [ParkingController::class, 'storeUser']);

Route::post('/storeparking', [ParkingController::class, 'storeParking']);

Route::post('/storebooking', [ParkingController::class, 'storeBooking']);

Route::post('/storefeedback', [ParkingController::class, 'storeFeedback']);

Route::get('/cancel', [ParkingController::class, 'cancelBooking']);








