<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events;
use Validator;
use Storage;

class EventsController extends Controller
{
    public function index()
    {
    	$events = Events::orderBy('event_id','desc')->paginate(10);
    	return view('events.main')->with('events', $events);
    }

    public function add()
    {
    	return view('events.create');
    }

    public function store(Request $request)
    {	
    	
    	$validator = Validator::make($request->all(),[
    			'event_title' => 'required|string|max:150',
    			'description' => 'required',
    			'event_time' => 'required|max:10',
    			'address' => 'required|string|max:255',
    			'image' => 'required|image'
    		]);
    	if($validator->fails())
    	{
    		return redirect()->route('events.add')->withErrors($validator)->withInput([
    				'event_title' => $request->event_title,
    			'description' => $request->description,
    			'event_time' => $request->event_time,
    			'address' => $request->address,
    			'daterange' => $request->daterange
    			]);
    	}
    	else
    	{
    		//Get filename with extension
    		$fileNameWithExt = $request->file('image')->getClientOriginalName();
    		$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
    		//Get only file name
    		$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
    		$filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
			$filename = urlencode($filename);
    		//Get extension
    		$extension = $request->file('image')->getClientOriginalExtension();
    		//FileName to Store
    		$fileNameToStore = $filename.'_'.time().'.'.$extension;
    		//Upload the image
    		$path = $request->file('image')->storeAs('public/uploads',$fileNameToStore);

    		$address = str_replace(" ", "+" , $request->address);
			$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=India";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);		
			curl_close($ch);
			$response_a = json_decode($response);

			if($response_a->status == "OK")
			{				
				$lat = $response_a->results[0]->geometry->location->lat;		
				$long = $response_a->results[0]->geometry->location->lng;

				$splitDate = explode("-", $request->daterange);
		    	$start = $splitDate[0];
		    	$end = $splitDate[1];		    	

				$event = new Events;
				$event->title = $request->event_title;
				$event->description = strip_tags($request->description);
				$event->start = $start;
				$event->end = $end;
				$event->time = $request->event_time;
				$event->latitude = $lat;
				$event->longitude = $long;
				$event->address = $request->address;
				$event->image = $fileNameToStore;
				$event->status = 0;
				$event->save();

				return redirect()->route('events.add')->with('success','Events information has been successfully saved.');
			}
			else
			{
				return redirect()->route('events.add')->with('error','Invalid address. Please enter correct address.')->withInput([
    				'event_title' => $request->event_title,
	    			'description' => $request->description,
	    			'event_time' => $request->event_time,
	    			'address' => $request->address,
	    			'daterange' => $request->daterange
    			]);
			}
    	}
    }

    public function edit($id)
    {
    	$event = Events::find($id);
    	
    	return view('events.edit')->with('event',$event);
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(),[
    			'event_title' => 'required|string|max:150',
    			'description' => 'required',
    			'event_time' => 'required|max:10',
    			'address' => 'required|string|max:255',
    			'image' => 'image|nullable'
    		]);

    	if($validator->fails())
    	{
    		return redirect()->route('events.edit',['id'=>$id])->withErrors($validator);
    	}
    	else
    	{
    		if($request->hasFile('image'))
    		{
    			//Get filename with extension
	    		$fileNameWithExt = $request->file('image')->getClientOriginalName();
	    		$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
	    		//Get only file name
	    		$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
	    		$filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
				$filename = urlencode($filename);
	    		//Get extension
	    		$extension = $request->file('image')->getClientOriginalExtension();
	    		//FileName to Store
	    		$fileNameToStore = $filename.'_'.time().'.'.$extension;
	    		//Upload the image
	    		$path = $request->file('image')->storeAs('public/uploads',$fileNameToStore);
    		}

    		$address = str_replace(" ", "+" , $request->address);
			$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=India";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);		
			curl_close($ch);
			$response_a = json_decode($response);

			if($response_a->status == "OK")
			{				
				$lat = $response_a->results[0]->geometry->location->lat;		
				$long = $response_a->results[0]->geometry->location->lng;

				$splitDate = explode("-", $request->daterange);
		    	$start = $splitDate[0];
		    	$end = $splitDate[1];		    	

				$event = Events::find($id);
				$event->title = $request->event_title;
				$event->description = strip_tags($request->description);
				$event->start = $start;
				$event->end = $end;
				$event->time = $request->event_time;
				if($request->address != $event->address)
				{
					$event->latitude = $lat;
					$event->longitude = $long;
				}				
				$event->address = $request->address;
				if($request->hasFile('image'))
				{
					$event->image = $fileNameToStore;
				}								
				$event->save();

				return redirect()->route('events.edit',['id'=>$id])->with('success','Events information has been successfully updated.');
			}
			else
			{
				return redirect()->route('events.edit',['id'=>$id])->with('error','Invalid address. Please enter correct address.');
			}
    	}
    }

    public function destroy($id)
    {
    	$event = Events::find($id);
    	Storage::delete('public/uploads/'.$event->image);
    	$event->delete();

    	return redirect()->route('events.index')->with('success','Event information and all related images have been successfully removed.');
    }
}
