<?php

namespace App\api;

use Illuminate\Database\Eloquent\Model;
use App\Songs;
class Favourites extends Model
{
	protected $table = "favourites";
	public $primaryKey = "fav_id";

    public function songs()
    {
    	return $this->belongsTo(Songs::class, 'song_id');
    }
}
