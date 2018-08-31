<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Songs extends Model
{
    protected $table = "songs";
    public $primaryKey = "song_id";

    public function genres()
    {
    	return $this->belongsTo(MusicGenres::class,'genres_id');
    }
    
    public function albums()
    {
    	return $this->belongsTo(Albums::class, 'album_id');
    }

    public function dj()
    {
        return $this->belongsTo(FeaturedDjs::class,'feature_dj_id');
    }
}


