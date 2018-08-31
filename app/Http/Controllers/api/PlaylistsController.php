<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\api\Playlists;
use App\api\SongsInPlaylist;
use App\api\Likes;
class PlaylistsController extends Controller
{
    public function add(Request $request)
    {
    	$newPlaylist = new Playlists;
    	$newPlaylist->u_id = $request->u_id;
    	$newPlaylist->name = $request->name;
    	$newPlaylist->save();

    	$response = array(
    			'status' => 1,
    			'msg' => 'Playlist successfully created.',
                'playlist_id' => $newPlaylist->playlist_id   			
    		);

    	return $response;
    }

    public function user(Request $request)
    {
    	$user = Playlists::where(['u_id'=>$request->u_id])->get();
    	if(count($user)>0)
    	{
            $temp = array();
            foreach ($user as $value) 
            {
                $args['playlist_id'] = $value->playlist_id;
                $args['u_id'] = $value->u_id;
                $args['name'] = $value->name; 
                // $args['total_count'] =  SongsInPlaylist::where(['playlist_id'=>$value->playlist_id])->count();
                array_push($temp,$args);
            }
    		$response = array(
    				'status'=>1,
    				'msg' => 'User\'s playlists',
    				'data' => $temp
    			);
    	}
    	else
    	{
    		$response = array(
    				'status'=>0,
    				'msg' => 'No playlists found.'
    			);
    	}

    	return $response;
    }


    public function addSongToPlaylist(Request $request)
    {
        $checkIfSongExists = SongsInPlaylist::where(['playlist_id'=>$request->playlist_id,'u_id'=>$request->u_id,'song_id'=>$request->song_id])->first();

        if(count($checkIfSongExists)>0)
        {
            $response = array(
                    'status' => 0,
                    'msg' => 'Song already exists in this playlist.'
                );
        }
        else
        {
        	$newSip = new SongsInPlaylist;
        	$newSip->playlist_id = $request->playlist_id;
        	$newSip->u_id = $request->u_id;
        	$newSip->song_id = $request->song_id;
        	$newSip->save();

        	$response = array(
        			'status' => 1,
        			'msg' => 'Song added to playlist.'
        		);
        }

    	return $response;
    }

    public function getSongs(Request $request)
    {
    	$getsongs = SongsInPlaylist::with('songs')->where(['playlist_id'=>$request->playlist_id])->get();

    	if(count($getsongs)>0)
    	{
    		$temp = array();

    		foreach ($getsongs as $value) 
    		{
    			$args['sip_id'] = $value->sip_id;
    			$args['playlist_id'] = $value->playlist_id;
    			$args['song_id'] = $value->song_id;
                $args['artist_name'] = @$value->songs->artist_name;
    			$args['song_name'] = @$value->songs->song_name;
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
    			'msg' => 'List of songs.',
    			'data' => $temp
    		);
    	}
    	else
    	{
    		$response = array(
    			'status' => 0,
    			'msg' => 'No songs in this playlist.'
    		);
    	}

    	return $response;
    }

    public function removeSong(Request $request)
    {
    	$removeSong = SongsInPlaylist::find($request->sip_id);
    	$removeSong->delete();

    	$response = array(
    			'status'=>1,
    			'msg' =>'Song removed from playlist.'
    		);

    	return $response;
    }

    public function removePlaylist(Request $request)
    {
    	$removePlaylist = Playlists::find($request->playlist_id);       
        $removePlaylist->delete();

        $removeSongs = SongsInPlaylist::where(['playlist_id' => $request->playlist_id])->get();       
        if(count($removeSongs)>0)
        {
            foreach ($removeSongs as $value) {
                $remove = SongsInPlaylist::find($value->sip_id);
                $remove->delete();
            }
            
        }

        $response = array(
                'status' => 1,
                'msg' => 'Playlist successfully removed.'
            );

        return $response;
    }
}
