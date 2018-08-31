<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;

class BookingsController extends Controller
{
    public function index()
    {
    	$bookings = Booking::orderBy('booking_id','desc')->paginate(10);

    	return view('bookings.main')->with('bookings', $bookings);
    }
}
