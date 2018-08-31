<?php

namespace App\api;

use Illuminate\Database\Eloquent\Model;

class NewUser extends Model
{
    protected $table = "appusers";
    public $primaryKey = "user_id";    
}
