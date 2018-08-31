<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\slider;
use Validator;
use Storage;
class SLider_images extends Controller
{
    //
    public function index()
    {
    	$images=slider::all();

    	return view('slider.show')->with('images',$images);
    }

    public function edit($id)
    {
    	$images=slider::find($id);

    	return view('slider.edit')->with('images',$images);
    }

    public function update(Request $request,$id)
    {
    	$validator = Validator::make($request->all(),[
    		'image' => 'required|image',
    	]);

    	if($validator->fails())
    	{
    		return redirect()->route('slider.edit',['id'=>$id])->withErrors($validator);
    	}
    	else{
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

        		$image=slider::find($id);
        		$image->image=$fileNameToStore;
        		$image->save();

        		return redirect()->route('slider.edit',['id'=>$id])->with('success','Image information successfully updated.');
    	}
    } 

}
