<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MusicGenres;
use Validator;
use App\api\SongsInPlaylist;
use App\api\Favourites;
use Illuminate\Support\Facades\Storage;
use App\ImageUpload;

class MusicGenresController extends Controller
{
	public function index()
	{
		$allgenres = MusicGenres::paginate(8);
		return view('musicgenres.main')->with('allgenres',$allgenres);
	}

	public function create()
	{
		return view('musicgenres.create');
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(),[
			'genres_name' => 'required|string|max:40',
			'genres_image' => 'image|nullable'
		]);

		if($validator->fails())
		{
			return redirect()->route('musicgenres.create')
							 ->withErrors($validator)
							 ->withInput([
							 	'genres_name' => $request->genres_name,
							]);
		}
		else
		{
			if($request->hasFile('genres_image'))
        	{
				$fileNameToStore = ImageUpload::uploadImage($request,'genres_image');
        	}
        	else
        	{
        		$fileNameToStore = 'default_genres.jpg';
        	}

        	$new_genres = new MusicGenres;
        	$new_genres->genres_name = $request->genres_name;
        	$new_genres->image = $fileNameToStore;
        	$new_genres->save();

        	return redirect()->route('musicgenres.create')->with('success','Music Genres Successfully Added.');
		}

	}

	public function edit($id = null)
	{
		if($id == NULL)
		{
			return redirect()->route('musicgenres.index')->with('error','Please select a genres to update its records.');
		}
		else
		{
			$genres = MusicGenres::find($id);

			return view('musicgenres.edit')->with('genres',$genres);
		}
	}

	public function update(Request $request, $id)
	{
		$validator = Validator::make($request->all(),[
			'genres_name' => 'required|string|max:40',
			'genres_image' => 'image|nullable'
		]);

		if($validator->fails())
		{
			return redirect()->route('musicgenres.edit',['id'=>$id])
							 ->withErrors($validator)
							 ->withInput([
							 	'genres_name' => $request->genres_name,
							]);
		}
		else
		{
			if($request->hasFile('genres_image'))
        	{
        		$fileNameToStore = ImageUpload::uploadImage($request,'genres_image');
        	}
        	
        	$genresUpdate = MusicGenres::find($id);
        	
        	$genresUpdate->genres_name = $request->genres_name;
        	if($request->hasFile('genres_image'))
        	{
        		Storage::delete(getenv('IMG_UPLOAD').$genresUpdate->image);
        		$genresUpdate->image = $fileNameToStore;
        	}
        	$genresUpdate->save();

        	return redirect()->route('musicgenres.edit',['id'=>$id])->with('success','Music genres record successfully changed.');
		}
	}

	public function destroy($id)
	{
		$removeGenres = MusicGenres::find($id);
		Storage::delete(getenv('IMG_UPLOAD').$removeGenres->image);
		$removeGenres->delete();

		return redirect()->route('musicgenres.index')->with('success','Music Genres successfully removed.');
	}
}
