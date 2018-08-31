<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FeaturedDjs;
use App\api\NewUser;
use App\api\Likes;
use App\Songs;
class FeaturedDjsController extends Controller
{
    public function listDjs()
    {
    	$djs = FeaturedDjs::orderBy('feature_dj_id','desc')->get();

    	if(count($djs)>0)
    	{
    		$temp = array();
    		foreach ($djs as $value) 
    		{
    			$args['feature_dj_id'] = $value->feature_dj_id;
    			$args['name'] = $value->name;
    			$args['image'] = url('/')."/core/public/storage/uploads/".$value->image;
                $args['insta_url'] = $value->insta_url;                
    			array_push($temp, $args);
    		}

    		$response = array(
    				'status' => 1,
    				'msg' => 'List of djs.',
    				'data' => $temp
    			);
    	}
    	else
    	{
    		$response = array(
    				'status' => 0,
    				'msg' => 'No Djs found.'
    			);
    	}

    	return $response;
    }

    public function songsbydjs(Request $request)
    {
    	$checkUser = NewUser::where(['u_id'=>$request->u_id])->first();

    	if(count($checkUser)>0)
    	{
    		$songs = Songs::where(['feature_dj_id'=>$request->feature_dj_id])->orderBy('song_id','desc')->get();
    		if(count($songs)>0)
    		{
    			$temp = array();

    			foreach ($songs as $value) {
	    			$args['song_id'] = $value->song_id;
	    			$args['song_name'] = $value->song_name;
	    			$args['artist_name'] = $value->artist_name;
	    			$args['feature_dj_id'] = $value->feature_dj_id;
	    			if(empty($value->song_url))
	    			{
	    				$args['song_url'] = url('/')."/core/public/storage/uploads/".$value->song_server_url;
	    			}	
	    			else
	    			{
	    				$args['song_url'] = $value->song_url;
	    			}	    			
	    			$args['image'] = url('/')."/core/public/storage/uploads/".$value->image;	    			
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
	    			'msg' => 'List of songs..',
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
