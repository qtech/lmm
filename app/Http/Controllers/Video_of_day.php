<?php

namespace App\Http\Controllers;
use App\video_day;
use Illuminate\Http\Request;
use Validator;
use Storage;
class Video_of_day extends Controller
{
    //
    public function index()
    {
    	$videos = video_day::orderBy('id', 'desc')->get();

    	return view('videos_day.show')->with('videos',$videos);
    }
      public function add()
    {
    	return view('videos_day.add');
    }


    public function edit($id)
    {
        $video = video_day::find($id);

        return view('videos_day.edit')->with('video', $video);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(),[
            'video_name' => 'required|string|max:75' ,
            'video_image' => 'nullable|image',
            'banner_image' => 'nullable|image',
            'description' => 'required'
        ]);
       
        if($validator->fails())
        {
            return redirect()->route('videos.edit',['id'=>$id])->withErrors($validator);
        }
        else
        {           
            // if(filter_var($request->video_link, FILTER_VALIDATE_URL)===FALSE)
            // {
            //  return redirect()->route('videos.edit',['id'=>$id])->with('error','Invalid Video link URL. Please try again with a valid URL for video link.');
            // }
            // else
            // {
                if($request->hasFile('video_image'))
                {
                    //Get filename with extension
                    $fileNameWithExt = $request->file('video_image')->getClientOriginalName();
                    $fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);             
                    //Get only file name
                    $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
                    $filename = urlencode($filename);
                    //Get extension
                    $extension = $request->file('video_image')->getClientOriginalExtension();
                    //FileName to Store
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    //Upload the image
                    $path = $request->file('video_image')->storeAs('public/uploads',$fileNameToStore);
                }
                
                if($request->hasFile('banner_image'))
                {
                     //Get filename with extension
                    $fileNameWithExt_inner = $request->file('banner_image')->getClientOriginalName();
                    $fileNameWithExt_inner = str_replace(" ", "_", $fileNameWithExt_inner);             
                    //Get only file name
                    $filename_inner = pathinfo($fileNameWithExt_inner, PATHINFO_FILENAME);
                    $filename_inner = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename_inner);
                    $filename_inner = urlencode($filename_inner);
                    //Get extension
                    $extension_inner = $request->file('banner_image')->getClientOriginalExtension();
                    //FileName to Store
                    $fileNameToStore_inner = $filename_inner.'_'.time().'.'.$extension_inner;
                    //Upload the image
                    $path = $request->file('banner_image')->storeAs('public/uploads',$fileNameToStore_inner);
                }

                $video = video_day::find($id);
                $video->name = $request->video_name;
                $video->description = $request->description;
                 if($request->video_link!='')
                {
                $video->video_link = $request->video_link;
                }
                else{
                    $whatIWant = substr($request->video_link_embeded, strpos($request->video_link_embeded, "src=") +5); 
                    $link = strtok($whatIWant, '"'); 
                  $video->video_link = $link;  
                }               
                if($request->hasFile('video_image'))
                {
                    Storage::delete('public/uploads/'.$video->image);
                    $video->image = $fileNameToStore;   
                }
                if($request->hasFile('banner_image'))
                {
                    Storage::delete('public/uploads/'.$video->banner_image);
                    $video->banner_image = $fileNameToStore_inner;   
                }               
                $video->save();

                return redirect()->route('videos-of-the-day.edit',['id'=>$id])->with('success','Video information successfully updated.');
            //}         
        }
    }

}
