<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table = "social_links";
    public $primaryKey = "social_id";
}
