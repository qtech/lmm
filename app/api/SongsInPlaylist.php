<?php

namespace App\api;

use Illuminate\Database\Eloquent\Model;
use App\Songs;
class SongsInPlaylist extends Model
{
    protected $table = "songs_in_playlist";
    public $primaryKey = "sip_id";

    public function songs()
    {
    	return $this->belongsTo(Songs::class, 'song_id');
    }

    public function playlist()
    {
    	return $this->belongsTo(Playlists::class,'playlist_id');
    }
}
