<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Images;
use Validator;
use Storage;

class GallerysController extends Controller
{
    public function index()
    {
    	$galleries = Gallery::with('folder')->orderBy('gallery_id', 'desc')->paginate(10);
    	return view('gallery.main')->with('galleries', $galleries);
    }

    public function add()
    {
    	$folders = Images::all();
    	return view('gallery.create')->with('folders', $folders);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'gallery_image' => 'required|image'
        ]);

        if($validator->fails())
        {
            return redirect()->route('gallerys.add')->withErrors($validator);
        }
        else
        {
            //Get filename with extension
            $fileNameWithExt = $request->file('gallery_image')->getClientOriginalName();
            $fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
            //Get only file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
            $filename = urlencode($filename);
            //Get extension
            $extension = $request->file('gallery_image')->getClientOriginalExtension();
            //FileName to Store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload the image
            $path = $request->file('gallery_image')->storeAs('public/uploads',$fileNameToStore);

            $gallery = new Gallery;
            $gallery->image = $fileNameToStore;
            $gallery->save();

            return redirect()->route('gallerys.index')->with('success','Image successfully added.');
        }
    	
    }

    // public function edit($id)
    // {
    // 	$data = array(
    // 			'gallery' => Gallery::with('folder')->find($id)
    // 		);    
    	
    // 	return view('gallery.edit')->with($data);
    // }

    // public function update(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(),[
    //             'gallery_image' => 'nullable|image'
    //     ]);

    //     if($validator->fails())
    //     {
    //         return redirect()->route('gallerys.edit',['id'=>$id])->withErrors($validator);
    //     }
    //     else
    //     {
    //         if($request->hasFile('gallery_image'))
    //         {
    //             //Get filename with extension
    //             $fileNameWithExt = $request->file('gallery_image')->getClientOriginalName();
    //             $fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);        		
    //             //Get only file name
    //             $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
    //             $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
    //             $filename = urlencode($filename);
    //             //Get extension
    //             $extension = $request->file('gallery_image')->getClientOriginalExtension();
    //             //FileName to Store
    //             $fileNameToStore = $filename.'_'.time().'.'.$extension;
    //             //Upload the image
    //             $path = $request->file('gallery_image')->storeAs('public/uploads',$fileNameToStore);
    //         }
            
    //         $gallery = Gallery::find($id);
    //         if($request->hasFile('gallery_image'))
    //         {
    //             Storage::delete('public/uploads/'.$gallery->image);
    //             $gallery->image = $fileNameToStore;	

    //         }        		
    //         $gallery->save();

    //         return redirect()->route('gallerys.index',['id'=>$id])->with('success','Image information successfully updated.');
    //     }
    	
    // }

    public function destroy($id)
    {
    	$gallery = Gallery::find($id);
    	Storage::delete('public/uploads/'.$gallery->image);
    	$gallery->delete();

    	return redirect()->route('gallerys.index')->with('success','Image deleted.');
    }
}
