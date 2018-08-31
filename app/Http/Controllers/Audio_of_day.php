<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Songs;
use Validator;
use FFMpeg;
use Storage;
use App\api\SongsInPlaylist;
use App\api\Favourites;
class Audio_of_day extends Controller
{
    //
    public function index()
    {
    	$songs = Songs::where('status',7)->get();

    	return view('audio_day.show')->with('songs',$songs);
    }

    public function edit($id)
    {
    	$song = Songs::find($id);

    	return view('audio_day.edit')->with('song',$song);
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(),[
    		'song_name' => 'required|string|max:100',
    		'artist_name' => 'required|string|max:50',
    	]);

    	if($validator->fails())
    	{
    		return redirect()->route('audio-of-the-day.edit',['id'=>$id])->withErrors($validator)->withInput([
    				'song_name' => $request->song_name,
    				'artist_name' => $request->artist_name
    			]);
    	}
    	else
    	{
    		if($request->song_type=="server")
    		{
    			$validator = Validator::make($request->all(),[
    					'song' => 'nullable',    					
    				]);

    			if($validator->fails())
    			{
    				return redirect()->route('audio-of-the-day.edit',['id'=>$id])->withErrors($validator)->withInput([
		    				'song_name' => $request->song_name,
		    				'artist_name' => $request->artist_name
		    			]);
    			}
    			else
    			{    	
    				if($request->hasFile('song'))	
    				{
    					//Get filename with extension
		        		$fileNameWithExt = $request->file('song')->getClientOriginalName();
		        		$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);  
		        		//Get only file name
		        		$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                        $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
                        $filename = urlencode($filename);
		        		//Get extension
		        		$extension = $request->file('song')->getClientOriginalExtension();
		        		//FileName to Store
		        		$fileNameToStore = $filename.'_'.time().'.'.$extension;
		        		//Upload the image
		        		$path = $request->file('song')->storeAs('public/uploads',$fileNameToStore);

		        		$media = FFMpeg::open('public/uploads/'.$fileNameToStore);
		        		
		        		$durationInSeconds = $media->getDurationInSeconds(); // returns an int
		        		
		        		$convert = gmdate('H:i:s',$durationInSeconds);

		        		FFMpeg::cleanupTemporaryFiles();
    				}	
    			}    			
    		}
    		else
    		{
    			$validator = Validator::make($request->all(),[
    					'song_url' => 'required|string|max:255',    					
    				]);

    			if($validator->fails())
    			{
    				return redirect()->route('audio-of-the-day.edit',['id'=>$id])->withErrors($validator)->withInput([
		    				'song_name' => $request->song_name,
		    				'artist_name' => $request->artist_name
		    			]);
    			}
    			else
    			{
    				$song_url = $request->song_url;

			    	$getExt = strrpos($song_url, ".");

			    	$getExt = substr($song_url, (int)$getExt+1,strlen($song_url));

			    	$start = strrpos($song_url,"/");

			    	$end = strrpos($song_url,".");

			    	$getFileName = substr($song_url, (int)$start+1);
			    	$getFileName = substr($getFileName,0,strrpos($getFileName,".")-1);
			    	$getFileName = str_replace(" ", "_", $getFileName);
			    	$getFileName = str_replace("-", "_", $getFileName);
			    	$getFileName = $getFileName."_".time().".".$getExt;
			    	
			    	if($getExt=="mp3")
			    	{
			    		$ch = curl_init($song_url);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_NOBODY, 0);
						curl_setopt($ch, CURLOPT_TIMEOUT, 5);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);		
						$output = curl_exec($ch);
						$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
						curl_close($ch);		

						Storage::put('public/uploads/'.$getFileName, $output);		  
	    				
	    				$media = FFMpeg::open('public/uploads/'.$getFileName);
		        		
		       			$durationInSeconds = $media->getDurationInSeconds(); // returns an int
		        		
		       			$convert = gmdate('H:i:s',$durationInSeconds);

		       			Storage::delete('public/uploads/'.$getFileName);

		       			FFMpeg::cleanupTemporaryFiles();
			    	}
			    	else
			    	{
			    		return redirect()->route('audio-of-the-day.edit',['id'=>$id])->with('error','Invalid song type. Only "mp3" files are allowed.');
			    	}
    			}
    		}

    		if($request->hasFile('song_banner'))
    		{    			
    			//Get filename with extension
	    		$fileNameWithExt = $request->file('song_banner')->getClientOriginalName();
	    		$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
	    		//Get only file name
	    		$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
                $filename = urlencode($filename);
	    		//Get extension
	    		$extension = $request->file('song_banner')->getClientOriginalExtension();
	    		//FileName to Store
	    		$song_banner = $filename.'_'.time().'.'.$extension;
	    		//Upload the image
	    		$path = $request->file('song_banner')->storeAs('public/uploads',$song_banner);
    		}    		

    		$addSongstoDB = Songs::find($id);    		
    		$addSongstoDB->song_name = $request->song_name;
    		$addSongstoDB->artist_name = $request->artist_name;
    		if($request->hasFile('song'))
    		{
    			if($addSongstoDB->song_server_url!= NULL)
    			{
    				Storage::delete('public/uploads/'.$addSongstoDB->song_server_url);	
    			}    			
    			$addSongstoDB->song_server_url = $fileNameToStore;
    			$addSongstoDB->song_time = $convert;
    			$addSongstoDB->song_url = NULL;

    		}
    		if($request->has('song_url'))    		
    		{
    			if($addSongstoDB->song_server_url!= NULL)
    			{
    				Storage::delete('public/uploads/'.$addSongstoDB->song_server_url);	
    			} 
    			$addSongstoDB->song_url = $song_url;
    			$addSongstoDB->song_time = $convert;
    			$addSongstoDB->song_server_url = NULL;
    		}    		
    		if($request->hasFile('song_banner'))
    		{
    			Storage::delete('public/uploads/'.$addSongstoDB->image);
    			$addSongstoDB->image = $song_banner;	
    		}    		
    		
    		$addSongstoDB->save();

    		return redirect()->route('audio-of-the-day.edit',['id'=>$id])->with('success','Song information successfully updated.');
    	}
    }
}
