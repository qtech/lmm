<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public $table = "products";

    protected $primaryKey = "product_id";
    protected $fillable = ['product_name','product_image','product_price'];
}
