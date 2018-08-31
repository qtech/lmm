<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\api\Favourites;
use App\api\Likes;
class FavsController extends Controller
{
    public function add(Request $request)
    {
        $checkIfSongExists = Favourites::where(['u_id'=>$request->u_id,'song_id'=>$request->song_id])->first();
        if(count($checkIfSongExists)>0)
        {
            $response = array(
                    'status' =>0,
                    'msg' => 'Song already exists in favourites.'
                );
        }
        else
        {
        	$fav = new Favourites;
        	$fav->u_id = $request->u_id;
        	$fav->song_id = $request->song_id;
        	$fav->save();

        	$response = array(
        			'status' =>1,
        			'msg' => 'Song added to favourites.'
        		);
        }

    	return $response;    	
    }

    public function getSongs(Request $request)
    {
    	$songs = Favourites::with('songs')->where(['u_id'=>$request->u_id])->get();

    	if(count($songs)>0)
    	{
    		$temp = array();
    		foreach ($songs as $value) 
    		{
    			$args['fav_id'] = $value->fav_id;
    			$args['u_id'] = $value->u_id;
    			$args['song_id'] = $value->song_id;
    			$args['song_name'] = @$value->songs->song_name;
                $args['artist_name'] = @$value->songs->artist_name;
    			if(empty($value->songs->song_url))
    			{
    				$args['song_url'] = url('/')."/storage/uploads/".@$value->songs->song_server_url;
    			}
    			else
    			{
    				$args['song_url'] = @$value->songs->song_url;
    			}
    			if(empty($value->song->album_id))
    			{
    				$args['album_id'] = "";
    			}
    			else
    			{
    				$args['album_id'] = @$value->songs->album_id;
    			}
    			$args['image'] = url('/')."/storage/uploads/".$value->songs->image;
    			if(empty($value->songs->genres_id))
    			{
    				$args['genres_id'] = "";	
    			}
    			else
    			{
    				$args['genres_id'] = @$value->songs->genres_id;
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
    			$args['song_time'] = @$value->songs->song_time;
    			array_push($temp,$args);      			  			
    		}

    		$response = array(
    				'status' => 1,
    				'msg' => 'List of favourite songs.',
    				'data' => $temp
    			);

    	}
    	else
    	{
    		$response = array(
    				'status' => 0,
    				'msg' => 'No favourite songs found.'
    			);
    	}
    	return $response;
    }

    public function removeSong(Request $request)
    {
    	$removeSong = Favourites::find($request->fav_id);
    	if(count($removeSong)>0)
    	{
    		$removeSong->delete();	
    		$response = array(
    			'status' =>1,
    			'msg' => 'Song removed from favourites.'
    		);
    	}
    	else
    	{
    		$response = array(
    			'status' =>0,
    			'msg' => 'No such song exists.'
    		);
    	}
    	return $response;
    }
}
