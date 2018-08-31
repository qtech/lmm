<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MusicGenres extends Model
{
    protected $table = "genres";
    public $primaryKey = "genres_id";

    public function songs()
    {
    	return $this->hasMany(Songs::class,'genres_id');
    }
}
