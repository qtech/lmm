<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FFMpeg;
use Storage;
use Validator;
use App\Songs;
use App\Albums;
use App\FeaturedDjs;
use App\api\SongsInPlaylist;
use App\api\Favourites;
class EnglishSinglesController extends Controller
{
    public function index()
    {
    	$songs = Songs::with('dj')->where(['status'=> 3])->orderBy('song_id','desc')->paginate(10);

    	return view('englishsingles.main')->with('songs',$songs);
    }

    public function add()
    {
        $dj = FeaturedDjs::count();
        if($dj == 0)
        {
            return redirect()->route('english.index')->with('error','Please add a dj in order to add songs.');
        }
        else
        {
            $albums = FeaturedDjs::all();
            return view('englishsingles.create')->with('albums',$albums);
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
    		return redirect()->route('english.add')->withErrors($validator)->withInput([
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
    				return redirect()->route('english.add')->withErrors($validator)->withInput([
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
    				return redirect()->route('english.add')->withErrors($validator)->withInput([
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
			    		return redirect()->route('english.add')->with('error','Invalid song type. Only "mp3" files are allowed.');
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
            $addSongstoDB->feature_dj_id = $request->album_id; 		
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
    		$addSongstoDB->status = 3; 
    		$addSongstoDB->save();

    		return redirect()->route('english.add')->with('success','Song successfully added.');
    	}
    }

    public function edit($id)
    {
        $data = array(
                'albums' => FeaturedDjs::all(),
                'song' => Songs::find($id)
            );
    	//$song = Songs::find($id);

    	return view('englishsingles.edit')->with($data);
    }


    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(),[
    		'song_name' => 'required|string|max:100',
    		'artist_name' => 'required|string|max:50',
    	]);

    	if($validator->fails())
    	{
    		return redirect()->route('english.edit',['id'=>$id])->withErrors($validator)->withInput([
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
    				return redirect()->route('english.edit',['id'=>$id])->withErrors($validator)->withInput([
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
    				return redirect()->route('english.edit',['id'=>$id])->withErrors($validator)->withInput([
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
			    		return redirect()->route('english.edit',['id'=>$id])->with('error','Invalid song type. Only "mp3" files are allowed.');
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
            $addSongstoDB->feature_dj_id = $request->album_id; 		
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

    		return redirect()->route('english.edit',['id'=>$id])->with('success','Song information successfully updated.');
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

    	return redirect()->route('english.index')->with('success','Song successfully removed.');
    	
    }

    public function listdjs()    
    {
        $djs = FeaturedDjs::orderBy('feature_dj_id','desc')->paginate(10);

        return view('englishsingles.djs.main')->with('djs',$djs);
    }

    public function addnewdj()
    {
        return view('englishsingles.djs.create');
    }

    public function savedj(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:50',
                'image' => 'required|image',
                'insta_url' => 'required|url|max:255'
            ]);

        if($validator->fails())
        {
            return redirect()->route('english.dj.add')->withErrors($validator)->withInput(['name'=>$request->name]);
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
            else
            {
                $fileNameToStore = "default_image.png";
            }

            $dj = new FeaturedDjs;
            $dj->name = $request->name;
            $dj->insta_url = $request->insta_url;
            $dj->image = $fileNameToStore;
            $dj->save();

            return redirect()->route('english.dj.add')->with('success','Featured Djs information Successfully Added.');
        }
    }

    public function editdj($id)
    {
        $dj = FeaturedDjs::find($id);

        return view('englishsingles.djs.edit')->with('dj',$dj);
    }

    public function updatedj(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:50',
                'image' => 'image|nullable',
                'insta_url' => 'required|url|max:255'
            ]);

        if($validator->fails())
        {
            return redirect()->route('english.dj.edit',['id'=>$id])->withErrors($validator);
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

            $dj = FeaturedDjs::find($id);
            $dj->name = $request->name;
            $dj->insta_url = $request->insta_url;
            if($request->hasFile('image'))
            {
                Storage::delete('public/uploads/'.$dj->image);

                $dj->image = $fileNameToStore;    
            }            
            $dj->save();

            return redirect()->route('english.dj.edit',['id'=>$id])->with('success','Featured Djs information Successfully Updated.');
        }
    }

    public function removedj($id)
    {
        $dj = FeaturedDjs::find($id);
        if(!empty($dj->image))
        {
            Storage::delete('public/uploads/'.$dj->image);
        }

        $dj->delete();

        return redirect()->route('english.dj.main')->with('success','Dj Removed.');
    }
}
