<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Albums;
use Validator;
use Storage;
use App\ImageUpload;
class AlbumsController extends Controller
{
    public function index()
    {
    	$albums = Albums::orderBy('album_id','desc')->paginate(10);
    	return view('albums.main')->with('albums',$albums);
    }

    public function add()
    {
    	return view('albums.create');
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    			'album_name' => 'required|string|max:50',
    			'album_image' => 'required|image'
    		]);

    	if($validator->fails())
    	{
    		return redirect()->route('albums.add')->withErrors($validator)->withInput(['album_name'=>$request->album_name]);
    	}
    	else
    	{
    		if($request->hasFile('album_image'))
    		{
    			$fileNameToStore = ImageUpload::uploadImage($request,'album_image');
    		}
    		else
    		{
    			$fileNameToStore = "default_album_image.png";
    		}

    		$album = new Albums;
    		$album->album_name = $request->album_name;
    		$album->image = $fileNameToStore;
    		$album->save();

    		return redirect()->route('albums.add')->with('success','Artist Successfully Added.');
    	}
    }

    public function edit($id)
    {
    	$album = Albums::find($id);
    	return view('albums.edit')->with('album',$album);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
                'album_name' => 'required|string|max:50',
                'album_image' => 'image|nullable',
            ]);

        if($validator->fails())
        {
            return redirect()->route('albums.edit',['id'=>$id])->withErrors($validator)->withInput(['album_name'=>$request->album_name]);
        }
        else
        {
            if($request->hasFile('album_image'))
            {
                $fileNameToStore = ImageUpload::uploadImage($request,'album_image');
            }            

            $album = Albums::find($id);
            $album->album_name = $request->album_name;
            if($request->hasFile('album_image'))
            {
                Storage::delete(getenv('IMG_UPLOAD').$album->image);
                $album->image = $fileNameToStore;
            }
            $album->save();

            return redirect()->route('albums.edit',['id'=>$id])->with('success','Artist Information Successfully Updated.');
        }
    }

    public function destroy($id)
    {
        $album = Albums::find($id);
        if($album->image != NULL)
        {
            Storage::delete(getenv('IMG_UPLOAD').$album->image);            
        }

        $album->delete();

        return redirect()->route('albums.index')->with('success','Artist Successfully Removed.');
    }
}
