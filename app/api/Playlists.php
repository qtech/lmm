<?php

namespace App\api;

use Illuminate\Database\Eloquent\Model;

class Playlists extends Model
{
    protected $table = "playlist";
    public $primaryKey = "playlist_id";
}
