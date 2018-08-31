<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\slider;
use App\video_day;
use App\Songs;
use App\api\Likes;
use App\artists_event;
class SliderController extends Controller
{
	public function index()
	{
			$image=slider::all();
			$result=array();
			$video_array=array();
			$audio_array=array();
			foreach ($image as  $value) {
				$arr['image']=url('/')."/storage/uploads/".$value->image;
				array_push($result,$arr);
			}

			// $videos=video_day::orderBy('id','asc')->get();
			// foreach ($videos as $video) 
    		// {
    		// 	$args['video_id'] = $video->id;
    		// 	$args['name'] = $video->name;
    		// 	$args['description'] = $video->description;
    		// 	$args['image'] = url('/')."/core/public/storage/uploads/".$video->image;
            //     $args['banner_image'] = url('/')."/core/public/storage/uploads/".$video->banner_image;
    		// 	$args['video_link'] = $video->video_link;
    		// 	array_push($video_array,$args);
    		// }

    		// $audios=Songs::where('status',7)->orderBy('song_id','asc')->get();

    		//     	foreach ($audios as $audio) 
	    	// {
	    	// 	$audio_arr['song_id'] = $audio->song_id;
	    	// 	$audio_arr['song_name'] = $audio->song_name;
	    	// 	$audio_arr['artist_name'] = $audio->artist_name;
	    	// 	if(empty($audio->song_url))
	    	// 	{
	    	// 		$audio_arr['song_url'] = url('/')."/core/public/storage/uploads/".$audio->song_server_url;
	    	// 	}
	    	// 	else
	    	// 	{
	    	// 		$audio_arr['song_url'] = $audio->song_url;
	    	// 	}
	    	// 	$audio_arr['image'] = url('/')."/core/public/storage/uploads/".$audio->image;
	    	// 	if(empty($audio->genres_id))
	    	// 	{
	    	// 		$audio_arr['genres_id'] = "";	
	    	// 	}
	    	// 	else
	    	// 	{
	    	// 		$audio_arr['genres_id'] = $audio->genres_id;
	    	// 	}
	    	// 	if(empty($audio->album_id))
	    	// 	{
	    	// 		$audio_arr['album_id'] = "";
	    	// 	}
	    	// 	else
	    	// 	{
	    	// 		$audio_arr['album_id'] = $audio->album_id;
	    	// 	}
	    	
            //         $audio_arr['like_status'] = 0;
                
                
    		// 	$audio_arr['total_likes'] = Likes::where(['song_id'=>$audio->song_id,'like_status'=>1])->count();

	    	// 	$audio_arr['song_time'] = $audio->song_time;
	    	// 	array_push($audio_array, $audio_arr);
	    	// }

			$response=array(
				'status'=>1,
				'msg'=>'success',
				'data'=>$result,
				// 'video'=>$video_array,
				// 'audio'=>$audio_array
				);
			return $response;
	}

	public function event()
	{
		$artists=artists_event::all();

		$response=array(
				'status'=>1,
				'msg'=>'success',
				'data'=>$artists,
				);
			return $response;
	}

}
