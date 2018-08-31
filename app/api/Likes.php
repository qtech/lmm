<?php

namespace App\api;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
   	protected $table = "likes";
   	public $primaryKey = "like_id";
}
