<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = "gallery";
    public $primaryKey = "gallery_id";

    public function folder()
    {
    	return $this->belongsTo(Images::class, 'folder_id');
    }
}
