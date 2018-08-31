<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vip;
class VipsController extends Controller
{
    public function index()
    {
    	$vips = Vip::orderBy('vip_id','desc')->paginate(10);

    	return view('vips.main')->with('vips', $vips);
    }
}
