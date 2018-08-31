<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
   	protected $table =  "events";
   	public $primaryKey = "event_id";
}
