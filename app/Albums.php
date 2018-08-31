<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Albums extends Model
{
    protected $table = "albums";
    public $primaryKey = "album_id";
}
