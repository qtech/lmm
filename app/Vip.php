<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vip extends Model
{
    protected $table = "vip_list";
    public $primaryKey = "vip_id";

    protected $fillable = [
    	'fname',
		'lname',
		'b_name',							
		'b_address',						
		'b_type',							
		'mob_no',						
		'office',						
		'email',							
		'bdate',								
		'description',	
    ];

}
