<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArtistBio extends Model
{
    public $table = "artist_bio";
    protected $primaryKey = "bio_id";

    public function artists()
    {
    	return $this->belongsTo('App\Albums','album_id');
    }
}
