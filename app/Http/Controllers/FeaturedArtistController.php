<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Songs;
use App\Albums;
use Validator;
use Storage;
use FFMpeg;
use App\api\SongsInPlaylist;
use App\api\Favourites;
class FeaturedArtistController extends Controller
{
    public function index()
    {
    	$songs = Songs::where(['status'=>4])->orderBy('song_id','desc')->paginate(10);

    	return view('artists.main')->with('songs',$songs);
    }

    public function add()
    {
    	$albums = Albums::all();
    	if(count($albums)>0)
    	{
    		return view('artists.create')->with('albums',$albums);
    	}
    	else
    	{
    		return redirect()->route('artists.index')->with('error','Please add an artist to add song.');
    	}
    	
    }

    public function store(Request $request)
    {
    	if($request->album_id=="null")    	
    	{
    		return redirect()->route('artists.add')->with('error','Please select an Album.')->withInput(['song_name'=>$request->song_name, 'artist_name' => $request->artist_name]);
    	}
    	else
    	{
    		$validator = Validator::make($request->all(),[
	    		'song_name' => 'required|string|max:100',
	    		'artist_name' => 'required|string|max:50',
	    	]);

	    	if($validator->fails())
	    	{
	    		return redirect()->route('artists.add')->withErrors($validator)->withInput([
	    				'song_name' => $request->song_name,
	    				'artist_name' => $request->artist_name
	    			]);
	    	}
	    	else
	    	{
	    		if($request->song_type=="server")
	    		{
	    			$validator = Validator::make($request->all(),[
	    					'song' => 'required',    					
	    				]);

	    			if($validator->fails())
	    			{
	    				return redirect()->route('artists.add')->withErrors($validator)->withInput([
			    				'song_name' => $request->song_name,
			    				'artist_name' => $request->artist_name
			    			]);
	    			}
	    			else
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
	    			}    			
	    		}
	    		else
	    		{
	    			$validator = Validator::make($request->all(),[
	    					'song_url' => 'required|string|max:255',    					
	    				]);

	    			if($validator->fails())
	    			{
	    				return redirect()->route('artists.add')->withErrors($validator)->withInput([
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
				    	}
				    	else
				    	{
				    		return redirect()->route('artists.add')->with('error','Invalid song type. Only "mp3" files are allowed.');
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
	    		else
	    		{
	    			$song_banner = "default_song_banner.png";
	    		}

	    		$addSongstoDB = new Songs; 
	    		$addSongstoDB->album_id = $request->album_id;   		
	    		$addSongstoDB->song_name = $request->song_name;
	    		$addSongstoDB->artist_name = $request->artist_name;
	    		if($request->song_type == "server")
	    		{
	    			$addSongstoDB->song_server_url = $fileNameToStore;
	    		}
	    		else
	    		{
	    			$addSongstoDB->song_url = $song_url;
	    		}
	    		$addSongstoDB->image = $song_banner;
	    		$addSongstoDB->song_time = $convert;
	    		$addSongstoDB->status = 4; 
	    		$addSongstoDB->save();

	    		return redirect()->route('artists.add')->with('success','Featured Artist successfully added.');
	    	}
    	}    	    	
    }

    public function edit($id)
    {
    	$data = array(
    			'song' => Songs::find($id),
    			'albums' => Albums::all()
    		);    	

    	return view('artists.edit')->with($data);
    }


    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(),[
    		'song_name' => 'required|string|max:100',
    		'artist_name' => 'required|string|max:50',
    	]);

    	if($validator->fails())
    	{
    		return redirect()->route('artists.edit',['id'=>$id])->withErrors($validator)->withInput([
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
    				return redirect()->route('artists.edit',['id'=>$id])->withErrors($validator)->withInput([
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
    				return redirect()->route('artists.edit',['id'=>$id])->withErrors($validator)->withInput([
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
			    	}
			    	else
			    	{
			    		return redirect()->route('artists.edit',['id'=>$id])->with('error','Invalid song type. Only "mp3" files are allowed.');
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
    		$addSongstoDB->album_id = $request->album_id;  		
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

    		return redirect()->route('artists.edit',['id'=>$id])->with('success','Song information successfully updated.');
    	}
    }

    public function destroy(Request $request, $id)
    {
    	$song = Songs::find($id);

    	if($song->song_url == NULL)
    	{
    		Storage::delete('public/uploads/'.$song->song_server_url);
    	}

    	Storage::delete('public/uploads/'.$song->image);
    	$deleteFromPlaylist = SongsInPlaylist::where(['song_id'=>$song->song_id])->get();
        if(count($deleteFromPlaylist)>0)
        {
            foreach ($deleteFromPlaylist as $value) 
            {
                $remove = SongsInPlaylist::where(['song_id'=>$value->song_id])->first();
                $remove->delete();
            }
        }
        $deletFromFavs = Favourites::where(['song_id'=>$song->song_id])->get();
        if(count($deletFromFavs)>0)
        {
            foreach ($deletFromFavs as $value) 
            {
                $remove = Favourites::where(['song_id'=>$value->song_id])->first();
                $remove->delete();
            }
        }
    	$song->delete();

    	return redirect()->route('artists.index')->with('success','Featured Artists successfully removed.');
    	
    }
}
