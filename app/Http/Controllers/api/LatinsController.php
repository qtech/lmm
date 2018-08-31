<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Songs;
use App\api\NewUser;
use App\api\Likes;
class LatinsController extends Controller
{
    public function list(Request $request)
    {
    	$checkUser = NewUser::where(['u_id'=>$request->u_id])->first();

    	if(count($checkUser)>0)
    	{
    		$songs = Songs::where(['status'=>2])->orderBy('song_id','desc')->get();
    		if(count($songs)>0)
    		{
    			$temp = array();

    			foreach ($songs as $value) {
	    			$args['song_id'] = $value->song_id;
	    			$args['song_name'] = $value->song_name;
	    			$args['artist_name'] = $value->artist_name;
	    			if(empty($value->song_url))
	    			{
	    				$args['song_url'] = url('/')."/storage/uploads/".$value->song_server_url;
	    			}	
	    			else
	    			{
	    				$args['song_url'] = $value->song_url;
	    			}
	    			if(empty($value->album_id))
	    			{
	    				$args['album_id'] = "";
	    			}
	    			else
	    			{
	    				$args['album_id'] = $value->album_id;
	    			}
	    			$args['image'] = url('/')."/storage/uploads/".$value->image;
	    			if(empty($value->genres_id))
	    			{
	    				$args['genres_id'] = "";	
	    			}
	    			else
	    			{
	    				$args['genres_id'] = $value->genres_id;
	    			}
	    			$getLikeStatus = Likes::where(['song_id'=>$value->song_id,'u_id' => $request->u_id])->first();
	                if(count($getLikeStatus)>0)
	                {
	                    if($getLikeStatus->like_status==1)
	                    {
	                        $args['like_status'] = 1;        
	                    }
	                    else
	                    {
	                        $args['like_status'] = 0;
	                    }
	                }
	                else
	                {
	                    $args['like_status'] = 0;
	                }
	                
	                $args['total_likes'] = Likes::where(['song_id'=>$value->song_id,'like_status'=>1])->count();
	    			$args['song_time'] = $value->song_time;
	    			array_push($temp,$args);
	    		}

    			$response = array(
	    			'status'=>1,
	    			'msg' => 'List of Hit singles.',
	    			'data' => $temp
	    		);
    		}
    		else
    		{
    			$response = array(
	    			'status'=>0,
	    			'msg' => 'No songs found.'
	    		);
    		}
    	}
    	else
    	{
    		$response = array(
    			'status'=>0,
    			'msg' => 'No such user exists.'
    		);
    	}

    	return $response;
    }
}
