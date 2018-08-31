<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Images;
use Storage;
use Validator;
class ImagesController extends Controller
{
    public function index()
    {
    	$images = Images::orderBy('folder_id','desc')->paginate(10);
    	return view('images.main')->with('images',$images);
    }

    public function add()
    {
    	return view('images.create');
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    		'folder_name' => 'required|max:50|string',
    		'folder_image' => 'required|image'
    	]);

    	if($validator->fails())
    	{
    		return redirect()->route('images.add')->withErrors($validator)->withInput([
    				'folder_name'=>$request->folder_name]);
    	}
    	else
    	{
    		//Get filename with extension
    		$fileNameWithExt = $request->file('folder_image')->getClientOriginalName();
    		$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
    		//Get only file name
    		$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
            $filename = urlencode($filename);
    		//Get extension
    		$extension = $request->file('folder_image')->getClientOriginalExtension();
    		//FileName to Store
    		$fileNameToStore = $filename.'_'.time().'.'.$extension;
    		//Upload the folder_image
    		$path = $request->file('folder_image')->storeAs('public/uploads',$fileNameToStore);

    		$folder = new Images;
    		$folder->folder_name = $request->folder_name;
    		$folder->folder_image = $fileNameToStore;
    		$folder->save();

    		return redirect()->route('images.add')->with('success','Folder successfully added.');
     	}
    }

    public function edit($id)
    {
    	$image = Images::find($id);

    	return view('images.edit')->with('image',$image);

    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(),[
    		'folder_name' => 'required|max:50|string',
    		'folder_image' => 'nullable|image'
    	]);

    	if($validator->fails())
    	{
    		return redirect()->route('images.edit',['id'=>$id])->withErrors($validator);
    	}
    	else
    	{
    		if($request->hasFile('folder_image'))
    		{
    			//Get filename with extension
	    		$fileNameWithExt = $request->file('folder_image')->getClientOriginalName();
	    		$fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
	    		//Get only file name
	    		$filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
                $filename = urlencode($filename);
	    		//Get extension
	    		$extension = $request->file('folder_image')->getClientOriginalExtension();
	    		//FileName to Store
	    		$fileNameToStore = $filename.'_'.time().'.'.$extension;
	    		//Upload the folder_image
	    		$path = $request->file('folder_image')->storeAs('public/uploads',$fileNameToStore);
    		}
    		

    		$folder = Images::find($id);
    		$folder->folder_name = $request->folder_name;
    		if($request->hasFile('folder_image'))
    		{
    			$folder->folder_image = $fileNameToStore;	
    		}    		
    		$folder->save();

    		return redirect()->route('images.edit',['id'=>$id])->with('success','Folder information successfully updated.');
     	}
    }

    public function destroy($id)
    {
    	$folder = Images::find($id);
    	Storage::delete('public/uploads/'.$folder->folder_image);
    	$folder->delete();

    	return redirect()->route('images.index')->with('success','Folder information and records successfully removed.');
    }
}
