<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = "booking";
    public $primaryKey = "booking_id";

    protected $fillable = [
    	'name', 
		'mob_no',	 	
		'email', 	
		'date',		
		'time', 	
		'address',	
		'city', 	
		'state', 	
		'country', 	
		'zip',	
		'party_type', 	
		'user_id', 
		'artist_name'
	];
}
