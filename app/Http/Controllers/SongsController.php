<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Songs;
use App\MusicGenres;
use FFMpeg;
use Storage;
use App\ImageUpload;
use App\api\SongsInPlaylist;
use App\api\Favourites;
class SongsController extends Controller
{
    public function index($id = null)
    {
    	if($id == NULL)
    	{    		
    		return redirect()->route('musicgenres.index')->with('error','Not a valid genres. Please select a valid genres to list songs.');
    	}
    	else
    	{
    		$data = array(
    			'genres' => MusicGenres::find($id),
    			'songs'  => Songs::with('genres')->where(['genres_id' => $id,'status' => 1])->orderBy('song_id','desc')->paginate(10)
    		);    		
    		return view('musicgenres.songs.main')->with($data);
    	}
    }

    public function addsongs($id = null)
    {
    	if($id == NULL)
    	{
    		return redirect()->route('musicgenres.index')->with('error','Invalid genres ID. Please try again.');
    	}
    	else
    	{
    		$id = $id;
    		return view('musicgenres.songs.add')->with('id',$id);
    	}
    }

    public function store(Request $request)
    {       	
    	$validator = Validator::make($request->all(),[
    		'song_name' => 'required|string|max:100',
    		'artist_name' => 'required|string|max:50',
    	]);

    	if($validator->fails())
    	{
    		return redirect()->route('songs.add',['id'=>$request->genres_id])->withErrors($validator)->withInput([
    				'song_name' => $request->song_name,
    				'artist_name' => $request->artist_name
    			]);
    	}
    	else
    	{
    		if($request->song_type=="server")
    		{
    			$validator = Validator::make($request->all(),[
    					'song' => 'required|max:60000',    					
    				]);

    			if($validator->fails())
    			{
    				return redirect()->route('songs.add',['id'=>$request->genres_id])->withErrors($validator)->withInput([
		    				'song_name' => $request->song_name,
		    				'artist_name' => $request->artist_name
		    			]);
    			}
    			else
    			{    				
					$fileNameToStore = ImageUpload::uploadImage($request,'song');

	        		$media = FFMpeg::open(getenv('IMG_UPLOAD').$fileNameToStore);
	        		
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
    				return redirect()->route('songs.add',['id'=>$request->genres_id])->withErrors($validator)->withInput([
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
			    		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
                        $context = stream_context_create($opts);
                        $getTheFile = file_get_contents($song_url,false,$context);

                        file_put_contents('/home/ubuntu/projects/wjjackson/storage/app/public/uploads/'.$getFileName, $getTheFile);
	    				
	    				try
                        {
                            $media = FFMpeg::open(getenv('IMG_UPLOAD').$getFileName);

                            $durationInSeconds = $media->getDurationInSeconds(); // returns an int

                            $convert = gmdate('H:i:s',$durationInSeconds);

                            Storage::delete(getenv('IMG_UPLOAD').$getFileName);
                        }
                        catch(\Exception $e)
                        {
                            return redirect()->route('songs.add',['id'=>$request->genres_id])->with('error',$e->getMessage());
                        }
			    	}
			    	else
			    	{
			    		return redirect()->route('songs.add',['id'=>$request->genres_id])->with('error','Invalid song type. Only "mp3" files are allowed.');
			    	}
    			}
    		}

    		if($request->hasFile('song_banner'))
    		{
    			$song_banner = ImageUpload::uploadImage($request,'song_banner');
    		}
    		else
    		{
    			$song_banner = "default_song_banner.png";
    		}

    		$addSongstoDB = new Songs;
    		$addSongstoDB->genres_id = $request->genres_id;
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
    		$addSongstoDB->status = 1;
    		$addSongstoDB->save();

    		return redirect()->route('songs.add',['id'=>$request->genres_id])->with('success','Song successfully added.');
    	}
    }

    public function edit($id)
    {
    	$song = Songs::find($id);

    	return view('musicgenres.songs.edit')->with('song',$song);
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(),[
    		'song_name' => 'required|string|max:100',
    		'artist_name' => 'required|string|max:50',
    	]);

    	if($validator->fails())
    	{
    		return redirect()->route('songs.edit',['id'=>$id])->withErrors($validator)->withInput([
    				'song_name' => $request->song_name,
    				'artist_name' => $request->artist_name
    			]);
    	}
    	else
    	{
    		if($request->song_type=="server")
    		{
    			$validator = Validator::make($request->all(),[
    					'song' => 'nullable|max:60000',    					
    				]);

    			if($validator->fails())
    			{
    				return redirect()->route('songs.edit',['id'=>$id])->withErrors($validator)->withInput([
		    				'song_name' => $request->song_name,
		    				'artist_name' => $request->artist_name
		    			]);
    			}
    			else
    			{    	
    				if($request->hasFile('song'))	
    				{
						$fileNameToStore = ImageUpload::uploadImage($request,'song');
						
		        		$media = FFMpeg::open(getenv('IMG_UPLOAD').$fileNameToStore);
		        		
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
    				return redirect()->route('songs.edit',['id'=>$id])->withErrors($validator)->withInput([
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
			    		$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
                        $context = stream_context_create($opts);
                        $getTheFile = file_get_contents($song_url,false,$context);

                        file_put_contents('/home/ubuntu/projects/wjjackson/storage/app/public/uploads/'.$getFileName, $getTheFile);	
                        try
                        {
                            $media = FFMpeg::open(getenv('IMG_UPLOAD').$getFileName);
                        
                            $durationInSeconds = $media->getDurationInSeconds(); // returns an int
                            
                            $convert = gmdate('H:i:s',$durationInSeconds);

                            Storage::delete(getenv('IMG_UPLOAD').$getFileName);
                        } 
                        catch (\Exception $e) {
                            return redirect()->route('songs.edit',['id'=>$id])->with('error',$e->getMessage());
                        }                       
			    	}
			    	else
			    	{
			    		return redirect()->route('songs.edit',['id'=>$id])->with('error','Invalid song type. Only "mp3" files are allowed.');
			    	}
    			}
    		}

    		if($request->hasFile('song_banner'))
    		{    			
    			$song_banner = ImageUpload::uploadImage($request,'song_banner');
    		}    		

    		$addSongstoDB = Songs::find($id);    		
    		$addSongstoDB->song_name = $request->song_name;
    		$addSongstoDB->artist_name = $request->artist_name;
    		if($request->hasFile('song'))
    		{
    			if($addSongstoDB->song_server_url!= NULL)
                {
                    Storage::delete(getenv('IMG_UPLOAD').$addSongstoDB->song_server_url);    
                } 
    			$addSongstoDB->song_server_url = $fileNameToStore;
    			$addSongstoDB->song_time = $convert;
    			$addSongstoDB->song_url = NULL;

    		}
    		if($request->has('song_url'))    		
    		{
                if($addSongstoDB->song_server_url!= NULL)
                {
                    Storage::delete(getenv('IMG_UPLOAD').$addSongstoDB->song_server_url);    
                } 
    			$addSongstoDB->song_url = $song_url;
    			$addSongstoDB->song_time = $convert;
    			$addSongstoDB->song_server_url = NULL;
    		}    		
    		if($request->hasFile('song_banner'))
    		{
    			Storage::delete(getenv('IMG_UPLOAD').$addSongstoDB->image);
    			$addSongstoDB->image = $song_banner;	
    		}    		
    		
    		$addSongstoDB->save();

    		return redirect()->route('songs.edit',['id'=>$id])->with('success','Song information successfully updated.');
    	}
    }

    public function destroy(Request $request, $id)
    {
    	$song = Songs::find($id);

    	if($song->song_url == NULL)
    	{
    		Storage::delete(getenv('IMG_UPLOAD').$song->song_server_url);
    	}

    	Storage::delete(getenv('IMG_UPLOAD').$song->image);
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

    	return redirect()->route('songs.index',['id'=>$request->genres_id])->with('success','Song successfully removed.');
    	
    }
}
