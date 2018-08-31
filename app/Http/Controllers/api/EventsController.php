<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events;
use App\Images;
use App\Gallery;
use App\Video;
use App\Vip;
class EventsController extends Controller
{
    public function index()
    {
    	$events = Events::orderBy('event_id','desc')->get();

    	if(count($events)>0)
    	{
    		$temp = array();

    		foreach ($events as $value) 
    		{
    			$args['event_id'] = $value->event_id;
    			$args['title'] = $value->title;
    			$args['description'] = $value->description;
    			$args['start'] = $value->start;
    			$args['end'] = $value->end;
    			$args['time'] = $value->time;
    			$args['latitude'] = $value->latitude;
    			$args['longitude'] = $value->longitude;
    			$args['address'] = $value->address;
    			$args['image'] = url('/')."/storage/uploads/".$value->image;
    			array_push($temp, $args);
    		}

    		$response = array(
    				'status' => 1,
    				'msg' => 'List of events.',
    				'data' => $temp
    			);
    	}
    	else
    	{
    		$response = array(
    				'status' => 0,
    				'msg' => 'No events found.'
    			);
    	}

    	return $response;
    }

    public function folders()
    {
    	$folders = Images::orderBy('folder_id','desc')->get();
    	if(count($folders)>0)
    	{
    		$temp = array();

    		foreach ($folders as $value) 
    		{
   	 			$args['folder_id'] = $value->folder_id;
   	 			$args['folder_name'] = $value->folder_name;
   	 			$args['folder_image'] = url('/')."/storage/uploads/".$value->folder_image;
   	 			array_push($temp,$args);
       		}

       		$response = array(
       			'status' => 1,
       			'msg' => 'List of image folders.',
       			'data' => $temp
       		 );
    	}
    	else
    	{
    		$response = array(
    			'status' => 0,
    			'msg' => 'No Image folders found.'
    		 );
    	}

    	return $response;
    }

    public function images()
    {	    	
    	$images = Gallery::orderBy('gallery_id','desc')->get();

    	if(count($images)>0)
    	{	
    		$temp = [];

    		foreach ($images as $value) 
    		{
    			$args['gallery_id'] = $value->gallery_id;    			
    			$args['image'] = url('/')."/storage/uploads/".$value->image;
    			array_push($temp,$args);    			
    		}

    		$response = array(
    				'status' => 1,
    				'msg' => 'List of images.',
    				'data' => $temp
    			);
    	}
    	else
    	{
    		$response = array(
    			'status' => 0, 
    			'msg' => 'No images available.'
    		);
    	}

    	return $response;
    }

    public function videos()
    {
    	$videos = Video::orderBy('video_id','desc')->get();

    	if(count($videos)>0)
    	{
    		$temp = array();

    		foreach ($videos as $value) 
    		{
    			$args['video_id'] = $value->video_id;
    			$args['name'] = $value->name;
    			$args['date'] = $value->date;
    			$args['image'] = url('/')."/storage/uploads/".$value->image;
    			$args['video_link'] = $value->video_link;
    			array_push($temp,$args);
    		}

    		$response = array(
    				'status' => 1,
    				'msg' =>'List of vidoes.',
    				'data' => $temp
    			);    		
    	}
    	else
    	{	
    		$response = array(
    				'status' => 0,
    				'msg' => 'No videos found.'
    			);
    	}

    	return $response;
    }

    public function vip_signup(Request $request)
    {
    	$vip_signup = Vip::create($request->all());

    	$response = array(
    		'status' => 1,
    		'msg' => 'Thank you for signing up.'
    	);

    	return $response;
    }
}
