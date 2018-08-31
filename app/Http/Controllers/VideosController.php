<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use Validator;
use Storage;
class VideosController extends Controller
{
    public function index()
    {
    	$videos = Video::orderBy('video_id', 'desc')->paginate(10);

    	return view('videos.main')->with('videos',$videos);
    }

    public function add()
    {
    	return view('videos.create');
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    		'video_name' => 'required|string|max:75' ,
    		'video_link' => 'required|max:255',
    		'video_image' => 'required|image'
    	]);

    	if($validator->fails())
    	{
    		return redirect()->route('videos.add')->withErrors($validator)->withInput([
    				'video_name' => $request->video_name ,
		    		'video_link' => $request->video_link
    			]);
    	}
    	else
    	{    		
    		if(filter_var($request->video_link, FILTER_VALIDATE_URL)===FALSE)
    		{
    			return redirect()->route('videos.add')->with('error','Invalid Video link URL. Please try again with a valid URL for video link.')->withInput([
    					'video_name' => $request->video_name ,
		    			'video_link' => $request->video_link
    			]);
    		}
    		else
    		{
    			//Get filename with extension
	    		$fileNameWithExt = $request->file('video_image')->getClientOriginalName();
	    		$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
	    		//Get only file name
	    		$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
                $filename = urlencode($filename);
	    		//Get extension
	    		$extension = $request->file('video_image')->getClientOriginalExtension();
	    		//FileName to Store
	    		$fileNameToStore = $filename.'_'.time().'.'.$extension;
	    		//Upload the image
	    		$path = $request->file('video_image')->storeAs('public/uploads',$fileNameToStore);

	    		$video = new Video;
	    		$video->name = $request->video_name;
	    		$video->video_link = $request->video_link;
	    		$video->date = date("Y-m-d");
	    		$video->image = $fileNameToStore;
	    		$video->save();

	    		return redirect()->route('videos.add')->with('success','Video successfully added.');
    		}    		
    	}
    }

    public function edit($id)
    {
    	$video = Video::find($id);

    	return view('videos.edit')->with('video', $video);
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(),[
    		'video_name' => 'required|string|max:75' ,
    		'video_link' => 'required|max:255',
    		'video_image' => 'nullable|image'
    	]);

    	if($validator->fails())
    	{
    		return redirect()->route('videos.edit',['id'=>$id])->withErrors($validator);
    	}
    	else
    	{    		
    		if(filter_var($request->video_link, FILTER_VALIDATE_URL)===FALSE)
    		{
    			return redirect()->route('videos.edit',['id'=>$id])->with('error','Invalid Video link URL. Please try again with a valid URL for video link.');
    		}
    		else
    		{
    			if($request->hasFile('video_image'))
    			{
    				//Get filename with extension
		    		$fileNameWithExt = $request->file('video_image')->getClientOriginalName();
		    		$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
		    		//Get only file name
		    		$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
                    $filename = urlencode($filename);
		    		//Get extension
		    		$extension = $request->file('video_image')->getClientOriginalExtension();
		    		//FileName to Store
		    		$fileNameToStore = $filename.'_'.time().'.'.$extension;
		    		//Upload the image
		    		$path = $request->file('video_image')->storeAs('public/uploads',$fileNameToStore);
    			}
    			
	    		$video = Video::find($id);
	    		$video->name = $request->video_name;
	    		$video->video_link = $request->video_link;	    		
	    		if($request->hasFile('video_image'))
	    		{
	    			Storage::delete('public/uploads/'.$video->image);
	    			$video->image = $fileNameToStore;	
	    		}	    		
	    		$video->save();

	    		return redirect()->route('videos.edit',['id'=>$id])->with('success','Video information successfully updated.');
    		}    		
    	}
    }

    public function destroy($id)
    {
    	$video = Video::find($id);
    	Storage::delete('public/uploads/'.$video->image);
    	$video->delete();

    	return redirect()->route('videos.index')->with('success','Video information and image successfully removed.');
    }
}
