<?php

namespace App\api;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = "comments";
    public $primaryKey = "comment_id";

    protected $fillable = [
    	'u_id','song_id','comment'
    ];
}
