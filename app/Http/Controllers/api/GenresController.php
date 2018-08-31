<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MusicGenres;
use App\Songs;
use App\api\Likes;
class GenresController extends Controller
{
    public function getGenres()
    {
    	$genres = MusicGenres::orderBy('genres_id','desc')->get();

    	if(count($genres)>0)
    	{
    		$temp = array();

    		foreach ($genres as $value) {
    			$args['category_id'] = $value->genres_id;
    			$args['category_name'] = $value->genres_name;
    			$args['image'] = url('/')."/storage/uploads/".$value->image;
    			array_push($temp, $args);
    		}

    		$response = array(
    			'status' => 1,
    			'msg' => 'List of Genres.',
    			'data' => $temp
    		);
    	}
    	else
    	{
    		$response = array(
    			'status' => 0,
    			'msg' => 'No category found.'
    		);

    	}

    	return $response;
    }

    public function getSongs(Request $request)
    {
    	$songs = Songs::where(['genres_id' => $request->genre_id])->orderBy('song_id','desc')->get();

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
    			$args['category_id'] = $value->genres_id;
    			$args['song_time'] = $value->song_time;
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

    			array_push($temp,$args);
    		}

    		$response = array(
    			'status' => 1,
    			'msg' => 'List of songs.',
    			'data' => $temp
    		);
    	}
    	else
    	{
    		$response = array(
    			'status' => 0,
    			'msg' => 'No songs found.'
    		);
    	}

    	return $response;
    }
}
