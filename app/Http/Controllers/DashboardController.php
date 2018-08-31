<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MusicGenres;
use App\Albums;
use App\Songs;
use App\Video;
use App\Gallery;
use App\Products;
use App\Events;
class DashboardController extends Controller
{
 	public function index()
 	{
 		$data = array(
 			'genres' => MusicGenres::all()->count(),
 			'albums' => Albums::all()->count(),
 			'latinsingles' => Songs::where(['status'=>2 ])->count(),
 			'englishsingles' => Songs::where(['status'=>3 ])->count(),
            'videos' => Video::all()->count(),
            'djproducts' => Products::all()->count(),
 			'gallery' => Gallery::all()->count(),
 			'events' => Events::all()->count()
 		);
 		return view('dashboard.main')->with($data);
 	}
}
