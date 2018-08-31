<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ArtistBio;
use Validator;
class ArtistBioController extends Controller
{
    public function listArtists()
    {
    	$artists_bio = ArtistBio::with('artists')->orderBy('bio_id','desc')->paginate(10);
    	
    	return view('artistbio.main')->with('artists_bio',$artists_bio);
    }

    public function addBio()
    {
    	$artists = \App\Albums::all();
    	return view('artistbio.add')->with('artists',$artists);
    }

    public function saveBio(Request $request)
    {   
    	$validator = Validator::make($request->all(),[    			
    			'biography' => 'required',
                'insta_url' => 'required|url|max:255',
                'thumb' => 'required|image',
                'banner' => 'required|image',                
    		]);

    	if($validator->fails())
    	{
    		return redirect()->route('artists_bio.add')->withErrors($validator)->withInput([
    			'biography' => $request->biography,
    			'insta_url' => $request->insta_url
    		]);
    	}
    	else
    	{   
    		if($request->album_id == "") 	
    		{
    			return redirect()->route('artist_bio.add')->with('error','Please select an artist to add this biography.');
    		}
    		else
    		{
    			//Thumbnail	
				//Get filename with extension
	    		$fileNameWithExt = $request->file('thumb')->getClientOriginalName();
	    		$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
	    		//Get only file name
	    		$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
	    		$sanitizeFilename = preg_replace('/[^A-Za-z0-9]/u','', strip_tags($filename));
	    		//Get extension
	    		$extension = $request->file('thumb')->getClientOriginalExtension();
	    		//FileName to Store
	    		$fileNameToStore = $sanitizeFilename.'_'.date('Ymdhis').'.'.$extension;
	    		//Upload the image
	    		$path = $request->file('thumb')->storeAs('public/uploads',$fileNameToStore);
	    		   
	    		//Banner	
	    		//Get filename with extension
	    		$fileNameWithExt = $request->file('banner')->getClientOriginalName();
	    		$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
	    		//Get only file name
	    		$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
	    		$sanitizeFilename = preg_replace('/[^A-Za-z0-9]/u','', strip_tags($filename));
	    		//Get extension
	    		$extension = $request->file('banner')->getClientOriginalExtension();
	    		//FileName to Store
	    		$fileNameToStore2 = $sanitizeFilename.'_'.date('Ymdhis').'.'.$extension;
	    		//Upload the image
	    		$path = $request->file('banner')->storeAs('public/uploads',$fileNameToStore2);	

	    		$artists_bio = new ArtistBio;
	    		$artists_bio->album_id = $request->album_id;
	    		$artists_bio->biography = $request->biography;
	    		$artists_bio->insta_url = $request->insta_url;
	    		$artists_bio->thumb = $fileNameToStore;
	    		$artists_bio->banner = $fileNameToStore2;
	    		$artists_bio->save();

	    		return redirect()->route('artists_bio.add')->with('success','Artist Biography Successfully Added.');
    		}    		
    	}
    }

    public function editBio($id)
    {
    	$artists_bio = ArtistBio::find($id);

    	if(count($artists_bio)>0)
    	{
    		$artists = \App\Albums::all();
    		return view('artistbio.edit')->with('artists_bio',$artists_bio)->with('artists',$artists);
    	}
    	else
    	{
    		return redirect()->route('artists_bio.add')->with('error','Invalid Argument Given');
    	}
    }

    public function updateBio(Request $request, $id)
    {
    	$validator = Validator::make($request->all(),[    			
    			'biography' => 'required',
                'insta_url' => 'required|url|max:255',                
    		]);

    	if($validator->fails())
    	{
    		return redirect()->route('artists_bio.edit',['id' => $id])->withErrors($validator);
    	}
    	else
    	{
    		if($request->album_id == "") 	
    		{
    			return redirect()->route('artist_bio.add')->with('error','Please select an artist to add this biography.');
    		}
    		else
    		{
    			if($request->hasFile('thumb'))
	    		{
	    			//Thumbnail	
					//Get filename with extension
		    		$fileNameWithExt = $request->file('thumb')->getClientOriginalName();
		    		$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
		    		//Get only file name
		    		$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
		    		$sanitizeFilename = preg_replace('/[^A-Za-z0-9]/u','', strip_tags($filename));
		    		//Get extension
		    		$extension = $request->file('thumb')->getClientOriginalExtension();
		    		//FileName to Store
		    		$fileNameToStore = $sanitizeFilename.'_'.date('Ymdhis').'.'.$extension;
		    		//Upload the image
		    		$path = $request->file('thumb')->storeAs('public/uploads',$fileNameToStore);
	    		}

	    		if($request->hasFile('banner'))
	    		{
	    			//Banner	
		    		//Get filename with extension
		    		$fileNameWithExt = $request->file('banner')->getClientOriginalName();
		    		$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
		    		//Get only file name
		    		$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
		    		$sanitizeFilename = preg_replace('/[^A-Za-z0-9]/u','', strip_tags($filename));
		    		//Get extension
		    		$extension = $request->file('banner')->getClientOriginalExtension();
		    		//FileName to Store
		    		$fileNameToStore2 = $sanitizeFilename.'_'.date('Ymdhis').'.'.$extension;
		    		//Upload the image
		    		$path = $request->file('banner')->storeAs('public/uploads',$fileNameToStore2);	
	    		}

	    		$artists_bio = ArtistBio::find($id);
	    		$artists_bio->album_id = $request->album_id;
	    		$artists_bio->biography = $request->biography;
	    		$artists_bio->insta_url = $request->insta_url;
	    		if($request->hasFile('thumb'))
	    		{
	    			$artists_bio->thumb = $fileNameToStore;	
	    		}
	    		if($request->hasFile('banner'))
	    		{
	    			$artists_bio->banner = $fileNameToStore2;	
	    		}
	    		$artists_bio->save();

	    		return redirect()->route('artists_bio.edit',['id' => $id])->with('success','Artist Biography Successfully Updated.');
    		}
    	}
    }

    public function deleteBio($id)
    {
    	$bio = ArtistBio::find($id);
    	if(count($bio)>0)
    	{
    		$bio->delete();
    	}

    	return redirect()->route('artists_bio.main')->with('success','Artist Biography Successfully removed');
    }
}
